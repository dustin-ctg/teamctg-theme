<?php 
/**
 * Template Name: Confetti Bits
 * Description: Template part for displaying page content in confetti-bits.php
 * Version: 1.2.1
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */
ob_start();
session_start();
get_header();
?>
<div id="primary" class="content-area bb-grid-cell">
	<main id="primary" class="site-main">
 		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
		<?php
		if ( have_posts() && is_page('confetti-bits') ) :
				do_action( THEME_HOOK_PREFIX . '_template_parts_content_top' );

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( '/confetti-bits/template-parts/content', 'admin-session' );
				get_template_part( '/confetti-bits/template-parts/content', 'dashboard' );

		
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
