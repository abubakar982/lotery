<?php
/**
 * Lotery Tickets theme functions.
 *
 * This is intentionally a local/demo lottery implementation. It never charges
 * a card or sends a payment request to an external service.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LOTERY_TICKET_PRICE', 2.50 );
define( 'LOTERY_SCHEMA_VERSION', '2.0.0' );

function lotery_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus( array( 'primary' => __( 'Primary Menu', 'lotery-tickets' ) ) );
}
add_action( 'after_setup_theme', 'lotery_theme_setup' );

function lotery_login_register_link() {
	?>
	<p class="lotery-login-register">
		<a class="button button-secondary" href="<?php echo esc_url( lotery_page_url( 'register', '/register/' ) ); ?>">
			<?php esc_html_e( 'Register a new account', 'lotery-tickets' ); ?>
		</a>
	</p>
	<?php
}
add_action( 'login_footer', 'lotery_login_register_link' );

function lotery_login_assets() {
	wp_register_style( 'lotery-login-style', false, array(), '1.0.0' );
	wp_enqueue_style( 'lotery-login-style' );
	wp_add_inline_style(
		'lotery-login-style',
		'
		:root {
			--lotery-login-purple: #21164d;
			--lotery-login-violet: #6d4aff;
			--lotery-login-yellow: #ffc857;
		}
		body.login {
			position: relative;
			overflow: hidden;
			background: radial-gradient(circle at 15% 20%, #6049b6 0, transparent 28%),
				radial-gradient(circle at 85% 75%, #392277 0, transparent 32%),
				linear-gradient(135deg, #17132b, var(--lotery-login-purple));
			font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
		}
		body.login::before,
		body.login::after {
			position: fixed;
			z-index: 0;
			width: 90px;
			height: 90px;
			border: 8px solid rgba(255,255,255,.75);
			border-radius: 50%;
			color: var(--lotery-login-purple);
			background: var(--lotery-login-yellow);
			box-shadow: 0 18px 35px rgba(0,0,0,.3);
			content: "7";
			font-size: 2rem;
			font-weight: 900;
			line-height: 74px;
			text-align: center;
			transform: rotate(-15deg);
		}
		body.login::before { top: 12%; left: 9%; }
		body.login::after {
			right: 10%;
			bottom: 12%;
			color: #fff;
			background: #ff7b67;
			content: "23";
			transform: rotate(18deg);
		}
		#login {
			position: relative;
			z-index: 1;
			width: min(400px, calc(100% - 32px));
			padding: 8vh 0 0;
		}
		#login h1 a {
			width: auto;
			height: auto;
			margin-bottom: 26px;
			color: #fff;
			background: none;
			font-size: 1.65rem;
			font-weight: 900;
			letter-spacing: -.04em;
			text-indent: 0;
			text-decoration: none;
		}
		#login h1 a::before {
			display: inline-grid;
			place-items: center;
			width: 42px;
			height: 42px;
			margin-right: 9px;
			border-radius: 13px;
			color: var(--lotery-login-purple);
			background: var(--lotery-login-yellow);
			content: "✦";
			vertical-align: middle;
		}
		#loginform {
			padding: 32px;
			border: 1px solid rgba(255,255,255,.25);
			border-radius: 24px;
			background: transparent;
			box-shadow: 0 30px 70px rgba(0,0,0,.2), 0 8px 0 rgba(255,200,87,.55);
			backdrop-filter: blur(5px);
		}
		#loginform label {
			color: #fff;
			font-weight: 800;
		}
		#loginform input[type="text"],
		#loginform input[type="password"] {
			margin-top: 7px;
			padding: 12px 14px;
			border: 1px solid #ddd8ef;
			border-radius: 10px;
			box-shadow: inset 0 2px 5px rgba(33,22,77,.06);
		}
		#loginform input[type="text"]:focus,
		#loginform input[type="password"]:focus {
			border-color: var(--lotery-login-violet);
			box-shadow: 0 0 0 3px rgba(109,74,255,.16);
		}
		#loginform .button-primary {
			border: 0;
			border-radius: 10px;
			color: var(--lotery-login-purple);
			background: var(--lotery-login-yellow);
			box-shadow: 0 4px 0 #d79c25;
			font-weight: 900;
			text-shadow: none;
		}
		#loginform .button-primary:hover,
		#loginform .button-primary:focus {
			color: var(--lotery-login-purple);
			background: #ffd77a;
			transform: translateY(-1px);
		}
		.login #nav,
		.login #backtoblog {
			position: relative;
			z-index: 1;
			text-align: center;
		}
		.login #nav a,
		.login #backtoblog a {
			color: #fff;
		}
		.lotery-login-register {
			position: relative;
			z-index: 1;
			margin: 18px 0 0;
			text-align: center;
		}
		.lotery-login-register a {
			display: inline-block;
			padding: 10px 18px;
			border: 1px solid rgba(255,255,255,.45);
			border-radius: 10px;
			color: #fff;
			background: rgba(255,255,255,.12);
			font-weight: 800;
			text-decoration: none;
		}
		.lotery-login-register a:hover {
			background: rgba(255,255,255,.22);
		}
		@media (max-width: 520px) {
			body.login::before { top: 5%; left: -22px; transform: scale(.7) rotate(-15deg); }
			body.login::after { right: -22px; bottom: 5%; transform: scale(.7) rotate(18deg); }
			#login { padding-top: 5vh; }
			#loginform { padding: 25px; }
		}
		'
	);
}
add_action( 'login_enqueue_scripts', 'lotery_login_assets' );

function lotery_theme_assets() {
	wp_enqueue_style( 'lotery-theme-style', get_stylesheet_uri(), array(), '2.0.0' );
}
add_action( 'wp_enqueue_scripts', 'lotery_theme_assets' );

function lotery_theme_activate() {
	lotery_install_ticket_table();
	lotery_create_required_pages();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'lotery_theme_activate' );

function lotery_ticket_table_name() {
	global $wpdb;
	return $wpdb->prefix . 'lottery_tickets';
}

function lotery_draw_table_name() {
	global $wpdb;
	return $wpdb->prefix . 'lottery_draws';
}

function lotery_table_exists( $table ) {
	global $wpdb;
	return $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table ) ) ) === $table;
}

function lotery_column_exists( $table, $column ) {
	global $wpdb;
	return (bool) $wpdb->get_var( $wpdb->prepare( "SHOW COLUMNS FROM {$table} LIKE %s", $column ) );
}

function lotery_install_ticket_table() {
	global $wpdb;

	$charset = $wpdb->get_charset_collate();
	$draws   = lotery_draw_table_name();
	$tickets = lotery_ticket_table_name();
	$sql     = "CREATE TABLE {$draws} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		title varchar(191) NOT NULL DEFAULT '',
		draw_date date NOT NULL,
		jackpot decimal(12,2) NOT NULL DEFAULT 25000.00,
		selected_numbers varchar(191) NOT NULL DEFAULT '',
		status varchar(20) NOT NULL DEFAULT 'open',
		created_at datetime NOT NULL,
		PRIMARY KEY (id),
		KEY draw_date (draw_date),
		KEY status (status)
	) {$charset};
	CREATE TABLE {$tickets} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		user_id bigint(20) unsigned NOT NULL,
		draw_id bigint(20) unsigned NOT NULL DEFAULT 0,
		ticket_number varchar(32) NOT NULL,
		selected_numbers varchar(191) NOT NULL DEFAULT '',
		draw_date date NOT NULL,
		price decimal(10,2) NOT NULL DEFAULT 2.50,
		status varchar(20) NOT NULL DEFAULT 'pending',
		payment_status varchar(20) NOT NULL DEFAULT 'pending',
		payment_id varchar(191) NOT NULL DEFAULT '',
		winner_amount decimal(12,2) NOT NULL DEFAULT 0.00,
		created_at datetime NOT NULL,
		paid_at datetime NULL,
		PRIMARY KEY (id),
		KEY user_id (user_id),
		KEY draw_id (draw_id),
		KEY payment_id (payment_id),
		KEY status (status),
		KEY payment_status (payment_status)
	) {$charset};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	// dbDelta is deliberately supplemented with explicit additive migrations.
	// This preserves the original table and every existing ticket row.
	$columns = array(
		'draw_id'         => "ALTER TABLE {$tickets} ADD draw_id bigint(20) unsigned NOT NULL DEFAULT 0 AFTER user_id",
		'selected_numbers'=> "ALTER TABLE {$tickets} ADD selected_numbers varchar(191) NOT NULL DEFAULT '' AFTER ticket_number",
		'price'           => "ALTER TABLE {$tickets} ADD price decimal(10,2) NOT NULL DEFAULT 2.50 AFTER draw_date",
		'payment_status'  => "ALTER TABLE {$tickets} ADD payment_status varchar(20) NOT NULL DEFAULT 'pending' AFTER status",
		'winner_amount'   => "ALTER TABLE {$tickets} ADD winner_amount decimal(12,2) NOT NULL DEFAULT 0.00 AFTER payment_id",
	);
	foreach ( $columns as $column => $alter_sql ) {
		if ( ! lotery_column_exists( $tickets, $column ) ) {
			$wpdb->query( $alter_sql ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		}
	}

	$wpdb->query( $wpdb->prepare( "UPDATE {$tickets} SET payment_status = %s WHERE payment_status = ''", 'pending' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$wpdb->query( $wpdb->prepare( "UPDATE {$tickets} SET payment_status = %s WHERE status IN ('paid','winner','lost') AND payment_status = %s", 'paid', 'pending' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$wpdb->query( $wpdb->prepare( "UPDATE {$tickets} SET price = %f WHERE price IS NULL OR price = 0", LOTERY_TICKET_PRICE ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	update_option( 'lotery_ticket_table_version', LOTERY_SCHEMA_VERSION );
	$default_draw_id = lotery_get_or_create_next_draw();
	if ( $default_draw_id ) {
		$wpdb->query( $wpdb->prepare( "UPDATE {$tickets} SET draw_id = %d WHERE draw_id = 0 AND draw_date = (SELECT draw_date FROM {$draws} WHERE id = %d)", $default_draw_id, $default_draw_id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	}
}

function lotery_ensure_ticket_table() {
	if ( LOTERY_SCHEMA_VERSION !== get_option( 'lotery_ticket_table_version' ) || ! lotery_table_exists( lotery_ticket_table_name() ) || ! lotery_table_exists( lotery_draw_table_name() ) ) {
		lotery_install_ticket_table();
	}
}
add_action( 'init', 'lotery_ensure_ticket_table', 1 );

function lotery_ticket_columns_exist() {
	return lotery_table_exists( lotery_ticket_table_name() );
}

function lotery_create_required_pages() {
	$pages = array(
		'my-tickets'  => array( 'title' => __( 'My Tickets', 'lotery-tickets' ), 'template' => 'page-my-tickets.php' ),
		'buy-tickets' => array( 'title' => __( 'Buy Tickets', 'lotery-tickets' ), 'template' => 'page-buy-tickets.php' ),
		'register'    => array( 'title' => __( 'Register', 'lotery-tickets' ), 'template' => 'page-register.php' ),
		'checkout'    => array( 'title' => __( 'Demo Checkout', 'lotery-tickets' ), 'template' => 'page-checkout.php' ),
		'draws'       => array( 'title' => __( 'Draws', 'lotery-tickets' ), 'template' => 'page-draws.php' ),
		'all-tickets' => array( 'title' => __( 'All Tickets', 'lotery-tickets' ), 'template' => 'page-all-tickets.php' ),
	);
	$created_page = false;
	foreach ( $pages as $slug => $page ) {
		if ( get_page_by_path( $slug ) ) {
			continue;
		}
		$page_id = wp_insert_post(
			array(
				'post_title'  => $page['title'],
				'post_name'   => $slug,
				'post_status' => 'publish',
				'post_type'   => 'page',
			),
			true
		);
		if ( ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', $page['template'] );
			$created_page = true;
		}
	}
	return $created_page;
}

function lotery_ensure_required_pages() {
	$created = get_option( 'lotery_required_pages_created' );
	$new_pages = lotery_create_required_pages();
	if ( ! $created || $new_pages ) {
		update_option( 'lotery_required_pages_created', 1 );
		flush_rewrite_rules();
	}
}
add_action( 'admin_init', 'lotery_ensure_required_pages' );

function lotery_theme_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'lotery-front-page';
	}
	return $classes;
}
add_filter( 'body_class', 'lotery_theme_body_classes' );

function lotery_page_url( $slug, $fallback = '/' ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( $fallback );
}

function lotery_all_tickets_url() {
	return add_query_arg( 'lotery_all_tickets', '1', home_url( '/' ) );
}

function lotery_manage_draws_url() {
	return add_query_arg( 'lotery_manage_draws', '1', home_url( '/' ) );
}

function lotery_manage_draws_actions() {
	if ( empty( $_GET['lotery_manage_draws'] ) || 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	check_admin_referer( sanitize_key( $_POST['lotery_draw_action'] ?? '' ) );
	global $wpdb;
	$action = sanitize_key( $_POST['lotery_draw_action'] ?? '' );

	if ( 'create' === $action ) {
		$title   = sanitize_text_field( wp_unslash( $_POST['draw_title'] ?? '' ) );
		$date    = sanitize_text_field( wp_unslash( $_POST['draw_date'] ?? '' ) );
		$jackpot = (float) ( $_POST['draw_jackpot'] ?? 0 );
		if ( $title && preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) && $jackpot >= 0 ) {
			$wpdb->insert( lotery_draw_table_name(), array( 'title' => $title, 'draw_date' => $date, 'jackpot' => $jackpot, 'status' => 'open', 'created_at' => current_time( 'mysql' ) ), array( '%s', '%s', '%f', '%s', '%s' ) );
		}
	} elseif ( 'status' === $action ) {
		$draw_id = absint( $_POST['draw_id'] ?? 0 );
		$status  = sanitize_key( $_POST['draw_status'] ?? '' );
		if ( $draw_id && in_array( $status, array( 'open', 'closed' ), true ) ) {
			$wpdb->update( lotery_draw_table_name(), array( 'status' => $status ), array( 'id' => $draw_id ), array( '%s' ), array( '%d' ) );
		}
	} elseif ( 'results' === $action ) {
		$draw_id = absint( $_POST['draw_id'] ?? 0 );
		$numbers = lotery_parse_numbers( wp_unslash( $_POST['winning_numbers'] ?? '' ) );
		$draw    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . lotery_draw_table_name() . " WHERE id = %d", $draw_id ) );
		if ( $draw && 5 === count( $numbers ) ) {
			$winning = lotery_numbers_string( $numbers );
			$wpdb->update( lotery_draw_table_name(), array( 'selected_numbers' => $winning, 'status' => 'completed' ), array( 'id' => $draw_id ), array( '%s', '%s' ), array( '%d' ) );
			$tickets = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . lotery_ticket_table_name() . " WHERE draw_id = %d AND payment_status = %s", $draw_id, 'paid' ) );
			foreach ( $tickets as $ticket ) {
				$is_winner = 5 === lotery_numbers_match_count( $ticket->selected_numbers, $winning );
				$wpdb->update( lotery_ticket_table_name(), array( 'status' => $is_winner ? 'winner' : 'lost', 'winner_amount' => $is_winner ? (float) $draw->jackpot : 0 ), array( 'id' => $ticket->id ), array( '%s', '%f' ), array( '%d' ) );
			}
		}
	}

	wp_safe_redirect( lotery_manage_draws_url() );
	exit;
}
add_action( 'template_redirect', 'lotery_manage_draws_actions', 1 );

function lotery_all_tickets_route() {
	if ( empty( $_GET['lotery_all_tickets'] ) ) {
		return;
	}

	get_header();
	echo '<main class="lotery-main"><div class="lotery-container">';
	echo do_shortcode( '[lotery_all_tickets]' );
	echo '</div></main>';
	get_footer();
	exit;
}
add_action( 'template_redirect', 'lotery_all_tickets_route', 1 );

function lotery_manage_draws_route() {
	if ( empty( $_GET['lotery_manage_draws'] ) ) {
		return;
	}
	get_header();
	echo '<main class="lotery-main"><div class="lotery-container">';
	echo do_shortcode( '[lotery_manage_draws]' );
	echo '</div></main>';
	get_footer();
	exit;
}
add_action( 'template_redirect', 'lotery_manage_draws_route', 2 );

function lotery_manage_draws_shortcode() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return '<div class="lotery-card"><h2>' . esc_html__( 'Administrator access required', 'lotery-tickets' ) . '</h2><p>' . esc_html__( 'Only administrators can manage lottery draws.', 'lotery-tickets' ) . '</p></div>';
	}
	global $wpdb;
	$draws = $wpdb->get_results( "SELECT d.*, COUNT(t.id) AS ticket_count FROM " . lotery_draw_table_name() . " d LEFT JOIN " . lotery_ticket_table_name() . " t ON t.draw_id = d.id GROUP BY d.id ORDER BY d.draw_date DESC" );
	ob_start();
	?>
	<div class="lotery-card lotery-admin-draws">
		<p class="lotery-eyebrow"><?php esc_html_e( 'ADMINISTRATION', 'lotery-tickets' ); ?></p>
		<h1 class="lotery-title"><?php esc_html_e( 'Manage draws', 'lotery-tickets' ); ?></h1>
		<p class="lotery-subtitle"><?php esc_html_e( 'Create draws, control availability, and publish winning numbers.', 'lotery-tickets' ); ?></p>
		<form method="post" class="lotery-admin-form">
			<?php wp_nonce_field( 'create', '_wpnonce' ); ?><input type="hidden" name="lotery_draw_action" value="create">
			<p><label><?php esc_html_e( 'Title', 'lotery-tickets' ); ?><input required type="text" name="draw_title" value="<?php esc_attr_e( 'Weekly Demo Draw', 'lotery-tickets' ); ?>"></label>
			<label><?php esc_html_e( 'Date', 'lotery-tickets' ); ?><input required type="date" name="draw_date"></label>
			<label><?php esc_html_e( 'Jackpot', 'lotery-tickets' ); ?><input required min="0" step="0.01" type="number" name="draw_jackpot" value="25000"></label>
			<button class="lotery-button" type="submit"><?php esc_html_e( 'Create draw', 'lotery-tickets' ); ?></button></p>
		</form>
		<div class="lotery-table-wrap"><table class="lotery-table"><thead><tr><th><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Date / jackpot', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Tickets', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Status', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Results', 'lotery-tickets' ); ?></th></tr></thead><tbody>
		<?php foreach ( $draws as $draw ) : ?><tr><td><?php echo esc_html( $draw->title ); ?></td><td><?php echo esc_html( $draw->draw_date . ' · $' . number_format_i18n( $draw->jackpot, 2 ) ); ?></td><td><?php echo esc_html( $draw->ticket_count ); ?></td><td><?php if ( in_array( $draw->status, array( 'open', 'closed' ), true ) ) : ?><form method="post"><?php wp_nonce_field( 'status', '_wpnonce' ); ?><input type="hidden" name="lotery_draw_action" value="status"><input type="hidden" name="draw_id" value="<?php echo esc_attr( $draw->id ); ?>"><select name="draw_status"><option value="open" <?php selected( $draw->status, 'open' ); ?>><?php esc_html_e( 'Open', 'lotery-tickets' ); ?></option><option value="closed" <?php selected( $draw->status, 'closed' ); ?>><?php esc_html_e( 'Closed', 'lotery-tickets' ); ?></option></select><button class="lotery-button lotery-button-secondary" type="submit"><?php esc_html_e( 'Save', 'lotery-tickets' ); ?></button></form><?php else : ?><span class="lotery-status"><?php echo esc_html( ucfirst( $draw->status ) ); ?></span><?php endif; ?></td><td><?php if ( $draw->selected_numbers ) : ?><strong><?php echo esc_html( str_replace( ',', ' · ', $draw->selected_numbers ) ); ?></strong><?php else : ?><form method="post"><?php wp_nonce_field( 'results', '_wpnonce' ); ?><input type="hidden" name="lotery_draw_action" value="results"><input type="hidden" name="draw_id" value="<?php echo esc_attr( $draw->id ); ?>"><input required pattern="([1-9]|[1-4][0-9]|50)(\s*,\s*([1-9]|[1-4][0-9]|50)){4}" type="text" name="winning_numbers" placeholder="5, 12, 23, 37, 49"><button class="lotery-button lotery-button-secondary" type="submit"><?php esc_html_e( 'Publish', 'lotery-tickets' ); ?></button></form><?php endif; ?></td></tr><?php endforeach; ?>
		</tbody></table></div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'lotery_manage_draws', 'lotery_manage_draws_shortcode' );

function lotery_public_draws_shortcode() {
	global $wpdb;
	$draws = lotery_table_exists( lotery_draw_table_name() )
		? $wpdb->get_results( "SELECT * FROM " . lotery_draw_table_name() . " ORDER BY draw_date DESC, id DESC" )
		: array();

	ob_start();
	?>
	<div class="lotery-draws-page">
		<div class="lotery-section-heading centered">
			<div>
				<p class="lotery-eyebrow"><?php esc_html_e( 'LOTTERY SCHEDULE', 'lotery-tickets' ); ?></p>
				<h1 class="lotery-title"><?php esc_html_e( 'Upcoming and past draws', 'lotery-tickets' ); ?></h1>
				<p class="lotery-subtitle"><?php esc_html_e( 'Choose a draw, pick your numbers, and follow the published results.', 'lotery-tickets' ); ?></p>
			</div>
		</div>
		<?php if ( empty( $draws ) ) : ?>
			<div class="lotery-card"><p><?php esc_html_e( 'No draws are available yet.', 'lotery-tickets' ); ?></p></div>
		<?php else : ?>
			<div class="lotery-draw-list">
				<?php foreach ( $draws as $draw ) : ?>
					<article class="lotery-public-draw">
						<div>
							<p class="lotery-eyebrow"><?php echo esc_html( strtoupper( $draw->status ) ); ?></p>
							<h2><?php echo esc_html( $draw->title ); ?></h2>
							<p class="lotery-public-draw-date"><?php echo esc_html( wp_date( 'l, F j, Y', strtotime( $draw->draw_date ) ) ); ?></p>
						</div>
						<div class="lotery-public-draw-jackpot"><small><?php esc_html_e( 'JACKPOT', 'lotery-tickets' ); ?></small><strong>$<?php echo esc_html( number_format_i18n( $draw->jackpot, 2 ) ); ?></strong></div>
						<div>
							<?php if ( $draw->selected_numbers ) : ?>
								<small class="lotery-public-draw-label"><?php esc_html_e( 'WINNING NUMBERS', 'lotery-tickets' ); ?></small>
								<div class="lotery-winning-numbers"><?php foreach ( lotery_parse_numbers( $draw->selected_numbers ) as $number ) : ?><span><?php echo esc_html( $number ); ?></span><?php endforeach; ?></div>
							<?php elseif ( 'open' === $draw->status ) : ?>
								<a class="lotery-button" href="<?php echo esc_url( lotery_page_url( 'buy-tickets', '/buy-tickets/' ) ); ?>"><?php esc_html_e( 'Play this draw', 'lotery-tickets' ); ?> →</a>
							<?php else : ?>
								<span class="lotery-pending-label"><?php esc_html_e( 'Results pending', 'lotery-tickets' ); ?></span>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'lotery_draws', 'lotery_public_draws_shortcode' );

function lotery_get_or_create_next_draw() {
	global $wpdb;
	if ( ! lotery_table_exists( lotery_draw_table_name() ) ) {
		return 0;
	}
	$draw = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . lotery_draw_table_name() . " WHERE status = %s AND draw_date >= %s ORDER BY draw_date ASC, id ASC LIMIT 1", 'open', current_time( 'Y-m-d' ) ) );
	if ( $draw ) {
		return (int) $draw->id;
	}
	$next_saturday = strtotime( 'next saturday', current_time( 'timestamp' ) );
	$date          = wp_date( 'Y-m-d', $next_saturday );
	$inserted      = $wpdb->insert(
		lotery_draw_table_name(),
		array(
			'title'      => __( 'Weekly Demo Draw', 'lotery-tickets' ),
			'draw_date'  => $date,
			'jackpot'    => 25000,
			'status'     => 'open',
			'created_at' => current_time( 'mysql' ),
		),
		array( '%s', '%s', '%f', '%s', '%s' )
	);
	return $inserted ? (int) $wpdb->insert_id : 0;
}

function lotery_get_open_draws() {
	global $wpdb;
	if ( ! lotery_table_exists( lotery_draw_table_name() ) ) {
		return array();
	}
	$draws = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . lotery_draw_table_name() . " WHERE status = %s AND draw_date >= %s ORDER BY draw_date ASC", 'open', current_time( 'Y-m-d' ) ) );
	if ( empty( $draws ) ) {
		lotery_get_or_create_next_draw();
		$draws = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . lotery_draw_table_name() . " WHERE status = %s AND draw_date >= %s ORDER BY draw_date ASC", 'open', current_time( 'Y-m-d' ) ) );
	}
	return $draws ? $draws : array();
}

function lotery_ticket_status_label( $status ) {
	$labels = array(
		'pending'  => __( 'Payment pending', 'lotery-tickets' ),
		'paid'     => __( 'Paid', 'lotery-tickets' ),
		'winner'   => __( 'Winner', 'lotery-tickets' ),
		'lost'     => __( 'Not a winner', 'lotery-tickets' ),
		'cancelled'=> __( 'Cancelled', 'lotery-tickets' ),
	);
	$key = sanitize_key( $status );
	return isset( $labels[ $key ] ) ? $labels[ $key ] : ucfirst( $key );
}

function lotery_ticket_payment_url( $ticket_ids, $user_id ) {
	$first = ! empty( $ticket_ids ) ? absint( reset( $ticket_ids ) ) : 0;
	return $first ? add_query_arg( 'ticket_id', $first, lotery_page_url( 'checkout', '/checkout/' ) ) : '';
}

function lotery_get_user_tickets( $user_id, $status = '', $draw_id = 0 ) {
	global $wpdb;
	if ( ! lotery_ticket_columns_exist() ) {
		return array();
	}
	$where  = 'user_id = %d';
	$params = array( absint( $user_id ) );
	if ( $status && in_array( $status, array( 'pending', 'paid', 'winner', 'lost', 'cancelled' ), true ) ) {
		$where   .= ' AND status = %s';
		$params[] = $status;
	}
	if ( $draw_id ) {
		$where   .= ' AND draw_id = %d';
		$params[] = absint( $draw_id );
	}
	return $wpdb->get_results( $wpdb->prepare( "SELECT t.*, d.title AS draw_title, d.selected_numbers AS winning_numbers FROM " . lotery_ticket_table_name() . " t LEFT JOIN " . lotery_draw_table_name() . " d ON d.id = t.draw_id WHERE {$where} ORDER BY t.created_at DESC", $params ) );
}

function lotery_parse_numbers( $raw ) {
	$values = is_array( $raw ) ? $raw : explode( ',', (string) $raw );
	$numbers = array();
	foreach ( $values as $value ) {
		$value  = is_scalar( $value ) ? trim( (string) $value ) : '';
		$number = ctype_digit( $value ) ? (int) $value : 0;
		if ( $number >= 1 && $number <= 50 ) {
			$numbers[] = $number;
		}
	}
	$numbers = array_values( array_unique( $numbers ) );
	sort( $numbers, SORT_NUMERIC );
	return $numbers;
}

function lotery_numbers_string( $numbers ) {
	return implode( ',', array_map( 'absint', lotery_parse_numbers( $numbers ) ) );
}

function lotery_quick_pick() {
	$numbers = range( 1, 50 );
	shuffle( $numbers );
	return lotery_parse_numbers( array_slice( $numbers, 0, 5 ) );
}

function lotery_validate_draw( $draw_id ) {
	global $wpdb;
	$draw = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . lotery_draw_table_name() . " WHERE id = %d AND status = %s AND draw_date >= %s", absint( $draw_id ), 'open', current_time( 'Y-m-d' ) ) );
	return $draw;
}

function lotery_handle_frontend_actions() {
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}
	$user_id = get_current_user_id();

	if ( isset( $_POST['lotery_register'] ) ) {
		if ( ! isset( $_POST['lotery_register_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lotery_register_nonce'] ) ), 'lotery_register' ) ) {
			wp_die( esc_html__( 'Your registration session expired. Please try again.', 'lotery-tickets' ), 403 );
		}
		$username = sanitize_user( wp_unslash( $_POST['lotery_username'] ?? '' ) );
		$email    = sanitize_email( wp_unslash( $_POST['lotery_email'] ?? '' ) );
		$password = (string) wp_unslash( $_POST['lotery_password'] ?? '' );
		$confirm  = (string) wp_unslash( $_POST['lotery_password_confirm'] ?? '' );
		$errors   = new WP_Error();
		if ( ! $username || ! validate_username( $username ) ) {
			$errors->add( 'username', __( 'Enter a valid username.', 'lotery-tickets' ) );
		}
		if ( ! is_email( $email ) ) {
			$errors->add( 'email', __( 'Enter a valid email address.', 'lotery-tickets' ) );
		}
		if ( strlen( $password ) < 8 || $password !== $confirm ) {
			$errors->add( 'password', __( 'Passwords must match and contain at least 8 characters.', 'lotery-tickets' ) );
		}
		if ( username_exists( $username ) || email_exists( $email ) ) {
			$errors->add( 'exists', __( 'That username or email is already registered.', 'lotery-tickets' ) );
		}
		if ( $errors->has_errors() ) {
			$error_token = strtolower( wp_generate_password( 20, false, false ) );
			set_transient( 'lotery_register_errors_' . $error_token, $errors->get_error_messages(), 60 );
			wp_safe_redirect( add_query_arg( 'lotery_register_error', $error_token, lotery_page_url( 'register', '/register/' ) ) );
			exit;
		}
		$new_user = wp_create_user( $username, $password, $email );
		if ( is_wp_error( $new_user ) ) {
			wp_die( esc_html( $new_user->get_error_message() ), 400 );
		}
		wp_set_auth_cookie( $new_user, true );
		wp_safe_redirect( lotery_page_url( 'buy-tickets', '/buy-tickets/' ) );
		exit;
	}

	if ( isset( $_POST['lotery_buy_tickets'] ) || isset( $_POST['lotery_quick_pick'] ) ) {
		if ( ! $user_id ) {
			wp_safe_redirect( wp_login_url( lotery_page_url( 'buy-tickets', '/buy-tickets/' ) ) );
			exit;
		}
		if ( ! isset( $_POST['lotery_buy_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lotery_buy_nonce'] ) ), 'lotery_buy_tickets' ) ) {
			wp_die( esc_html__( 'Your buying session expired. Please try again.', 'lotery-tickets' ), 403 );
		}
		$draw = lotery_validate_draw( absint( $_POST['lotery_draw_id'] ?? 0 ) );
		$numbers = isset( $_POST['lotery_quick_pick'] ) ? lotery_quick_pick() : lotery_parse_numbers( wp_unslash( $_POST['lotery_numbers'] ?? array() ) );
		if ( ! $draw || 5 !== count( $numbers ) ) {
			wp_safe_redirect( add_query_arg( 'lotery_error', __( 'Choose an available draw and exactly five unique numbers from 1 to 50.', 'lotery-tickets' ), lotery_page_url( 'buy-tickets', '/buy-tickets/' ) ) );
			exit;
		}
		global $wpdb;
		$ticket_number = lotery_generate_ticket_number();
		$inserted       = $wpdb->insert(
			lotery_ticket_table_name(),
			array(
				'user_id'          => $user_id,
				'draw_id'          => (int) $draw->id,
				'ticket_number'    => $ticket_number,
				'selected_numbers' => lotery_numbers_string( $numbers ),
				'draw_date'        => $draw->draw_date,
				'price'            => LOTERY_TICKET_PRICE,
				'status'           => 'pending',
				'payment_status'   => 'pending',
				'created_at'       => current_time( 'mysql' ),
			),
			array( '%d', '%d', '%s', '%s', '%s', '%f', '%s', '%s', '%s' )
		);
		if ( ! $inserted ) {
			wp_die( esc_html__( 'The ticket could not be created. Please try again.', 'lotery-tickets' ), 500 );
		}
		wp_safe_redirect( add_query_arg( 'ticket_id', absint( $wpdb->insert_id ), lotery_page_url( 'checkout', '/checkout/' ) ) );
		exit;
	}

	if ( isset( $_POST['lotery_demo_payment'] ) ) {
		if ( ! $user_id || ! isset( $_POST['lotery_payment_nonce'], $_POST['lotery_ticket_id'] ) ) {
			wp_die( esc_html__( 'This payment request is invalid.', 'lotery-tickets' ), 403 );
		}
		$ticket_id = absint( $_POST['lotery_ticket_id'] );
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lotery_payment_nonce'] ) ), 'lotery_demo_payment_' . $ticket_id ) ) {
			wp_die( esc_html__( 'Your payment session expired. Please try again.', 'lotery-tickets' ), 403 );
		}
		global $wpdb;
		$payment_id = 'demo-' . $ticket_id . '-' . time();
		$updated = $wpdb->update(
			lotery_ticket_table_name(),
			array( 'status' => 'paid', 'payment_status' => 'paid', 'payment_id' => $payment_id, 'paid_at' => current_time( 'mysql' ) ),
			array( 'id' => $ticket_id, 'user_id' => $user_id, 'status' => 'pending' ),
			array( '%s', '%s', '%s', '%s' ),
			array( '%d', '%d', '%s' )
		);
		if ( false === $updated || 0 === $updated ) {
			wp_die( esc_html__( 'This ticket is not available for payment.', 'lotery-tickets' ), 404 );
		}
		do_action( 'lottery_payment_completed', $payment_id, $user_id, $ticket_id );
		wp_safe_redirect( add_query_arg( 'lotery_demo_paid', '1', lotery_page_url( 'my-tickets', '/my-tickets/' ) ) );
		exit;
	}
}
add_action( 'template_redirect', 'lotery_handle_frontend_actions', 1 );

function lotery_legacy_demo_payment_redirect() {
	if ( empty( $_GET['lotery_demo_pay'] ) || ! is_user_logged_in() ) {
		return;
	}
	global $wpdb;
	$ticket_id = absint( $_GET['lotery_demo_pay'] );
	$ticket    = $wpdb->get_row( $wpdb->prepare( "SELECT id, status, user_id FROM " . lotery_ticket_table_name() . " WHERE id = %d", $ticket_id ) );
	if ( $ticket && (int) $ticket->user_id === get_current_user_id() && 'pending' === $ticket->status ) {
		wp_safe_redirect( add_query_arg( 'ticket_id', $ticket_id, lotery_page_url( 'checkout', '/checkout/' ) ) );
		exit;
	}
}
add_action( 'template_redirect', 'lotery_legacy_demo_payment_redirect', 2 );

function lotery_generate_ticket_number() {
	return 'LOT-' . strtoupper( wp_generate_password( 8, false, false ) );
}

function lotery_register_shortcode() {
	if ( is_user_logged_in() ) {
		return '<div class="lotery-card"><h2>' . esc_html__( 'You are already registered.', 'lotery-tickets' ) . '</h2><a class="lotery-button" href="' . esc_url( lotery_page_url( 'my-tickets', '/my-tickets/' ) ) . '">' . esc_html__( 'Go to dashboard', 'lotery-tickets' ) . '</a></div>';
	}
	$error_token = sanitize_key( $_GET['lotery_register_error'] ?? '' );
	$errors      = $error_token ? get_transient( 'lotery_register_errors_' . $error_token ) : array();
	if ( $error_token ) {
		delete_transient( 'lotery_register_errors_' . $error_token );
	}
	ob_start();
	?>
	<div class="lotery-card lotery-form-card">
		<p class="lotery-eyebrow"><?php esc_html_e( 'JOIN THE DEMO', 'lotery-tickets' ); ?></p>
		<h1 class="lotery-title"><?php esc_html_e( 'Create your player account', 'lotery-tickets' ); ?></h1>
		<p class="lotery-subtitle"><?php esc_html_e( 'Registration is local to this WordPress site. No payment details are collected.', 'lotery-tickets' ); ?></p>
		<?php if ( $errors ) : ?><div class="lotery-notice"><?php foreach ( (array) $errors as $error ) : ?><p><?php echo esc_html( $error ); ?></p><?php endforeach; ?></div><?php endif; ?>
		<form method="post">
			<p><label for="lotery_username"><?php esc_html_e( 'Username', 'lotery-tickets' ); ?></label><input required id="lotery_username" name="lotery_username" type="text" autocomplete="username"></p>
			<p><label for="lotery_email"><?php esc_html_e( 'Email', 'lotery-tickets' ); ?></label><input required id="lotery_email" name="lotery_email" type="email" autocomplete="email"></p>
			<p><label for="lotery_password"><?php esc_html_e( 'Password', 'lotery-tickets' ); ?></label><input required minlength="8" id="lotery_password" name="lotery_password" type="password" autocomplete="new-password"></p>
			<p><label for="lotery_password_confirm"><?php esc_html_e( 'Confirm password', 'lotery-tickets' ); ?></label><input required minlength="8" id="lotery_password_confirm" name="lotery_password_confirm" type="password" autocomplete="new-password"></p>
			<?php wp_nonce_field( 'lotery_register', 'lotery_register_nonce' ); ?>
			<button class="lotery-button" type="submit" name="lotery_register" value="1"><?php esc_html_e( 'Create account', 'lotery-tickets' ); ?></button>
		</form>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'lotery_register', 'lotery_register_shortcode' );

function lotery_buy_tickets_shortcode() {
	if ( ! is_user_logged_in() ) {
		return '<div class="lotery-card"><h2>' . esc_html__( 'Please log in before buying a ticket.', 'lotery-tickets' ) . '</h2><a class="lotery-button" href="' . esc_url( wp_login_url( lotery_page_url( 'buy-tickets', '/buy-tickets/' ) ) ) . '">' . esc_html__( 'Log in', 'lotery-tickets' ) . '</a> <a class="lotery-button lotery-button-secondary" href="' . esc_url( lotery_page_url( 'register', '/register/' ) ) . '">' . esc_html__( 'Register', 'lotery-tickets' ) . '</a></div>';
	}
	$draws = lotery_get_open_draws();
	$error = isset( $_GET['lotery_error'] ) ? sanitize_text_field( wp_unslash( $_GET['lotery_error'] ) ) : '';
	ob_start();
	?>
	<div class="lotery-card lotery-buy-card">
		<p class="lotery-eyebrow"><?php esc_html_e( 'CHOOSE YOUR NUMBERS', 'lotery-tickets' ); ?></p>
		<h1 class="lotery-title"><?php esc_html_e( 'Build your lucky ticket', 'lotery-tickets' ); ?></h1>
		<p class="lotery-subtitle"><?php printf( esc_html__( 'Pick exactly five numbers from 1–50 for %s. Each demo ticket costs $%s.', 'lotery-tickets' ), esc_html__( 'the next available draw', 'lotery-tickets' ), esc_html( number_format_i18n( LOTERY_TICKET_PRICE, 2 ) ) ); ?></p>
		<?php if ( $error ) : ?><p class="lotery-notice"><?php echo esc_html( $error ); ?></p><?php endif; ?>
		<?php if ( empty( $draws ) ) : ?><p class="lotery-notice"><?php esc_html_e( 'There are no open draws right now.', 'lotery-tickets' ); ?></p><?php else : ?>
		<form method="post">
			<p><label for="lotery_draw_id"><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?></label><select id="lotery_draw_id" name="lotery_draw_id" required><?php foreach ( $draws as $draw ) : ?><option value="<?php echo esc_attr( $draw->id ); ?>"><?php echo esc_html( $draw->title . ' · ' . $draw->draw_date . ' · $' . number_format_i18n( $draw->jackpot, 2 ) . ' jackpot' ); ?></option><?php endforeach; ?></select></p>
			<fieldset class="lotery-number-picker"><legend><?php esc_html_e( 'Your numbers', 'lotery-tickets' ); ?></legend><div class="lotery-number-grid"><?php for ( $number = 1; $number <= 50; $number++ ) : ?><label><input type="checkbox" name="lotery_numbers[]" value="<?php echo esc_attr( $number ); ?>"><span><?php echo esc_html( $number ); ?></span></label><?php endfor; ?></div></fieldset>
			<?php wp_nonce_field( 'lotery_buy_tickets', 'lotery_buy_nonce' ); ?>
			<div class="lotery-buy-actions"><button class="lotery-button lotery-button-secondary" type="submit" name="lotery_quick_pick" value="1"><?php esc_html_e( 'Quick pick & checkout', 'lotery-tickets' ); ?></button><button class="lotery-button" type="submit" name="lotery_buy_tickets" value="1"><?php esc_html_e( 'Continue to checkout', 'lotery-tickets' ); ?> →</button></div>
		</form>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'lotery_buy_tickets', 'lotery_buy_tickets_shortcode' );

function lotery_checkout_shortcode() {
	if ( ! is_user_logged_in() ) {
		return '<div class="lotery-card"><h2>' . esc_html__( 'Please log in to checkout.', 'lotery-tickets' ) . '</h2></div>';
	}
	global $wpdb;
	$ticket_id = absint( $_GET['ticket_id'] ?? 0 );
	$ticket    = $wpdb->get_row( $wpdb->prepare( "SELECT t.*, d.title AS draw_title, d.jackpot FROM " . lotery_ticket_table_name() . " t LEFT JOIN " . lotery_draw_table_name() . " d ON d.id = t.draw_id WHERE t.id = %d AND t.user_id = %d", $ticket_id, get_current_user_id() ) );
	if ( ! $ticket || 'pending' !== $ticket->status ) {
		return '<div class="lotery-card"><p class="lotery-notice">' . esc_html__( 'This ticket is not available for payment.', 'lotery-tickets' ) . '</p></div>';
	}
	ob_start();
	?>
	<div class="lotery-card lotery-buy-card">
		<p class="lotery-eyebrow"><?php esc_html_e( 'DEMO CHECKOUT', 'lotery-tickets' ); ?></p>
		<h1 class="lotery-title"><?php esc_html_e( 'Confirm your ticket', 'lotery-tickets' ); ?></h1>
		<p class="lotery-subtitle"><?php esc_html_e( 'This local checkout simulates payment. No real money or payment details are used.', 'lotery-tickets' ); ?></p>
		<div class="lotery-checkout-summary"><p><strong><?php esc_html_e( 'Ticket:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( $ticket->ticket_number ); ?></p><p><strong><?php esc_html_e( 'Draw:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( $ticket->draw_title . ' · ' . $ticket->draw_date ); ?></p><p><strong><?php esc_html_e( 'Numbers:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( str_replace( ',', ' · ', $ticket->selected_numbers ) ); ?></p><p><strong><?php esc_html_e( 'Demo total:', 'lotery-tickets' ); ?></strong> $<?php echo esc_html( number_format_i18n( $ticket->price, 2 ) ); ?></p></div>
		<form method="post"><?php wp_nonce_field( 'lotery_demo_payment_' . $ticket_id, 'lotery_payment_nonce' ); ?><input type="hidden" name="lotery_ticket_id" value="<?php echo esc_attr( $ticket_id ); ?>"><button class="lotery-button lotery-button-yellow" type="submit" name="lotery_demo_payment" value="1"><?php esc_html_e( 'Confirm demo payment', 'lotery-tickets' ); ?></button></form>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'lotery_checkout', 'lotery_checkout_shortcode' );

function lotery_customer_tickets_shortcode() {
	if ( ! is_user_logged_in() ) {
		return '<div class="lotery-card"><h2>' . esc_html__( 'Please log in', 'lotery-tickets' ) . '</h2><a class="lotery-button" href="' . esc_url( wp_login_url( lotery_page_url( 'my-tickets', '/my-tickets/' ) ) ) . '">' . esc_html__( 'Log in', 'lotery-tickets' ) . '</a></div>';
	}
	global $wpdb;
	$user_id = get_current_user_id();
	$status  = sanitize_key( $_GET['ticket_status'] ?? '' );
	$draw_id = absint( $_GET['ticket_draw'] ?? 0 );
	$tickets = lotery_get_user_tickets( $user_id, $status, $draw_id );
	$all_tickets = lotery_get_user_tickets( $user_id );
	$paid_count = 0;
	$win_count  = 0;
	$spent      = 0;
	foreach ( $all_tickets as $ticket ) {
		if ( in_array( $ticket->status, array( 'paid', 'winner', 'lost' ), true ) ) {
			$paid_count++;
			$spent += (float) $ticket->price;
		}
		if ( 'winner' === $ticket->status ) {
			$win_count++;
		}
	}
	$draws = $wpdb->get_results( "SELECT id, title, draw_date FROM " . lotery_draw_table_name() . " WHERE id IN (SELECT DISTINCT draw_id FROM " . lotery_ticket_table_name() . " WHERE user_id = " . absint( $user_id ) . ") ORDER BY draw_date DESC" );
	ob_start();
	?>
	<div class="lotery-card">
		<h1 class="lotery-title"><?php esc_html_e( 'My tickets', 'lotery-tickets' ); ?></h1>
		<p class="lotery-subtitle"><?php esc_html_e( 'Only tickets belonging to your account are shown here.', 'lotery-tickets' ); ?></p>
		<div class="lotery-dashboard-stats"><div><strong><?php echo esc_html( count( $all_tickets ) ); ?></strong><span><?php esc_html_e( 'total tickets', 'lotery-tickets' ); ?></span></div><div><strong><?php echo esc_html( $paid_count ); ?></strong><span><?php esc_html_e( 'activated', 'lotery-tickets' ); ?></span></div><div><strong><?php echo esc_html( $win_count ); ?></strong><span><?php esc_html_e( 'winning tickets', 'lotery-tickets' ); ?></span></div><div><strong>$<?php echo esc_html( number_format_i18n( $spent, 2 ) ); ?></strong><span><?php esc_html_e( 'demo spend', 'lotery-tickets' ); ?></span></div></div>
		<form class="lotery-filters" method="get"><label><?php esc_html_e( 'Status', 'lotery-tickets' ); ?><select name="ticket_status"><option value=""><?php esc_html_e( 'All', 'lotery-tickets' ); ?></option><?php foreach ( array( 'pending', 'paid', 'winner', 'lost', 'cancelled' ) as $option ) : ?><option value="<?php echo esc_attr( $option ); ?>" <?php selected( $status, $option ); ?>><?php echo esc_html( lotery_ticket_status_label( $option ) ); ?></option><?php endforeach; ?></select></label><label><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?><select name="ticket_draw"><option value="0"><?php esc_html_e( 'All draws', 'lotery-tickets' ); ?></option><?php foreach ( $draws as $draw ) : ?><option value="<?php echo esc_attr( $draw->id ); ?>" <?php selected( $draw_id, $draw->id ); ?>><?php echo esc_html( $draw->title . ' · ' . $draw->draw_date ); ?></option><?php endforeach; ?></select></label><button class="lotery-button lotery-button-secondary" type="submit"><?php esc_html_e( 'Filter', 'lotery-tickets' ); ?></button></form>
		<?php if ( empty( $tickets ) ) : ?><p><?php esc_html_e( 'No tickets match these filters.', 'lotery-tickets' ); ?></p><?php else : ?><div class="lotery-table-wrap"><table class="lotery-table"><thead><tr><th><?php esc_html_e( 'Ticket', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Numbers', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Result', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Status', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Action', 'lotery-tickets' ); ?></th></tr></thead><tbody><?php foreach ( $tickets as $ticket ) : ?><tr><td><?php echo esc_html( $ticket->ticket_number ); ?></td><td><?php echo esc_html( str_replace( ',', ' · ', $ticket->selected_numbers ) ); ?></td><td><?php echo esc_html( $ticket->draw_date ); ?></td><td><?php echo esc_html( $ticket->winning_numbers ? str_replace( ',', ' · ', $ticket->winning_numbers ) : '—' ); ?></td><td><span class="lotery-status <?php echo in_array( $ticket->status, array( 'paid', 'winner' ), true ) ? 'lotery-status-paid' : ''; ?>"><?php echo esc_html( lotery_ticket_status_label( $ticket->status ) ); ?><?php if ( 'winner' === $ticket->status ) : ?> · $<?php echo esc_html( number_format_i18n( $ticket->winner_amount, 2 ) ); ?><?php endif; ?></span></td><td><?php if ( 'pending' === $ticket->status ) : ?><a class="lotery-button lotery-button-secondary" href="<?php echo esc_url( add_query_arg( 'ticket_id', absint( $ticket->id ), lotery_page_url( 'checkout', '/checkout/' ) ) ); ?>"><?php esc_html_e( 'Pay demo', 'lotery-tickets' ); ?></a><?php elseif ( in_array( $ticket->status, array( 'paid', 'winner', 'lost' ), true ) ) : ?><a class="lotery-button lotery-button-secondary" target="_blank" rel="noopener" href="<?php echo esc_url( add_query_arg( 'lotery_print_ticket', absint( $ticket->id ), home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Print', 'lotery-tickets' ); ?></a><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'lotery_my_tickets', 'lotery_customer_tickets_shortcode' );

function lotery_all_tickets_shortcode() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return '<div class="lotery-card"><h2>' . esc_html__( 'Administrator access required', 'lotery-tickets' ) . '</h2><p>' . esc_html__( 'This page is only available to lottery administrators.', 'lotery-tickets' ) . '</p></div>';
	}

	global $wpdb;
	$tickets = $wpdb->get_results( "SELECT t.*, u.user_login, u.user_email, d.title AS draw_title, d.selected_numbers AS winning_numbers FROM " . lotery_ticket_table_name() . " t LEFT JOIN " . $wpdb->users . " u ON u.ID = t.user_id LEFT JOIN " . lotery_draw_table_name() . " d ON d.id = t.draw_id ORDER BY t.created_at DESC" );
	ob_start();
	?>
	<div class="lotery-card">
		<p class="lotery-eyebrow"><?php esc_html_e( 'ADMINISTRATION', 'lotery-tickets' ); ?></p>
		<h1 class="lotery-title"><?php esc_html_e( 'All tickets', 'lotery-tickets' ); ?></h1>
		<p class="lotery-subtitle"><?php esc_html_e( 'Manage every customer ticket from the themed lottery site.', 'lotery-tickets' ); ?></p>
		<?php if ( empty( $tickets ) ) : ?>
			<p><?php esc_html_e( 'No tickets have been created yet.', 'lotery-tickets' ); ?></p>
		<?php else : ?>
			<div class="lotery-table-wrap"><table class="lotery-table"><thead><tr><th><?php esc_html_e( 'Customer', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Ticket', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Numbers', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Status', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Created', 'lotery-tickets' ); ?></th></tr></thead><tbody>
				<?php foreach ( $tickets as $ticket ) : ?>
					<tr><td><?php echo esc_html( $ticket->user_login . ' · ' . $ticket->user_email ); ?></td><td><?php echo esc_html( $ticket->ticket_number ); ?></td><td><?php echo esc_html( str_replace( ',', ' · ', $ticket->selected_numbers ) ); ?></td><td><?php echo esc_html( ( $ticket->draw_title ? $ticket->draw_title : __( 'Unknown draw', 'lotery-tickets' ) ) . ' · ' . $ticket->draw_date ); ?></td><td><span class="lotery-status <?php echo in_array( $ticket->status, array( 'paid', 'winner' ), true ) ? 'lotery-status-paid' : ''; ?>"><?php echo esc_html( lotery_ticket_status_label( $ticket->status ) ); ?></span></td><td><?php echo esc_html( $ticket->created_at ); ?></td></tr>
				<?php endforeach; ?>
			</tbody></table></div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'lotery_all_tickets', 'lotery_all_tickets_shortcode' );

function lotery_print_ticket() {
	if ( empty( $_GET['lotery_print_ticket'] ) || ! is_user_logged_in() ) {
		return;
	}
	global $wpdb;
	$id     = absint( $_GET['lotery_print_ticket'] );
	$ticket = $wpdb->get_row( $wpdb->prepare( "SELECT t.*, d.title AS draw_title, d.selected_numbers AS winning_numbers FROM " . lotery_ticket_table_name() . " t LEFT JOIN " . lotery_draw_table_name() . " d ON d.id = t.draw_id WHERE t.id = %d", $id ) );
	if ( ! $ticket || ! in_array( $ticket->status, array( 'paid', 'winner', 'lost' ), true ) || ( (int) $ticket->user_id !== get_current_user_id() && ! current_user_can( 'manage_options' ) ) ) {
		wp_die( esc_html__( 'You are not allowed to view this ticket.', 'lotery-tickets' ), 403 );
	}
	get_header();
	?>
	<main class="lotery-main"><div class="lotery-card lotery-print-ticket"><div class="lotery-no-print"><a href="#" onclick="window.print(); return false;" class="lotery-button"><?php esc_html_e( 'Print ticket', 'lotery-tickets' ); ?></a></div><h1><?php esc_html_e( 'Lottery ticket', 'lotery-tickets' ); ?></h1><p><strong><?php esc_html_e( 'Ticket number:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( $ticket->ticket_number ); ?></p><p><strong><?php esc_html_e( 'Draw:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( $ticket->draw_title . ' · ' . $ticket->draw_date ); ?></p><p><strong><?php esc_html_e( 'Your numbers:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( str_replace( ',', ' · ', $ticket->selected_numbers ) ); ?></p><p><strong><?php esc_html_e( 'Status:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( lotery_ticket_status_label( $ticket->status ) ); ?></p><?php if ( $ticket->winning_numbers ) : ?><p><strong><?php esc_html_e( 'Winning numbers:', 'lotery-tickets' ); ?></strong> <?php echo esc_html( str_replace( ',', ' · ', $ticket->winning_numbers ) ); ?></p><?php endif; ?></div></main>
	<?php
	get_footer();
	exit;
}
add_action( 'template_redirect', 'lotery_print_ticket', 2 );

function lotery_admin_menu() {
	add_menu_page( __( 'Lottery', 'lotery-tickets' ), __( 'Lottery', 'lotery-tickets' ), 'manage_options', 'lotery-tickets', 'lotery_admin_tickets_page', 'dashicons-tickets-alt' );
	add_submenu_page( 'lotery-tickets', __( 'Tickets', 'lotery-tickets' ), __( 'Tickets', 'lotery-tickets' ), 'manage_options', 'lotery-tickets', 'lotery_admin_tickets_page' );
	add_submenu_page( 'lotery-tickets', __( 'Draws', 'lotery-tickets' ), __( 'Draws', 'lotery-tickets' ), 'manage_options', 'lotery-draws', 'lotery_admin_draws_page' );
	add_submenu_page( 'lotery-tickets', __( 'Draw results', 'lotery-tickets' ), __( 'Draw results', 'lotery-tickets' ), 'manage_options', 'lotery-results', 'lotery_admin_results_page' );
}
add_action( 'admin_menu', 'lotery_admin_menu' );

function lotery_admin_tickets_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to view this page.', 'lotery-tickets' ), 403 );
	}
	global $wpdb;
	if ( isset( $_POST['lotery_admin_ticket_action'] ) ) {
		check_admin_referer( 'lotery_admin_ticket_action' );
		$id     = absint( $_POST['ticket_id'] ?? 0 );
		$status = sanitize_key( $_POST['ticket_status'] ?? '' );
		if ( in_array( $status, array( 'pending', 'paid', 'cancelled' ), true ) && $id ) {
			$wpdb->update( lotery_ticket_table_name(), array( 'status' => $status, 'payment_status' => 'paid' === $status ? 'paid' : 'pending' ), array( 'id' => $id ), array( '%s', '%s' ), array( '%d' ) );
		}
		wp_safe_redirect( admin_url( 'admin.php?page=lotery-tickets&updated=1' ) );
		exit;
	}
	$tickets = $wpdb->get_results( "SELECT t.*, u.user_login, u.user_email, d.title AS draw_title FROM " . lotery_ticket_table_name() . " t LEFT JOIN " . $wpdb->users . " u ON u.ID = t.user_id LEFT JOIN " . lotery_draw_table_name() . " d ON d.id = t.draw_id ORDER BY t.created_at DESC LIMIT 500" );
	?>
	<div class="wrap"><h1><?php esc_html_e( 'Lottery tickets', 'lotery-tickets' ); ?></h1><?php if ( isset( $_GET['updated'] ) ) : ?><div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Ticket updated.', 'lotery-tickets' ); ?></p></div><?php endif; ?><table class="widefat striped"><thead><tr><th><?php esc_html_e( 'Ticket', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Customer', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Draw / numbers', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Price', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Status', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Update', 'lotery-tickets' ); ?></th></tr></thead><tbody><?php foreach ( $tickets as $ticket ) : ?><tr><td><?php echo esc_html( $ticket->ticket_number ); ?></td><td><?php echo esc_html( $ticket->user_login . ' · ' . $ticket->user_email ); ?></td><td><?php echo esc_html( ( $ticket->draw_title ? $ticket->draw_title : $ticket->draw_date ) . ' · ' . $ticket->selected_numbers ); ?></td><td>$<?php echo esc_html( number_format_i18n( $ticket->price, 2 ) ); ?></td><td><?php echo esc_html( lotery_ticket_status_label( $ticket->status ) ); ?></td><td><form method="post"><?php wp_nonce_field( 'lotery_admin_ticket_action' ); ?><input type="hidden" name="ticket_id" value="<?php echo esc_attr( $ticket->id ); ?>"><select name="ticket_status"><?php foreach ( array( 'pending', 'paid', 'cancelled' ) as $status ) : ?><option value="<?php echo esc_attr( $status ); ?>" <?php selected( $ticket->status, $status ); ?>><?php echo esc_html( lotery_ticket_status_label( $status ) ); ?></option><?php endforeach; ?></select><button class="button" name="lotery_admin_ticket_action" value="1"><?php esc_html_e( 'Save', 'lotery-tickets' ); ?></button></form></td></tr><?php endforeach; ?></tbody></table></div>
	<?php
}

function lotery_admin_draws_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to view this page.', 'lotery-tickets' ), 403 );
	}
	global $wpdb;
	if ( isset( $_POST['lotery_update_draw'] ) ) {
		check_admin_referer( 'lotery_update_draw' );
		$draw_id = absint( $_POST['draw_id'] ?? 0 );
		$status  = sanitize_key( $_POST['draw_status'] ?? '' );
		if ( $draw_id && in_array( $status, array( 'open', 'closed' ), true ) ) {
			$wpdb->update( lotery_draw_table_name(), array( 'status' => $status ), array( 'id' => $draw_id ), array( '%s' ), array( '%d' ) );
		}
		wp_safe_redirect( admin_url( 'admin.php?page=lotery-draws&updated=1' ) );
		exit;
	}
	if ( isset( $_POST['lotery_create_draw'] ) ) {
		check_admin_referer( 'lotery_create_draw' );
		$title  = sanitize_text_field( wp_unslash( $_POST['draw_title'] ?? '' ) );
		$date   = sanitize_text_field( wp_unslash( $_POST['draw_date'] ?? '' ) );
		$jackpot = (float) ( $_POST['draw_jackpot'] ?? 0 );
		if ( $title && preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) && $jackpot >= 0 ) {
			$wpdb->insert( lotery_draw_table_name(), array( 'title' => $title, 'draw_date' => $date, 'jackpot' => $jackpot, 'status' => 'open', 'created_at' => current_time( 'mysql' ) ), array( '%s', '%s', '%f', '%s', '%s' ) );
		}
		wp_safe_redirect( admin_url( 'admin.php?page=lotery-draws&created=1' ) );
		exit;
	}
	$draws = $wpdb->get_results( "SELECT d.*, COUNT(t.id) AS ticket_count FROM " . lotery_draw_table_name() . " d LEFT JOIN " . lotery_ticket_table_name() . " t ON t.draw_id = d.id GROUP BY d.id ORDER BY d.draw_date DESC" );
	?>
	<div class="wrap"><h1><?php esc_html_e( 'Lottery draws', 'lotery-tickets' ); ?></h1><?php if ( isset( $_GET['created'] ) || isset( $_GET['updated'] ) ) : ?><div class="notice notice-success"><p><?php esc_html_e( 'Draw changes saved.', 'lotery-tickets' ); ?></p></div><?php endif; ?><h2><?php esc_html_e( 'Create a draw', 'lotery-tickets' ); ?></h2><form method="post" class="lotery-admin-form"><?php wp_nonce_field( 'lotery_create_draw' ); ?><p><label><?php esc_html_e( 'Title', 'lotery-tickets' ); ?> <input required type="text" name="draw_title" value="<?php echo esc_attr( __( 'Weekly Demo Draw', 'lotery-tickets' ) ); ?>"></label> <label><?php esc_html_e( 'Date', 'lotery-tickets' ); ?> <input required type="date" name="draw_date"></label> <label><?php esc_html_e( 'Jackpot', 'lotery-tickets' ); ?> <input required min="0" step="0.01" type="number" name="draw_jackpot" value="25000"></label> <button class="button button-primary" name="lotery_create_draw" value="1"><?php esc_html_e( 'Create draw', 'lotery-tickets' ); ?></button></p></form><h2><?php esc_html_e( 'All draws', 'lotery-tickets' ); ?></h2><table class="widefat striped"><thead><tr><th><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Date', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Jackpot', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Tickets', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Status', 'lotery-tickets' ); ?></th></tr></thead><tbody><?php foreach ( $draws as $draw ) : ?><tr><td><?php echo esc_html( $draw->title ); ?></td><td><?php echo esc_html( $draw->draw_date ); ?></td><td>$<?php echo esc_html( number_format_i18n( $draw->jackpot, 2 ) ); ?></td><td><?php echo esc_html( $draw->ticket_count ); ?></td><td><?php if ( in_array( $draw->status, array( 'open', 'closed' ), true ) ) : ?><form method="post"><?php wp_nonce_field( 'lotery_update_draw' ); ?><input type="hidden" name="draw_id" value="<?php echo esc_attr( $draw->id ); ?>"><select name="draw_status"><?php foreach ( array( 'open', 'closed' ) as $draw_status ) : ?><option value="<?php echo esc_attr( $draw_status ); ?>" <?php selected( $draw->status, $draw_status ); ?>><?php echo esc_html( ucfirst( $draw_status ) ); ?></option><?php endforeach; ?></select><button class="button" name="lotery_update_draw" value="1"><?php esc_html_e( 'Save', 'lotery-tickets' ); ?></button></form><?php else : ?><?php echo esc_html( ucfirst( $draw->status ) ); ?><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div>
	<?php
}

function lotery_numbers_match_count( $ticket_numbers, $winning_numbers ) {
	return count( array_intersect( lotery_parse_numbers( $ticket_numbers ), lotery_parse_numbers( $winning_numbers ) ) );
}

function lotery_admin_results_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to view this page.', 'lotery-tickets' ), 403 );
	}
	global $wpdb;
	if ( isset( $_POST['lotery_publish_results'] ) ) {
		check_admin_referer( 'lotery_publish_results' );
		$draw_id = absint( $_POST['draw_id'] ?? 0 );
		$numbers = lotery_parse_numbers( wp_unslash( $_POST['winning_numbers'] ?? '' ) );
		$draw    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . lotery_draw_table_name() . " WHERE id = %d", $draw_id ) );
		if ( $draw && 5 === count( $numbers ) ) {
			$winning = lotery_numbers_string( $numbers );
			$wpdb->update( lotery_draw_table_name(), array( 'selected_numbers' => $winning, 'status' => 'completed' ), array( 'id' => $draw_id ), array( '%s', '%s' ), array( '%d' ) );
			$tickets = $wpdb->get_results( $wpdb->prepare( "SELECT id, selected_numbers FROM " . lotery_ticket_table_name() . " WHERE draw_id = %d AND payment_status = %s", $draw_id, 'paid' ) );
			foreach ( $tickets as $ticket ) {
				$is_winner = 5 === lotery_numbers_match_count( $ticket->selected_numbers, $winning );
				$wpdb->update( lotery_ticket_table_name(), array( 'status' => $is_winner ? 'winner' : 'lost', 'winner_amount' => $is_winner ? (float) $draw->jackpot : 0 ), array( 'id' => $ticket->id ), array( '%s', '%f' ), array( '%d' ) );
			}
		}
		wp_safe_redirect( admin_url( 'admin.php?page=lotery-results&updated=1' ) );
		exit;
	}
	$draws = $wpdb->get_results( "SELECT * FROM " . lotery_draw_table_name() . " ORDER BY draw_date DESC" );
	?>
	<div class="wrap"><h1><?php esc_html_e( 'Publish draw results', 'lotery-tickets' ); ?></h1><?php if ( isset( $_GET['updated'] ) ) : ?><div class="notice notice-success"><p><?php esc_html_e( 'Results published and ticket statuses recalculated.', 'lotery-tickets' ); ?></p></div><?php endif; ?><p><?php esc_html_e( 'Enter five numbers to complete a draw. Paid tickets with all five numbers become winners; other paid tickets become non-winners.', 'lotery-tickets' ); ?></p><form method="post"><?php wp_nonce_field( 'lotery_publish_results' ); ?><p><label><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?> <select name="draw_id" required><?php foreach ( $draws as $draw ) : ?><option value="<?php echo esc_attr( $draw->id ); ?>"><?php echo esc_html( $draw->title . ' · ' . $draw->draw_date . ' · ' . ucfirst( $draw->status ) ); ?></option><?php endforeach; ?></select></label></p><p><label><?php esc_html_e( 'Winning numbers', 'lotery-tickets' ); ?> <input required pattern="([1-9]|[1-4][0-9]|50)(\s*,\s*([1-9]|[1-4][0-9]|50)){4}" type="text" name="winning_numbers" placeholder="5, 12, 23, 37, 49"></label></p><button class="button button-primary" name="lotery_publish_results" value="1"><?php esc_html_e( 'Publish results', 'lotery-tickets' ); ?></button></form><h2><?php esc_html_e( 'Published results', 'lotery-tickets' ); ?></h2><table class="widefat striped"><thead><tr><th><?php esc_html_e( 'Draw', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Date', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Winning numbers', 'lotery-tickets' ); ?></th><th><?php esc_html_e( 'Status', 'lotery-tickets' ); ?></th></tr></thead><tbody><?php foreach ( $draws as $draw ) : ?><tr><td><?php echo esc_html( $draw->title ); ?></td><td><?php echo esc_html( $draw->draw_date ); ?></td><td><?php echo esc_html( $draw->selected_numbers ? str_replace( ',', ' · ', $draw->selected_numbers ) : '—' ); ?></td><td><?php echo esc_html( ucfirst( $draw->status ) ); ?></td></tr><?php endforeach; ?></tbody></table></div>
	<?php
}

function lotery_payment_completed( $payment_id, $user_id, $ticket_id ) {
	global $wpdb;
	if ( ! lotery_ticket_columns_exist() || ! absint( $user_id ) || ! absint( $ticket_id ) || empty( $payment_id ) ) {
		return;
	}
	$wpdb->update( lotery_ticket_table_name(), array( 'status' => 'paid', 'payment_status' => 'paid', 'payment_id' => sanitize_text_field( $payment_id ), 'paid_at' => current_time( 'mysql' ) ), array( 'id' => absint( $ticket_id ), 'user_id' => absint( $user_id ), 'status' => 'pending' ), array( '%s', '%s', '%s', '%s' ), array( '%d', '%d', '%s' ) );
}
add_action( 'lottery_payment_completed', 'lotery_payment_completed', 10, 3 );
