<?php
/**
 * Plugin Name: Custom YouTube Live Stream Plugin
 * Plugin URI: https://github.com/rizennews/custom-youtube-live-stream-plugin
 * Description: Custom Plugin to embed YouTube Live streams.
 * Version: 1.0
 * Author: Designolabs Studio
 * Author URI: https://github.com/rizennews/
**/

// Function to fetch YouTube Live stream embed code
function getYouTubeLiveEmbedCode($apiKey) {
    // YouTube Channel ID
    $channelId = get_option('custom_youtube_channel_id');

    // Construct URL for YouTube Data API
    $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId={$channelId}&eventType=live&type=video&key={$apiKey}";

    // Make request to YouTube Data API
    $response = file_get_contents($url);

    // Decode JSON response
    $data = json_decode($response, true);

    // Check if live video data exists
    if (isset($data['items'][0]['id']['videoId'])) {
        $videoId = $data['items'][0]['id']['videoId'];
        return "https://www.youtube.com/embed/{$videoId}";
    } else {
        return false;
    }
}

// Function to generate HTML output with embedded live stream
function displayYouTubeLiveStream() {
    // YouTube API Key (Generate one from Google Developer Console)
    $youtubeApiKey = get_option('custom_youtube_api_key');

    // Get YouTube Live embed code
    $youtubeEmbedCode = getYouTubeLiveEmbedCode($youtubeApiKey);

    // Generate HTML output with embedded live stream
    if ($youtubeEmbedCode) {
        $output = '<div class="youtube-live-stream">';
        $output .= '<h2>YouTube Live Stream</h2>';
        $output .= '<iframe width="560" height="315" src="' . $youtubeEmbedCode . '" frameborder="0" allowfullscreen></iframe>';
        $output .= '</div>';
        return $output;
    } else {
        return '<p>No live stream available at the moment.</p>';
    }
}

// Shortcode to display YouTube Live stream
function youtubeLiveStreamShortcode() {
    return displayYouTubeLiveStream();
}
add_shortcode('youtube_live_stream', 'youtubeLiveStreamShortcode');

// Add plugin settings page
function custom_youtube_plugin_settings_page() {
    add_options_page(
        'Custom YouTube Live Stream Plugin Settings',
        'YouTube Live Settings',
        'manage_options',
        'custom-youtube-live-stream-plugin',
        'custom_youtube_plugin_settings_page_content'
    );
}
add_action('admin_menu', 'custom_youtube_plugin_settings_page');

// Render plugin settings page content
function custom_youtube_plugin_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>Custom YouTube Live Stream Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('custom_youtube_settings_group'); ?>
            <?php do_settings_sections('custom-youtube-live-stream-plugin'); ?>
            <?php submit_button('Save Settings'); ?>
        </form>
        <p>To display the YouTube Live stream on your website, use the following shortcode on any page or post:</p>
        <pre>[youtube_live_stream]</pre>
        <p>Make sure to configure your YouTube API Key and Channel ID below.</p>
        <p>If you find this plugin helpful, consider buying us a coffee!</p>
        <a href="https://www.buymeacoffee.com/designolabs" target="_blank"><img src="https://img.buymeacoffee.com/button-api/?text=Buy%20us%20a%20coffee&emoji=&slug=designolabs&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff"></a>
        <p>This plugin was developed by <a href="https://github.com/rizennews/" target="_blank">Designolabs Studio</a>.</p>
    </div>
    <?php
}

// Initialize plugin settings
function custom_youtube_plugin_initialize_settings() {
    register_setting(
        'custom_youtube_settings_group',
        'custom_youtube_api_key'
    );
    register_setting(
        'custom_youtube_settings_group',
        'custom_youtube_channel_id'
    );

    add_settings_section(
        'custom_youtube_settings_section',
        'YouTube Live Stream Settings',
        'custom_youtube_settings_section_callback',
        'custom-youtube-live-stream-plugin'
    );

    add_settings_field(
        'custom_youtube_api_key_field',
        'YouTube API Key',
        'custom_youtube_api_key_field_callback',
        'custom-youtube-live-stream-plugin',
        'custom_youtube_settings_section'
    );
    add_settings_field(
        'custom_youtube_channel_id_field',
        'YouTube Channel ID',
        'custom_youtube_channel_id_field_callback',
        'custom-youtube-live-stream-plugin',
        'custom_youtube_settings_section'
    );
}
add_action('admin_init', 'custom_youtube_plugin_initialize_settings');

// Callback function to render YouTube API Key field
function custom_youtube_api_key_field_callback() {
    $apiKey = get_option('custom_youtube_api_key');
    echo '<input type="text" name="custom_youtube_api_key" value="' . esc_attr($apiKey) . '" />';
}

// Callback function to render YouTube Channel ID field
function custom_youtube_channel_id_field_callback() {
    $channelId = get_option('custom_youtube_channel_id');
    echo '<input type="text" name="custom_youtube_channel_id" value="' . esc_attr($channelId) . '" />';
}

// Callback function to render YouTube Live Stream Settings section
function custom_youtube_settings_section_callback() {
    echo '<p>Enter your YouTube API Key and Channel ID below. You can obtain an API key from the Google Developer Console and find your Channel ID in the URL of your YouTube channel.</p>';
}
