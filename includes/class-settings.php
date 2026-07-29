<?php
/**
 * Reads/writes the single `novixa_addons_settings` option that stores
 * every module toggle + general preference. Deliberately stored under
 * ONE option (not per-widget options) to keep the wp_options table clean
 * and avoid any key collisions with other plugins.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Novixa_Addons_Settings' ) ) {

	/**
	 * Class Novixa_Addons_Settings
	 */
	class Novixa_Addons_Settings {

		/**
		 * In-memory cache for a single request.
		 *
		 * @var array|null
		 */
		protected static $cache = null;

		/**
		 * Default settings — every registered widget defaults to enabled.
		 *
		 * @return array
		 */
		public static function get_default_settings() {
			$defaults = array(
				'widgets' => array(),
			);

			foreach ( array_keys( novixa_addons_widgets_registry() ) as $slug ) {
				$defaults['widgets'][ $slug ] = true;
			}

			return $defaults;
		}

		/**
		 * Merged settings (saved values layered on top of defaults so a
		 * newly added widget in a future update is enabled by default).
		 *
		 * @return array
		 */
		public static function get_settings() {
			if ( null !== self::$cache ) {
				return self::$cache;
			}

			$saved    = get_option( NOVIXA_ADDONS_OPTION_KEY, array() );
			$defaults = self::get_default_settings();

			if ( ! is_array( $saved ) ) {
				$saved = array();
			}

			$merged = wp_parse_args( $saved, $defaults );

			if ( isset( $saved['widgets'] ) && is_array( $saved['widgets'] ) ) {
				$merged['widgets'] = wp_parse_args( $saved['widgets'], $defaults['widgets'] );
			}

			self::$cache = $merged;

			return $merged;
		}

		/**
		 * Persist a full settings array.
		 *
		 * @param array $settings New settings.
		 * @return bool
		 */
		public static function update_settings( $settings ) {
			self::$cache = null;
			return update_option( NOVIXA_ADDONS_OPTION_KEY, $settings );
		}

		/**
		 * Toggle check for a single widget slug.
		 *
		 * @param string $slug Widget slug.
		 * @return bool
		 */
		public static function is_widget_enabled( $slug ) {
			$settings = self::get_settings();
			return ! empty( $settings['widgets'][ $slug ] );
		}
	}
}
