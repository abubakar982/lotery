<?php
/**
 * Template Name: Demo Checkout
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main class="lotery-main">
	<div class="lotery-container">
		<?php echo do_shortcode( '[lotery_checkout]' ); ?>
	</div>
</main>
<?php
get_footer();
