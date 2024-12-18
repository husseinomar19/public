<?php
// Actie voor het toevoegen van een artikel
add_action('admin_post_add_article', 'handle_add_article');

function handle_add_article() {
    // Controleer of de vereiste gegevens aanwezig zijn
    if (!isset($_POST['article_title'], $_POST['article_content'], $_POST['article_url'])) {
        wp_die('Ongeldige invoer.');
    }

    // Controleer of het artikel al bestaat in WordPress met WP_Query
    $query = new WP_Query([
        'title'         => sanitize_text_field($_POST['article_title']),
        'post_type'     => 'post',
        'post_status'   => 'any',
        'posts_per_page'=> 1,
    ]);

    if ($query->have_posts()) {
        wp_redirect(admin_url('admin.php?page=news-fetcher&status=exists'));
        exit;
    }

    // Voeg het artikel toe als een WordPress-bericht
    $post_data = [
        'post_title'   => sanitize_text_field($_POST['article_title']),
        'post_content' => sanitize_text_field($_POST['article_content']) . '<br><a href="' . esc_url($_POST['article_url']) . '" target="_blank">Lees meer</a>',
        'post_status'  => 'draft', // Stel in als concept
        'post_author'  => get_current_user_id(),
        'post_type'    => 'post',
    ];

    wp_insert_post($post_data);

    // Redirect terug naar de dashboardpagina met een succesmelding
    wp_redirect(admin_url('admin.php?page=news-fetcher&status=success'));
    exit;
}

// Actie voor het verwijderen van een artikel
add_action('admin_post_delete_article', 'handle_delete_article');

function handle_delete_article() {
    // Controleer of de titel van het artikel is doorgegeven
    if (!isset($_POST['article_title'])) {
        wp_die('Ongeldige invoer.');
    }

    // Zoek het bericht op aan de hand van de titel met WP_Query
    $title = sanitize_text_field($_POST['article_title']);
    $query = new WP_Query([
        'title'         => $title,
        'post_type'     => 'post',
        'post_status'   => 'any',
        'posts_per_page'=> 1,
    ]);

    if ($query->have_posts()) {
        $post = $query->posts[0];

        // Verwijder het bericht permanent
        wp_delete_post($post->ID, true);
        wp_redirect(admin_url('admin.php?page=news-fetcher&status=deleted'));
    } else {
        wp_redirect(admin_url('admin.php?page=news-fetcher&status=not_found'));
    }
    exit;
}
