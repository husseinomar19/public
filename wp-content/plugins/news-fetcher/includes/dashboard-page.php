<?php
// Toont de dashboardpagina met nieuwsartikelen
function news_fetcher_page() {
    // Controleer op status in de URL en toon een bijbehorende melding
    if (isset($_GET['status'])) {
        $status = sanitize_text_field($_GET['status']);
        if ($status === 'success') {
            echo '<div class="notice notice-success is-dismissible"><p>Artikel succesvol toegevoegd!</p></div>';
        } elseif ($status === 'exists') {
            echo '<div class="notice notice-warning is-dismissible"><p>Artikel bestaat al!</p></div>';
        } elseif ($status === 'deleted') {
            echo '<div class="notice notice-success is-dismissible"><p>Artikel succesvol verwijderd!</p></div>';
        } elseif ($status === 'not_found') {
            echo '<div class="notice notice-error is-dismissible"><p>Artikel niet gevonden!</p></div>';
        }
    }

    // Haal nieuwsbronnen op
    $sources = fetch_news_articles();

    ?>
    <div class="wrap">
        <h1>News Fetcher</h1>
        <?php if (empty($sources)): ?>
            <p>Geen nieuwsbronnen beschikbaar. Controleer je instellingen of probeer later opnieuw.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($sources, 0, 10) as $source): ?>
                        <tr>
                            <td><?php echo esc_html($source['name']); ?></td>
                            <td>
                                <!-- Toevoegen als bericht -->
                                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" style="display: inline-block;">
                                    <input type="hidden" name="action" value="add_article">
                                    <input type="hidden" name="article_title" value="<?php echo esc_attr($source['name']); ?>">
                                    <input type="hidden" name="article_content" value="<?php echo esc_attr($source['description']); ?>">
                                    <input type="hidden" name="article_url" value="<?php echo esc_url($source['url']); ?>">
                                    <?php submit_button('Toevoegen als bericht', 'primary', 'add_article_btn'); ?>
                                </form>

                                <!-- Verwijderen -->
                                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" style="display: inline-block;">
                                    <input type="hidden" name="action" value="delete_article">
                                    <input type="hidden" name="article_title" value="<?php echo esc_attr($source['name']); ?>">
                                    <?php submit_button('Verwijderen', 'delete', 'delete_article_btn'); ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}
