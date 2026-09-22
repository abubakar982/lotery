<?php
/**
 * Template Name: My Tickets
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main class="lotery-main">
	<div class="lotery-container">
		<div class="lotery-dashboard-heading">
			<p class="lotery-eyebrow"><?php esc_html_e( 'PLAYER DASHBOARD', 'lotery-tickets' ); ?></p>
		</div>
		<?php echo do_shortcode( '[lotery_my_tickets]' ); ?>
	</div>
</main>
<?php
get_footer();
