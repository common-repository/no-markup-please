<?php
/*
  Plugin Name: No Markup Please
  Plugin URI: wordpress.org/plugins/no-markup-please
  Description: Stop visitors posting too much code in comments
  Version: 1.0.1
  Author: EnigmaWeb
  Author URI: https://profiles.wordpress.org/enigmaweb/
  Text Domain: no-markup-please
  Domain Path: /languages
 */

class NMP {

    function __construct() {

        // Register menu
        add_action('admin_menu', array($this, 'nmp_admin_menu'));

        // Register WP Head
        add_action('wp_head', array($this, 'nmp_no_markup'));

        // Register ajax
        add_action('wp_ajax_nmp_process_ajax', array($this, 'nmp_process_func'));
        add_action('wp_ajax_nopriv_nmp_process_ajax', array($this, 'nmp_process_func'));

        // Plugin Settings
        add_action('admin_init', array($this, 'nmp_settings'));
    }

    // Register plugin setting
    function nmp_settings() {
        register_setting('nmp_plugin_setting', 'nmp_delimiters_limit');
        register_setting('nmp_plugin_setting', 'nmp_error_message');
    }

// Add admin menu
    function nmp_admin_menu() {
        add_submenu_page('options-general.php', 'No Markup Please Settings', 'No Markup Please', 'manage_options', 'nmp_settings', array($this, 'nmp_settings_page'));
    }

    // Settings page
    function nmp_settings_page() {

        echo '<div class="wrap">';
        echo '<h1>' . get_admin_page_title() . '</h1>';
        ?>
        <form action="options.php" method="post">

            <?php settings_fields('nmp_plugin_setting'); ?>
            <table width="50%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 18px;">
                <tr>
                    <td><h4><label><?php _e('Delimiters Limit', 'no-markup-please') ?></label></h4></td>
                    <td><input type="number" name="nmp_delimiters_limit" value="<?php echo get_option('nmp_delimiters_limit') ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:0 0 30px"><em><?php _e('Set the number of <a href="http://php.net/manual/en/regexp.reference.delimiters.php" target="_blank">delimiters</a> you will allow in comments before triggering the error message below.', 'no-markup-please') ?></em></td>
                </tr>
                <tr>
                    <td style="padding:0 0 30px"><h4><label><?php _e('Error Message', 'no-markup-please') ?></label></h4></td>
                    <td style="padding:0 0 30px"><textarea name="nmp_error_message" style="width:100%; height:150px; padding:10px; resize:none " ><?php echo get_option('nmp_error_message') ?></textarea></td>
                </tr>
                <tr>
                    <td><input type="submit" value="<?php _e('Save Changes', 'no-markup-please'); ?>" name="submit" id="submit" class="button button-primary"></td>
                </tr>
            </table>
        </form>
        <?php
        echo '</div>';
    }

    // WP Head
    function nmp_no_markup() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('form').submit(function () {

                    // Getting comment value
                    var comment = jQuery('#comment').val();

                    // Variable for return value
                    var nmp_returnval = false;

                    // Ajax call
                    jQuery.ajax({
                        method: "POST",
                        async: false, // Solve return value issue
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data: 'action=nmp_process_ajax&comment=' + comment,
                        success: function (nmp_res) {
                            nmp_count = nmp_res;
                            if (nmp_count > <?php echo get_option('nmp_delimiters_limit') ?>) {
                                jQuery('.nmp_error').remove();
                                jQuery("#comment").after('<span class="nmp_error"><?php echo str_replace("'", "&#39", get_option("nmp_error_message")) ?></span>');
                                nmp_returnval = false;
                            } else {
                                nmp_returnval = true;
                            }
                        }
                    });
                    // Prevent default submission form
                    return nmp_returnval;
                });
            });
        </script>
        <style type="text/css">
            .nmp_error{
                border-left: 4px solid red;
                background: #F4EFEF;
                margin-top: 12px;
                padding: 5px 10px 5px 12px;
                color: #666;
                display: block;
                font-size: 14px;
                font-family: Arial;
                font-weight: 600;
                width: 100%;
            }
        </style>
        <?php
    }

    // Ajax request function
    function nmp_process_func() {

        @$comment = $_POST['comment'];

        // Regex pattern to find delimiters in comments textarea
        preg_match_all("/(->|;|=|<|>|{|})/", $comment, $matches, PREG_SET_ORDER);

        // Variable to count the number of delimiters
        $count = 0;
        foreach ($matches as $val) {
            $count++;
        }
        echo $count;

        // Use for excluding 0 when return $count to Ajax response
        wp_die();
    }

}

new NMP;
