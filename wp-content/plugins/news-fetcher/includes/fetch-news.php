<?php
// Functie om nieuwsartikelen op te halen van de News API
function fetch_news_articles() {
    $api_key = '6d64494dcf3e4adeb406374fb13ab6ef'; // News API-sleutel
    $response = wp_remote_get("https://newsapi.org/v2/top-headlines/sources?country=us&category=general&apiKey=$api_key");

    if (is_wp_error($response)) {
        error_log('API Error: ' . print_r($response->get_error_message(), true));
        return [];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Log de volledige API-response voor debuggen
    if (isset($data['status']) && $data['status'] === 'error') {
        error_log('API Error Response: ' . print_r($data, true));
    }

    return $data['sources'] ?? []; // Gebruik 'sources' in plaats van 'articles'
}
