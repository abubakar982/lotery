<?php
/**
 * Template Name: Register
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main class="lotery-main">
	<div class="lotery-container">
		<?php echo do_shortcode( '[lotery_register]' ); ?>
	</div>
</main>
<?php
get_footer();
