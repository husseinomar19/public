<?php get_header(); ?>

				<!-- Menu -->
					<section id="menu">

						<!-- Search -->
							<section>
								<form class="search" method="get" action="#">
									<input type="text" name="query" placeholder="Search" />
								</form>
							</section>

						<!-- Links -->
							<section>
								<ul class="links">
									<li>
										<a href="#">
											<h3>Lorem ipsum</h3>
											<p>Feugiat tempus veroeros dolor</p>
										</a>
									</li>
									<li>
										<a href="#">
											<h3>Dolor sit amet</h3>
											<p>Sed vitae justo condimentum</p>
										</a>
									</li>
									<li>
										<a href="#">
											<h3>Feugiat veroeros</h3>
											<p>Phasellus sed ultricies mi congue</p>
										</a>
									</li>
									<li>
										<a href="#">
											<h3>Etiam sed consequat</h3>
											<p>Porta lectus amet ultricies</p>
										</a>
									</li>
								</ul>
							</section>

						<!-- Actions -->
							<section>
								<ul class="actions stacked">
									<li><a href="#" class="button large fit">Log In</a></li>
								</ul>
							</section>

					</section>

				<!-- Main -->
<div id="main">

						<!-- Post -->
						<?php
// Maak een nieuwe WP_Query om alle berichten op te halen
$args = array(
    'post_type' => 'post', // Haal alleen berichten op
    'posts_per_page' => -1, // Haal alle berichten op
);

$query = new WP_Query($args);

// Controleer of er berichten zijn
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post(); // Loop door de berichten
        ?>
        <article class="post">
            <header>
                <div class="title">
                    <!-- De titel van het bericht met een link naar de detailpagina -->
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <!-- De excerpt van het bericht (beschrijving) -->
                    <p><?php the_excerpt(); ?></p>
                </div>
                <div class="meta">
                    <!-- De publicatiedatum van het bericht -->
                    <time class="published" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                    <!-- De auteur van het bericht -->
                    <a href="#" class="author">
                        <span class="name"><?php the_author(); ?></span>
                        <!-- Optioneel: voeg een afbeelding toe voor de auteur -->
                        <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?php the_author(); ?>" />
                    </a>
                </div>
            </header>
            <!-- De uitgelichte afbeelding van het bericht -->
            <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="image featured">
                    <?php the_post_thumbnail('full'); ?>
                </a>
            <?php endif; ?>
            <!-- De inhoud van het bericht (alleen als je dat wilt weergeven) -->
            <p><?php echo wp_trim_words(get_the_content(), 40, '...'); ?></p>
            <footer>
                <ul class="actions">
                    <li><a href="<?php the_permalink(); ?>" class="button large">Continue Reading</a></li>
                </ul>
                <ul class="stats">
                    <!-- Optionele tags, categorieën, of andere gegevens die je wilt weergeven -->
                    <li><a href="#"><?php the_category(', '); ?></a></li>
                    <li><a href="#" class="icon solid fa-heart"><?php echo get_comments_number(); ?></a></li>
                    <li><a href="#" class="icon solid fa-comment"><?php echo get_comments_number(); ?></a></li>
                </ul>
            </footer>
        </article>
        <?php
    endwhile;
else :
    echo '<p>Geen berichten gevonden.</p>';
endif;

// Herstel de oorspronkelijke postdata
wp_reset_postdata();
?>


						
						<!-- Pagination -->
							<ul class="actions pagination">
								<li><a href="" class="disabled button large previous">Previous Page</a></li>
								<li><a href="#" class="button large next">Next Page</a></li>
							</ul>

</div>

<?php dynamic_sidebar('greentech-sidebar'); ?>

</div>

		<!-- Scripts -->
			<!-- <script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script> -->
			<?php
echo do_shortcode('[event_map]');
?>

<?php get_footer() ?>

