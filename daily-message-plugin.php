<?php
/*
Plugin Name: Daily Message Plugin
Description: A plugin to display daily messages on the home page with GitHub updates.
Version: 1.0
Author: Your Name
Update URI: https://github.com/yourusername/daily-message-plugin/releases/latest/download/
*/

// Add admin menu
function daily_message_menu() {
    add_menu_page('Daily Message', 'Daily Message', 'manage_options', 'daily-message', 'daily_message_page');
}
add_action('admin_menu', 'daily_message_menu');

// Admin page content
function daily_message_page() {
    ?>
    <div class="wrap">
        <h1>Daily Message</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('daily_message_options');
            do_settings_sections('daily_message');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function daily_message_settings() {
    register_setting('daily_message_options', 'daily_message');
    add_settings_section('daily_message_section', 'Message Settings', 'daily_message_section_callback', 'daily_message');
    add_settings_field('daily_message_field', 'Today\'s Message', 'daily_message_field_callback', 'daily_message', 'daily_message_section');
}
add_action('admin_init', 'daily_message_settings');

function daily_message_section_callback() {
    echo 'Enter the daily message below:';
}

function daily_message_field_callback() {
    $message = get_option('daily_message');
    echo "<textarea name='daily_message' rows='5' cols='50'>" . esc_textarea($message) . "</textarea>";
}

// Display message on home page
function display_daily_message() {
    if (is_home() || is_front_page()) {
        $message = get_option('daily_message');
        echo "<div class='daily-message'>" . esc_html($message) . "</div>";
    }
}
add_action('wp_footer', 'display_daily_message');