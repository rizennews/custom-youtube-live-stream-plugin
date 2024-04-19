<?php
/*
Plugin Name: YouTube Live Stream Plugin
Plugin URI: https://example.com
Description: Custom Plugin to embed live streams from YouTube.
Version: 1.0
Author: Your Name
Author URI: https://example.com
*/

// Include plugin settings page
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

// Include plugin functions
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Include plugin widget
require_once plugin_dir_path(__FILE__) . 'includes/widget.php';

// Include plugin additional functions
require_once plugin_dir_path(__FILE__) . 'includes/additional-functions.php';
