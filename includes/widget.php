<?php
// YouTube Live Stream Widget
class YouTubeLiveStreamWidget extends WP_Widget {

    // Constructor
    function __construct() {
        parent::__construct(
            'youtube_live_stream_widget',
            __('YouTube Live Stream Widget', 'youtube_live_stream_widget_domain'),
            array('description' => __('Display YouTube Live Stream in your sidebar', 'youtube_live_stream_widget_domain'))
        );
    }

    // Widget Frontend
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        // Widget Output
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<div class="youtube-live-stream-widget">';
        echo displayYouTubeLiveStream(); // Call the function to display the YouTube live stream
        echo '</div>';
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('YouTube Live Stream', 'youtube_live_stream_widget_domain');
        }
        ?>
        <!-- Widget Title Field -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

    // Update Widget
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

// Register YouTube Live Stream Widget
function register_youtube_live_stream_widget() {
    register_widget('YouTubeLiveStreamWidget');
}
add_action('widgets_init', 'register_youtube_live_stream_widget');
