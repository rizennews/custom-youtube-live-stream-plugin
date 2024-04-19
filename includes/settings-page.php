<?php
// Add plugin settings page
function youtube_live_stream_plugin_settings_page() {
    add_options_page(
        'YouTube Live Stream Plugin Settings',
        'YouTube Live Settings',
        'manage_options',
        'youtube-live-stream-plugin-settings',
        'youtube_live_stream_plugin_settings_page_content'
    );
}
add_action('admin_menu', 'youtube_live_stream_plugin_settings_page');

// Render plugin settings page content
function youtube_live_stream_plugin_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>YouTube Live Stream Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('youtube_live_stream_settings_group'); ?>
            <?php do_settings_sections('youtube-live-stream-plugin-settings'); ?>
            <?php submit_button('Save Settings'); ?>
        </form>
        <p>To display the YouTube Live stream on your website, use the following shortcode on any page or post:</p>
        <pre>[youtube_live_stream]</pre>
        <p>Make sure to configure your YouTube API Key and Channel ID below.</p>
        <p>If you find this plugin helpful, consider buying us a coffee!</p>
        <a href="https://www.buymeacoffee.com/designolabs" target="_blank"><img src="https://img.buymeacoffee.com/button-api/?text=Buy%20us%20a%20coffee&emoji=&slug=yourusername&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff">
    </a>
        <p>This plugin was developed by <a href="https://github.com/rizennews/" target="_blank">Designolabs Studio</a>.</p>
    </div>
    <?php
}

// Initialize plugin settings
function youtube_live_stream_plugin_initialize_settings() {
    register_setting(
        'youtube_live_stream_settings_group',
        'youtube_api_key'
    );
    register_setting(
        'youtube_live_stream_settings_group',
        'youtube_channel_id'
    );

    add_settings_section(
        'youtube_live_stream_settings_section',
        'YouTube Live Stream Settings',
        'youtube_live_stream_settings_section_callback',
        'youtube-live-stream-plugin-settings'
    );

    add_settings_field(
        'youtube_api_key_field',
        'YouTube API Key',
        'youtube_api_key_field_callback',
        'youtube-live-stream-plugin-settings',
        'youtube_live_stream_settings_section'
    );
    add_settings_field(
        'youtube_channel_id_field',
        'YouTube Channel ID',
        'youtube_channel_id_field_callback',
        'youtube-live-stream-plugin-settings',
        'youtube_live_stream_settings_section'
    );
}
add_action('admin_init', 'youtube_live_stream_plugin_initialize_settings');

// Callback function to render YouTube API Key field
function youtube_api_key_field_callback() {
    $apiKey = get_option('youtube_api_key');
    echo '<input type="text" name="youtube_api_key" value="' . esc_attr($apiKey) . '" />';
}

// Callback function to render YouTube Channel ID field
function youtube_channel_id_field_callback() {
    $channelId = get_option('youtube_channel_id');
    echo '<input type="text" name="youtube_channel_id" value="' . esc_attr($channelId) . '" />';
}

// Callback function to render YouTube Live Stream Settings section
function youtube_live_stream_settings_section_callback() {
    echo '<p>Enter your YouTube API Key and Channel ID below. You can obtain an API key from the 
    Google Developer Console and find your Channel ID in the URL of your YouTube channel.</p>';
}
