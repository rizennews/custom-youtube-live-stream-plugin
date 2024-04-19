<?php
// Function to fetch YouTube Live stream embed code
function getYouTubeLiveEmbedCode($apiKey, $channelId) {
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
    // YouTube API Key (Obtain one from Google Developer Console)
    $youtubeApiKey = get_option('youtube_api_key');
    $channelId = get_option('youtube_channel_id');

    // Get YouTube Live embed code
    $youtubeEmbedCode = getYouTubeLiveEmbedCode($youtubeApiKey, $channelId);

    // Generate HTML output with embedded live stream
    if ($youtubeEmbedCode) {
        $output = '<div class="youtube-live-stream">';
        $output .= '<h2>YouTube Live Stream</h2>';
        $output .= '<iframe width="560" height="315" src="' . $youtubeEmbedCode . '" frameborder="0" allowfullscreen></iframe>';
        $output .= '</div>';
        return $output;
    } else {
        return handleYouTubeError();
    }
}

// Shortcode to display YouTube Live stream
function youtubeLiveStreamShortcode() {
    return displayYouTubeLiveStream();
}
add_shortcode('youtube_live_stream', 'youtubeLiveStreamShortcode');

