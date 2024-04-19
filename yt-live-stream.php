<?php
/*
Plugin Name: YouTube Live Stream Plugin
Plugin URI: https://github.com/rizennews/custom-youtube-live-stream-plugin/
Description: Embed live streams from YouTube effortlessly on your WordPress website with the YouTube Live Stream Plugin. Customize the appearance and behavior of your embedded streams using simple shortcodes and widget options. Stay connected with your audience in real-time and enhance your website's engagement with this easy-to-use plugin.
Version: 1.0
Author: Padmore Aning
Author URI: https://github.com/rizennews
*/

// Include plugin settings page
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

// Include plugin functions
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Include plugin widget
require_once plugin_dir_path(__FILE__) . 'includes/widget.php';

// Include plugin additional functions
require_once plugin_dir_path(__FILE__) . 'includes/additional-functions.php';
