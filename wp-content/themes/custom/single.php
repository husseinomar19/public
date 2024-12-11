<?php get_header(); // Laad de header.php ?>

<main id="main" class="site-main">
    <!-- De specifieke post -->
    <article class="post">
        <?php
        // Start de loop voor de huidige post
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <header>
                    <div class="title">
                        <h1><?php the_title(); ?></h1>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    <div class="meta">
                        <time class="published" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                        <a href="#" class="author">
                            <span class="name"><?php the_author(); ?></span>
                            <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?php the_author(); ?>" />
                        </a>
                    </div>
                </header>
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="image featured">
                        <?php the_post_thumbnail('full'); ?>
                    </a>
                <?php endif; ?>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile;
        else :
            echo '<p>Geen berichten gevonden.</p>';
        endif;
        ?>
    </article>

    <!-- Toon alle andere berichten -->
    <section class="all-posts">
        <h2>Andere berichten</h2>
        <?php
        // Query voor alle andere berichten
        $args = array(
            'post_type' => 'post', // Haal alleen berichten op
            'posts_per_page' => -1, // Haal alle berichten op
            'post__not_in' => array(get_the_ID()), // Exclude de huidige post
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); ?>
                <article class="post">
                    <header>
                        <div class="title">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php the_excerpt(); ?></p>
                        </div>
                        <div class="meta">
                            <time class="published" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                            <a href="#" class="author">
                                <span class="name"><?php the_author(); ?></span>
                                <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?php the_author(); ?>" />
                            </a>
                        </div>
                    </header>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="image featured">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                    <?php endif; ?>
                    <footer>
                        <ul class="actions">
                            <li><a href="<?php the_permalink(); ?>" class="button large">Lees verder</a></li>
                        </ul>
                        <ul class="stats">
                            <li><a href="#"><?php the_category(', '); ?></a></li>
                            <li><a href="#" class="icon solid fa-heart"><?php echo get_comments_number(); ?></a></li>
                            <li><a href="#" class="icon solid fa-comment"><?php echo get_comments_number(); ?></a></li>
                        </ul>
                    </footer>
                </article>
            <?php endwhile;
        else :
            echo '<p>Geen andere berichten gevonden.</p>';
        endif;

        // Herstel de oorspronkelijke postdata
        wp_reset_postdata();
        ?>
    </section>
</main>

