=== DX Info Widget for YouTube ===
Contributors: devrix
Tags: cache, subscribe,  video, video player, widget,  youtube, Youtube channel, youtube user, Youtube-video, youtube plugin
Requires at least: 3.0.1
Tested up to: 5.5.1
Stable tag: 2.4
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Author URI: https://devrix.com/

Embeds into a widget information about your YouTube channel: last uploads, popular uploads and statistics and summary with shortcodes tool.

== Description ==

This plugin allows you to embed information about your YouTube channel, including the last uploads, popular uploads, channel statistics including subscribers count, views count, and the about information, and also, a subscribe button next to your channel icon. Also supports shortcodes letting you generate more than a one to embed your YouTube channel cards.

**Features:**

Embed information and data about your YouTube channel in a channel card, including:

* An avatar and a link to your channel,
* A subscribe button,
* The last x uploads of your channel, if found,
* The top x popular uploads you have,
* information about your channel: about summary, total subscribers, total uploads, views and comments.

Also lets you easily generate more shortcodes to embed additional channel cards, use the shortcode generator admin tool.

<blockquote>

<p><strong>Channel Cards:</strong><br>
A widget, and YouTube channel cards you can generate and adjust through shortcodes. These cards contain tabs showing the last X uploads of the channel you are setting, the last popular uploads, channel information and everything is included with stats.</p>

<p><strong>Popup videos:</strong><br>
For the channel cards, videos in the last and popular tabs are icons showing a popup video on-click.</p>

<p><strong>Video Cards:</strong><br>
Video cards are like popup videos previously mentioned, but flat and not popups. To generate one, go to showcodes generator in your dashboard, and set the video ID, and what to show. Recommended that you leave elements attribute empty, so as to show the default content.</p>

<p><strong>Video Information:</strong><br>
Throughout shortcodes you can easily generate through the shortcodes generator tool, this one lets you embed dynamic information about your YouTube video, and store them and serve them.</p>

<p><strong>Channel Information:</strong><br>
This shortcode easy-to-generate gives you the power to embed more dynamic information and content about your channel. Again, to generate such shortcode, use the Shortcodes Generator tool for admin.</p>

</blockquote>

**How to use:**

After you install and activate the plugin, navigate to your widgets dashboard, and add a widget named "YouTube Information Widget". Quickly set it up by adding your account/channel username or slug or ID, and fill out the other optional options if needed.

As of 2.1, this plugin has added shortcodes tool, and which you can generate these shortcodes to use from settings > YIW Shortcode Gen. . Use the admin form there to generate as many shortcodes as you want, and add them anywhere around your site, like in a widget, post, page, PHP template ...


**How it works:**

This plugin uses <a href="https://developers.google.com/youtube/v3/">YouTube API V3</a> to retrieve dynamic data from feed URLs, and then, places those data in your options database to access, use and modify anytime. As those data are stored in the database, then this process is good for optimization and it is like caching and thus those data are renewed ( cache clearing process ) after X hours of your choice.

**Support:**

Post all of your support questions in the plugin <a href="http://wordpress.org/support/plugin/youtube-information-widget">support forum</a>, or by <a href="https://twitter.com/intent/tweet?text=@wpdevrix%20">tweeting to DevriX</a>, or by posting me a message throughout my contact form here <a href="https://devrix.com>DevriX</a>.

**Rate & Review:**

Wether you liked this plugin, enjoyed it, or you found a bug and you thought why not reporting it, please leave your reviews and feedbacks in the plugin <a href="http://wordpress.org/support/view/plugin-reviews/youtube-information-widget">reviews page</a>.
Thanks!

== Installation ==

* Install and activate the plugin:

1. Upload the plugin to your plugins directory, or use the WordPress installer.
2. Activate the plugin through the \'Plugins\' menu in WordPress.
3. Update settings, add the plugin widget and, Enjoy!

== Frequently Asked Questions ==

= How can I find my channel ID or username? =

If you can see your channel at all, the URL is in the browser address bar.
If you can find your channel in YouTube search, then search it and copy its link address, it should contain an ID. for instance: UCF0pVplsI8R5kcAqgtoRqoA ( youtube dot com /channel/UCF0pVplsI8R5kcAqgtoRqoA ) as a channel ID, and mullenweg ( youtube dot com /user/mullenweg ) as a username.

= Getting <code>Warning: file_get_contents(): https:// wrapper is disabled</code> error - What's next? =

If you are getting this kind of error after activating or using this plugin, then, you will need to modify your <code>php.ini</code> file to allow <a href="http://php.net/manual/en/filesystem.configuration.php">allow_url_fopen</a>. Set <code>allow_url_fopen</code> to 1:
<code>allow_url_fopen=1</code>
If you can't do that, or you can't access php.ini file, then, contact your webhost and ask them to modiy that for you.

For more support questions, please start your own topic [here](http://wordpress.org/support/plugin/youtube-information-widget).

== Screenshots ==

1. Plugin's widget in the widgets area.
2. Last uploads tab.
3. Popular uploads tab.
4. Channel information ( summary ) tab.
5. Shortcodes generator.

== Upgrade Notice ==
The plugin ownership was transferred to DevriX. There are no functionality changes. We are going to work on a few version, adding some nice feature in the near feature, stay tuned! :)

== Changelog ==

= 1.0 =
* Initial ( Beta ) release.

= 1.1 =
* fixed encoding issue.

= 1.2 =
* Fixing wp.org plugin author related issues.

= 2.0 =
* Rewritten plugin from scratch, improved caching and performance.

= 2.1 =
* Improved even more, added shortcodes tool.

= 2.2 =
* Unlocked more cool features.

= 2.3 =
* Code refactor and change trade name
* This is not Major release

= 2.4 =
* Tested to WordPress 5.5.1 version
* Fixed API key
* Fixed PHP errors and Sanitezed 