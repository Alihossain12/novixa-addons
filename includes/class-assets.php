<?php
/**
 * Registers/enqueues all CSS + JS. Every handle is prefixed with
 * `novixa-addons-` so it can never dequeue/override another plugin's
 * assets (a very common cause of admin-dashboard clones breaking).
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Novixa_Addons_Assets' ) ) {

	/**
	 * Class Novixa_Addons_Assets
	 */
	class Novixa_Addons_Assets {

		/**
		 * Enqueue assets for our own admin dashboard screen only.
		 *
		 * @param string $hook Current admin page hook suffix.
		 */
		public function admin_assets( $hook ) {
			if ( false === strpos( $hook, 'novixa-addons' ) ) {
				return;
			}

			wp_enqueue_style( 'dashicons' );

			wp_enqueue_style(
				'novixa-addons-admin',
				novixa_addons_asset_url( 'css/admin.css' ),
				array(),
				NOVIXA_ADDONS_VERSION
			);

			wp_enqueue_script(
				'novixa-addons-admin',
				novixa_addons_asset_url( 'js/admin.js' ),
				array( 'jquery', 'wp-util' ),
				NOVIXA_ADDONS_VERSION,
				true
			);

			wp_localize_script(
				'novixa-addons-admin',
				'NovixaAddonsAdmin',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'novixa_addons_admin_nonce' ),
					'i18n'    => array(
						'saved' => __( 'Settings saved.', 'novixa-addons' ),
						'error' => __( 'Something went wrong. Please try again.', 'novixa-addons' ),
					),
				)
			);
		}

		/**
		 * Front-end styles/scripts — only loaded when at least one of our
		 * widgets is actually present on the page (perf-friendly).
		 */
		public function frontend_assets() {
			wp_register_style(
				'novixa-addons-frontend',
				novixa_addons_asset_url( 'css/frontend.css' ),
				array(),
				NOVIXA_ADDONS_VERSION
			);

			wp_register_script(
				'novixa-addons-frontend',
				novixa_addons_asset_url( 'js/frontend.js' ),
				array( 'jquery' ),
				NOVIXA_ADDONS_VERSION,
				true
			);

			wp_enqueue_style( 'novixa-addons-frontend' );
			wp_enqueue_script( 'novixa-addons-frontend' );
		}

		/**
		 * Assets loaded only inside the Elementor editor iframe.
		 */
		public function editor_assets() {
			wp_enqueue_style(
				'novixa-addons-editor',
				novixa_addons_asset_url( 'css/editor.css' ),
				array(),
				NOVIXA_ADDONS_VERSION
			);

			wp_enqueue_script(
				'novixa-addons-editor',
				novixa_addons_asset_url( 'js/editor.js' ),
				array( 'jquery' ),
				NOVIXA_ADDONS_VERSION,
				true
			);
		}
	}
}
