<?php
/**
 * Builds the wp-admin menu + renders the dashboard/elements/settings
 * screens. Menu slug, capability and every DOM id/class are namespaced
 * with `novixa-addons` / `novixa_addons_` so the screen can sit side by
 * side with Essential Addons, Happy Addons, etc. without any clash.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Novixa_Addons_Admin' ) ) {

	/**
	 * Class Novixa_Addons_Admin
	 */
	class Novixa_Addons_Admin {

		/**
		 * Top-level menu slug.
		 *
		 * @var string
		 */
		const MENU_SLUG = 'novixa-addons';

		/**
		 * Register the top-level admin menu + submenus.
		 */
		public function register_menu() {
			$capability = 'manage_options';

			add_menu_page(
				__( 'Novixa Addons', 'novixa-addons' ),
				__( 'Novixa Addons', 'novixa-addons' ),
				$capability,
				self::MENU_SLUG,
				array( $this, 'render_dashboard_page' ),
				'data:image/svg+xml;base64,' . base64_encode( $this->menu_icon_svg() ), // phpcs:ignore
				59
			);

			add_submenu_page(
				self::MENU_SLUG,
				__( 'Dashboard', 'novixa-addons' ),
				__( 'Dashboard', 'novixa-addons' ),
				$capability,
				self::MENU_SLUG,
				array( $this, 'render_dashboard_page' )
			);

			add_submenu_page(
				self::MENU_SLUG,
				__( 'Elements', 'novixa-addons' ),
				__( 'Elements', 'novixa-addons' ),
				$capability,
				self::MENU_SLUG . '-elements',
				array( $this, 'render_elements_page' )
			);

			add_submenu_page(
				self::MENU_SLUG,
				__( 'Settings', 'novixa-addons' ),
				__( 'Settings', 'novixa-addons' ),
				$capability,
				self::MENU_SLUG . '-settings',
				array( $this, 'render_settings_page' )
			);
		}

		/**
		 * Inline SVG used as the menu icon (dashicon-style, currentColor).
		 *
		 * @return string
		 */
		protected function menu_icon_svg() {
			return '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill="#a7aaad" d="M2 3h7v7H2V3zm9 0h7v4h-7V3zM2 12h7v5H2v-5zm9-3h7v8h-7V9z"/></svg>';
		}

		/**
		 * Shared header/sidebar markup wrapper for every screen.
		 *
		 * @param string $active Current tab slug: dashboard|elements|settings.
		 * @param string $title  Page title shown in the topbar.
		 */
		protected function render_header( $active, $title ) {
			novixa_addons_get_template(
				'admin/header',
				array(
					'active' => $active,
					'title'  => $title,
				)
			);
		}

		/**
		 * Dashboard (overview) screen.
		 */
		public function render_dashboard_page() {
			$this->render_header( 'dashboard', __( 'Dashboard', 'novixa-addons' ) );
			novixa_addons_get_template(
				'admin/dashboard',
				array( 'stats' => Novixa_Addons_Helper::get_widget_stats() )
			);
		}

		/**
		 * Elements (widget on/off grid) screen.
		 */
		public function render_elements_page() {
			$this->render_header( 'elements', __( 'Elements', 'novixa-addons' ) );
			novixa_addons_get_template(
				'admin/elements',
				array(
					'registry' => novixa_addons_widgets_registry(),
					'stats'    => Novixa_Addons_Helper::get_widget_stats(),
				)
			);
		}

		/**
		 * Settings screen.
		 */
		public function render_settings_page() {
			$this->render_header( 'settings', __( 'Settings', 'novixa-addons' ) );
			novixa_addons_get_template(
				'admin/settings',
				array( 'settings' => novixa_addons_get_settings() )
			);
		}

		/**
		 * AJAX: toggle a single widget on/off from the Elements grid.
		 */
		public function ajax_toggle_widget() {
			check_ajax_referer( 'novixa_addons_admin_nonce', 'nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'novixa-addons' ) ) );
			}

			$slug    = isset( $_POST['slug'] ) ? sanitize_key( wp_unslash( $_POST['slug'] ) ) : '';
			$enabled = isset( $_POST['enabled'] ) ? sanitize_text_field( wp_unslash( $_POST['enabled'] ) ) : '';
			$enabled = ( 'true' === $enabled );

			$registry = novixa_addons_widgets_registry();

			if ( ! isset( $registry[ $slug ] ) ) {
				wp_send_json_error( array( 'message' => __( 'Unknown widget.', 'novixa-addons' ) ) );
			}

			$settings                     = novixa_addons_get_settings();
			$settings['widgets'][ $slug ] = $enabled;

			Novixa_Addons_Settings::update_settings( $settings );

			wp_send_json_success(
				array(
					'slug'    => $slug,
					'enabled' => $enabled,
					'message' => __( 'Settings saved.', 'novixa-addons' ),
				)
			);
		}

		/**
		 * AJAX: save the general Settings tab form.
		 */
		public function ajax_save_settings() {
			check_ajax_referer( 'novixa_addons_admin_nonce', 'nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'novixa-addons' ) ) );
			}

			$posted   = isset( $_POST['settings'] ) ? (array) wp_unslash( $_POST['settings'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$clean    = Novixa_Addons_Helper::sanitize_settings_array( $posted );
			$settings = novixa_addons_get_settings();

			$settings = array_merge( $settings, $clean );

			Novixa_Addons_Settings::update_settings( $settings );

			wp_send_json_success( array( 'message' => __( 'Settings saved.', 'novixa-addons' ) ) );
		}

		/**
		 * Redirect to the dashboard once, right after activation.
		 */
		public function maybe_activation_redirect() {
			if ( ! get_option( 'novixa_addons_activation_redirect' ) ) {
				return;
			}

			delete_option( 'novixa_addons_activation_redirect' );

			if ( isset( $_GET['activate-multi'] ) || wp_doing_ajax() ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				return;
			}

			wp_safe_redirect( admin_url( 'admin.php?page=' . self::MENU_SLUG ) );
			exit;
		}

		/**
		 * "Dashboard" link on the Plugins list screen.
		 *
		 * @param array $links Existing action links.
		 * @return array
		 */
		public function plugin_action_links( $links ) {
			$settings_link = sprintf(
				'<a href="%s">%s</a>',
				esc_url( admin_url( 'admin.php?page=' . self::MENU_SLUG ) ),
				esc_html__( 'Dashboard', 'novixa-addons' )
			);

			array_unshift( $links, $settings_link );

			return $links;
		}
	}
}
