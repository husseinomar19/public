<?php
/*
Plugin Name: News Fetcher
Description: Haalt nieuws op van een API en voegt ze toe als berichten in WordPress.
Version: 1.0
Author: Jouw Naam
*/

// Zet een constante voor de plugin-path
define('NEWS_FETCHER_PATH', plugin_dir_path(__FILE__));

// Laad de benodigde bestanden
require_once NEWS_FETCHER_PATH . 'includes/dashboard-page.php';
require_once NEWS_FETCHER_PATH . 'includes/fetch-news.php';
require_once NEWS_FETCHER_PATH . 'includes/add-article.php';

// Voeg de admin menu toe
add_action('admin_menu', 'news_fetcher_menu');

function news_fetcher_menu() {
    add_menu_page(
        'News Fetcher',     // Titel in de browser-tab
        'News Fetcher',     // Titel in de zijbalk
        'manage_options',   // Toestemmingsniveau
        'news-fetcher',     // Slug
        'news_fetcher_page' // Callback-functie
    );
}
