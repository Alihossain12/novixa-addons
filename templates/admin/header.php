<?php
/**
 * Shared shell (sidebar + topbar) for every Novixa Addons admin screen.
 *
 * @var string $active Current tab: dashboard|elements|settings.
 * @var string $title  Page title shown in the topbar.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$novixa_addons_nav = array(
	'dashboard' => array(
		'label' => __( 'Dashboard', 'novixa-addons' ),
		'icon'  => 'dashicons-grid-view',
		'url'   => admin_url( 'admin.php?page=novixa-addons' ),
	),
	'elements'  => array(
		'label' => __( 'Elements', 'novixa-addons' ),
		'icon'  => 'dashicons-layout',
		'url'   => admin_url( 'admin.php?page=novixa-addons-elements' ),
	),
	'settings'  => array(
		'label' => __( 'Settings', 'novixa-addons' ),
		'icon'  => 'dashicons-admin-generic',
		'url'   => admin_url( 'admin.php?page=novixa-addons-settings' ),
	),
);
?>
<div class="novixa-addons-app">

	<aside class="novixa-addons-sidebar">
		<div class="novixa-addons-sidebar__brand">
			<span class="novixa-addons-sidebar__logo" aria-hidden="true">N</span>
			<div class="novixa-addons-sidebar__brand-text">
				<strong><?php esc_html_e( 'Novixa', 'novixa-addons' ); ?></strong>
				<span><?php esc_html_e( 'Addons for Elementor', 'novixa-addons' ); ?></span>
			</div>
		</div>

		<nav class="novixa-addons-sidebar__nav" aria-label="<?php esc_attr_e( 'Novixa Addons Sections', 'novixa-addons' ); ?>">
			<?php foreach ( $novixa_addons_nav as $novixa_addons_slug => $novixa_addons_item ) : ?>
				<a
					href="<?php echo esc_url( $novixa_addons_item['url'] ); ?>"
					class="novixa-addons-sidebar__link<?php echo $active === $novixa_addons_slug ? ' is-active' : ''; ?>"
				>
					<span class="dashicons <?php echo esc_attr( $novixa_addons_item['icon'] ); ?>"></span>
					<?php echo esc_html( $novixa_addons_item['label'] ); ?>
				</a>
			<?php endforeach; ?>
		</nav>

		<div class="novixa-addons-sidebar__footer">
			<div class="novixa-addons-plan-card">
				<span class="novixa-addons-plan-card__badge novixa-addons-badge--<?php echo Novixa_Addons_License::is_active() ? 'pro' : 'free'; ?>">
					<?php echo esc_html( Novixa_Addons_License::status_label() ); ?>
				</span>
				<p><?php esc_html_e( 'You are running the free version of Novixa Addons.', 'novixa-addons' ); ?></p>
			</div>
			<a class="novixa-addons-sidebar__external" href="https://novixa.com/support/" target="_blank" rel="noopener noreferrer">
				<span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Get Support', 'novixa-addons' ); ?>
			</a>
			<span class="novixa-addons-sidebar__version">v<?php echo esc_html( NOVIXA_ADDONS_VERSION ); ?></span>
		</div>
	</aside>

	<div class="novixa-addons-main">

		<header class="novixa-addons-topbar">
			<div class="novixa-addons-topbar__title">
				<h1><?php echo esc_html( $title ); ?></h1>
			</div>
			<div class="novixa-addons-topbar__actions">
				<span class="novixa-addons-topbar__status">
					<span class="novixa-addons-dot novixa-addons-dot--<?php echo Novixa_Addons_Helper::is_elementor_active() ? 'ok' : 'warn'; ?>"></span>
					<?php
					echo Novixa_Addons_Helper::is_elementor_active()
						? esc_html__( 'Elementor Connected', 'novixa-addons' )
						: esc_html__( 'Elementor Not Active', 'novixa-addons' );
					?>
				</span>
			</div>
		</header>

		<div class="novixa-addons-notice" id="novixa-addons-notice" hidden></div>

		<main class="novixa-addons-content">
