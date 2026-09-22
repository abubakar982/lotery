<?php
/**
 * Template Name: All Tickets
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main class="lotery-main">
	<div class="lotery-container">
		<?php echo do_shortcode( '[lotery_all_tickets]' ); ?>
	</div>
</main>
<?php get_footer(); ?>
