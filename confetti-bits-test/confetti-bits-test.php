<?php 
/**
 * Template Name: Confetti Bits Test
 * Template part for displaying page content in confetti-bits.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */
//ob_start();
//session_start();
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
		
		echo cb_is_active('transactions') ? 'ye' : 'naw';
		print_r (apply_filters( 'cb_active_components', bp_get_option( 'cb_active_components' ) ));
		print_r (apply_filters( 'cb_required_components', array( 'transactions' ) ));
		echo ( ! empty ($current_sesh->current_component) ) ? '<br>current component is set but might be empty<br>' : '<br>current component is not set<br>';	
		
	echo ( isset (Confetti_Bits()->active_components) ) ? '<br>active components are set but might be empty<br>' : '<br>active components are not set<br>';	
var_dump(Confetti_Bits()->active_components);
		
	echo ( isset (Confetti_Bits()->required_components) ) ? '<br>required components are set but might be empty<br>' : '<br>required components are not set<br>';
var_dump(Confetti_Bits()->required_components);

var_dump(buddypress()->active_components);
var_dump(buddypress()->required_components);
		
		
		
		/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				
				if ( cb_is_current_component('transactions') ) {
					get_template_part( '/confetti-bits-test/template-parts/content', 'admin-session' );
					
					get_template_part( '/confetti-bits-test/template-parts/content', 'dashboard' );			
				}

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
