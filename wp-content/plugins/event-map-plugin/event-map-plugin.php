<?php
/*
Plugin Name: Event Map Plugin
Description: Een plugin om evenementen op een kaart te tonen via een formulier.
Version: 1.0
Author: Jouw Naam
*/

// Direct toegang blokkeren
if (!defined('ABSPATH')) {
    exit;
}

// De hoofdklasse van de plugin
class EventMapPlugin {
    public function __construct() {
        add_action('admin_menu', [$this, 'create_settings_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_save_event', [$this, 'save_event']);
        add_shortcode('event_map', [$this, 'render_event_map']);
    }

    public function create_settings_page() {
        add_menu_page(
            'Event Map Settings',
            'Event Map',
            'manage_options',
            'event-map-plugin',
            [$this, 'render_settings_page'],
            'dashicons-location-alt'
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Event Map Settings</h1>
            <form id="event-form">
                <table class="form-table">
                    <tr>
                        <th><label for="event_name">Event Naam</label></th>
                        <td><input type="text" id="event_name" name="event_name" required /></td>
                    </tr>
                    <tr>
                        <th><label for="event_time">Tijd</label></th>
                        <td><input type="time" id="event_time" name="event_time" required /></td>
                    </tr>
                    <tr>
                        <th><label for="event_location">Locatie</label></th>
                        <td><input type="text" id="event_location" name="event_location" required /></td>
                    </tr>
                    <tr>
                        <th><label for="event_cost">Kosten</label></th>
                        <td><input type="number" id="event_cost" name="event_cost" required /></td>
                    </tr>
                </table>
                <input type="hidden" name="action" value="save_event">
                <?php wp_nonce_field('save_event_nonce', 'event_nonce'); ?>
                <button type="submit" class="button button-primary">Opslaan</button>
            </form>
            <div id="event-map" style="height: 400px; margin-top: 20px;"></div>
        </div>
        <?php
    }

    public function enqueue_scripts($hook) {
        if ($hook !== 'toplevel_page_event-map-plugin') {
            return;
        }

        // Google Maps API vervangen door jouw API-sleutel
        wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY', [], null, true);
        wp_enqueue_script('event-map-plugin-js', plugin_dir_url(__FILE__) . 'js/event-map-plugin.js', ['jquery', 'google-maps'], '1.0', true);

        wp_localize_script('event-map-plugin-js', 'eventMapData', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('save_event_nonce'),
        ]);
    }

    public function save_event() {
        check_ajax_referer('save_event_nonce', 'event_nonce');

        $event_data = [
            'name' => sanitize_text_field($_POST['event_name']),
            'time' => sanitize_text_field($_POST['event_time']),
            'location' => sanitize_text_field($_POST['event_location']),
            'cost' => floatval($_POST['event_cost']),
        ];

        update_option('event_map_data', $event_data);

        wp_send_json_success($event_data);
    }

    public function render_event_map() {
        $event_data = get_option('event_map_data');
        if (!$event_data) {
            return '<p>Geen evenement beschikbaar.</p>';
        }

        ob_start();
        ?>
        <div id="event-map-shortcode" style="height: 400px;"></div>
        <script>
            var eventMapData = <?php echo json_encode($event_data); ?>;
        </script>
        <?php
        return ob_get_clean();
    }
}

new EventMapPlugin();
