<?php get_header(); // Laad de header.php ?>

<main id="main" class="site-main">
    <header>
        <h1>Zoekresultaten voor: "<?php echo get_search_query(); ?>"</h1>
    </header>

    <?php if (have_posts()) : ?>
        <section class="search-results">
            <?php
            while (have_posts()) : the_post(); ?>
                <article class="post">
                    <header>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php the_excerpt(); ?></p>
                    </header>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="image featured">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        </section>

        <!-- Navigatie voor meer resultaten -->
        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <section class="no-results">
            <h2>Geen resultaten gevonden</h2>
            <p>Probeer een andere zoekterm.</p>
            <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="text" name="s" placeholder="Search" value="<?php echo get_search_query(); ?>" />
                <button type="submit">Search</button>
            </form>
        </section>
    <?php endif; ?>
</main>

