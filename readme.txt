=== No Markup Please ===
Contributors: EnigmaWeb
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CEJ9HFWJ94BG4
Tags: comments, markup, code, stop code in comments, no markup
Requires at least: 3.1
Tested up to: 4.7.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

No Markup Please - stop visitors posting too much code in comments

== Description ==

It can be annoying when visitors post large blocks of code in a comment. "No Markup Please" plugin checks comment submissions for markup and if there is too much code it will trigger an error message of your choice.

= Here's the error message I like to use: =
Hey thanks for your comment but you've posted a large amount of code which makes comments hard to read for everyone else. How about using [Pastebin](http://pastebin.com/) instead?


== Installation ==

1. Upload the `no-markup-please` folder to the `/wp-content/plugins/` directory
1. Activate the No Markup Please plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by going to Settings > No Markup Please
 
== Frequently Asked Questions ==

= How does it work? =

Super simple! Comment submissions are parsed for [delimiters](http://php.net/manual/en/regexp.reference.delimiters.php). If there are too many, it triggers the error message.

= Where can I get support for this plugin? =

If you've tried all the obvious stuff and it's still not working please request support via the forum.


== Screenshots ==

1. An example of No Markup Please in action on a comment that included a large block of markup.
2. The settings screen in WP-Admin

== Changelog ==

= 1.0.1 =
* Jquery issue fixed.
* Apostrophe issue fixed.

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0.1 =
* Jquery issue fixed.
* Apostrophe issue fixed.

= 1.0 =
* Initial release
