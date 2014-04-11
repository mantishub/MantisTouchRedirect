MantisTouch Redirect
====================

A plugin that automatically redirects from MantisBT to MantisTouch when a user is accessing
MantisBT from a mobile browser.  This plugin is designed to replace the $g_mantistouch_url
config option in MantisBT v1.2.x.

This can be used along with your licensed instance of MantisTouch or the demo instance at
http://mantisbt.mobi

To disable the redirection, uninstall the plugin.

For more details about MantisTouch visit http://www.mantistouch.org

Install
-------
- Download or clone the repository and place it under the MantisBT plugins folder.
- Go to Manage - Manage Plugins and install the plugin.
- If MantisTouch is installed under 'm' subfolder, then set $g_mantistouch_url to '' in config_inc.php for MantisBT.
- If MantisTouch is not installed under 'm' subfolder, then click on Plugin Name and set the MantisTouch URL or leave it blank to use http://mantisbt.mobi/.

Pages that redirect
-------------------
- Login Page
- View Issues Page
- My View Page
- Issue Report Page
- Issue View Page - redirects to same issue within MantisTouch

Limitations
-----------
- MantisTouch doesn't support anonymous access.
