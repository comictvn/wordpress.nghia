<?php /* Template Name: Demo Page Template 3 */ get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>
<?php
	$query = new WP_Query( array(
        'post_type' => 'contact',
        'color' => 'blue',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
    ) );


?>
<ul class="clothes-listing">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<?php echo get_post_meta( $post->ID, 'phone_number', true ); ?>
            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
			<h1>a<?php the_title(); ?></h1>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

				

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>



<?php get_footer(); ?>