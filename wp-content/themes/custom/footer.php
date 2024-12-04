
<!-- Footer -->
<footer>
<section id="footer">
<?php
    if (has_nav_menu('links_menu')) {
        wp_nav_menu(array(
            'theme_location' => 'links_menu',
            'container' => false, // Geen extra container
            'menu_class' => '', // Geen extra CSS-klasse
            'items_wrap' => '<ul>%3$s</ul>', // Verwijdert standaard wrapping
            'fallback_cb' => false, // Geen fallback-menu tonen
        ));
    } else {
        echo '<ul><li><a href="#">Menu niet ingesteld</a></li></ul>';
    }
    ?>
		<p class="copyright">&copy; Untitled.</p>
		</section>
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
