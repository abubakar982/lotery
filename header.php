<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?><!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<header class="lotery-header"><div class="lotery-container lotery-header-inner">
<a class="lotery-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
<nav class="lotery-nav">
<a class="lotery-nav-draws" href="<?php echo esc_url( lotery_page_url( 'draws', '/draws/' ) ); ?>"><?php esc_html_e( 'Draws', 'lotery-tickets' ); ?></a>
<?php if ( current_user_can( 'manage_options' ) ) : ?><a class="lotery-nav-admin-draws" href="<?php echo esc_url( lotery_manage_draws_url() ); ?>"><?php esc_html_e( 'Manage draws', 'lotery-tickets' ); ?></a><?php endif; ?>
<?php if ( current_user_can( 'manage_options' ) ) : ?><a class="lotery-nav-admin-draws" href="<?php echo esc_url( lotery_all_tickets_url() ); ?>"><?php esc_html_e( 'All tickets', 'lotery-tickets' ); ?></a><?php endif; ?>
<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => false ) ); ?>
<?php else : ?>
	<ul>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'lotery-tickets' ); ?></a></li>
		<li><a href="<?php echo esc_url( lotery_page_url( 'draws', '/draws/' ) ); ?>"><?php esc_html_e( 'Draws', 'lotery-tickets' ); ?></a></li>
		<li><a href="<?php echo esc_url( lotery_page_url( 'buy-tickets', '/buy-tickets/' ) ); ?>"><?php esc_html_e( 'Buy tickets', 'lotery-tickets' ); ?></a></li>
		<?php if ( current_user_can( 'manage_options' ) ) : ?><li><a href="<?php echo esc_url( lotery_all_tickets_url() ); ?>"><?php esc_html_e( 'All tickets', 'lotery-tickets' ); ?></a></li><?php else : ?><li><a href="<?php echo esc_url( lotery_page_url( 'my-tickets', '/my-tickets/' ) ); ?>"><?php esc_html_e( 'My tickets', 'lotery-tickets' ); ?></a></li><?php endif; ?>
		<?php if ( ! is_user_logged_in() ) : ?><li><a href="<?php echo esc_url( lotery_page_url( 'register', '/register/' ) ); ?>"><?php esc_html_e( 'Register', 'lotery-tickets' ); ?></a></li><?php endif; ?>
	</ul>
<?php endif; ?>
<?php if ( is_user_logged_in() ) : ?><a class="lotery-nav-button" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Log out', 'lotery-tickets' ); ?></a><?php else : ?><a class="lotery-nav-button" href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Log in', 'lotery-tickets' ); ?></a><?php endif; ?>
</nav>
</div></header>
