<?php
// Error Handling Function
function handleYouTubeError() {
    return '<p>There was an error fetching the YouTube live stream data. Please try again later.</p>';
}

// Caching Function
function getYouTubeLiveStreamData($apiKey, $channelId) {
    $cache_key = 'youtube_live_stream_' . $channelId;
    $liveStreamId = get_transient($cache_key);

    if (false === $liveStreamId) {
        // Construct URL for YouTube Data API
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId={$channelId}&eventType=live&type=video&key={$apiKey}";

        // Make request to YouTube Data API
        $response = file_get_contents($url);

        // Decode JSON response
        $data = json_decode($response, true);

        // Check if live video data exists
        if (isset($data['items'][0]['id']['videoId'])) {
            $liveStreamId = $data['items'][0]['id']['videoId'];
            // Cache the data for 1 hour
            set_transient($cache_key, $liveStreamId, HOUR_IN_SECONDS);
        } else {
            $liveStreamId = false;
        }
    }

    return $liveStreamId;
}

// Compatibility Function
function checkYouTubeLiveStreamCompatibility() {
    // Check if the active theme is Hello Elementor
    $theme = wp_get_theme();
    $theme_name = $theme->get('Name');
    if ($theme_name === 'Hello Elementor') {
        // Provide guidance on using the plugin with the Hello Elementor theme
        echo '<p>For optimal performance with the Hello Elementor theme, make sure to enable the plugin settings in the theme options panel.</p>';
    }

    // Check if the yt-live-stream plugin is active
    if (is_plugin_active('yt-live-stream/yt-live-stream.php')) {
        // Provide guidance on using the plugin with the yt-live-stream plugin
        echo '<p>For compatibility with the yt-live-stream plugin, ensure that the plugin settings are configured correctly in the yt-live-stream settings page.</p>';
    }

    // Add more compatibility checks as needed
    // Check for other themes or plugins and provide guidance accordingly
}


// Security Function
function sanitizeYouTubeLiveStreamData($data) {
    // Sanitize the data fetched from YouTube before displaying it
    return wp_kses_post($data);
}

// Feedback Function
function displayYouTubeFeedbackForm() {
    ?>
    <div class="youtube-feedback-form">
        <h2>Feedback Form</h2>
        <p>We value your feedback! Please use the form below to submit your suggestions and requests:</p>
        <form id="youtube-feedback-form" method="post">
            <label for="feedback-name">Name:</label>
            <input type="text" id="feedback-name" name="feedback-name" required>
            <label for="feedback-email">Email:</label>
            <input type="email" id="feedback-email" name="feedback-email" required>
            <label for="feedback-message">Message:</label>
            <textarea id="feedback-message" name="feedback-message" rows="4" required></textarea>
            <input type="submit" value="Submit">
        </form>
    </div>
    <?php
}

