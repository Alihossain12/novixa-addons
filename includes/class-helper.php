<?php
/**
 * Small static helper utilities shared across admin + widgets.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Novixa_Addons_Helper' ) ) {

	/**
	 * Class Novixa_Addons_Helper
	 */
	class Novixa_Addons_Helper {

		/**
		 * Is Elementor active + loaded?
		 *
		 * @return bool
		 */
		public static function is_elementor_active() {
			return did_action( 'elementor/loaded' ) || class_exists( '\Elementor\Plugin' );
		}

		/**
		 * Version compare helper.
		 *
		 * @param string $version    Version to check.
		 * @param string $compare_to Minimum required version.
		 * @return bool
		 */
		public static function version_ok( $version, $compare_to ) {
			return version_compare( $version, $compare_to, '>=' );
		}

		/**
		 * Sanitize a settings array recursively (bool/string only — this
		 * plugin's settings never need arrays-of-arrays).
		 *
		 * @param array $raw Raw $_POST-derived array.
		 * @return array
		 */
		public static function sanitize_settings_array( $raw ) {
			$clean = array();

			foreach ( (array) $raw as $key => $value ) {
				$key = sanitize_key( $key );

				if ( is_array( $value ) ) {
					$clean[ $key ] = self::sanitize_settings_array( $value );
				} elseif ( is_bool( $value ) ) {
					$clean[ $key ] = (bool) $value;
				} else {
					$clean[ $key ] = sanitize_text_field( wp_unslash( $value ) );
				}
			}

			return $clean;
		}

		/**
		 * Count enabled vs total widgets — used on the dashboard summary card.
		 *
		 * @return array{enabled:int,total:int}
		 */
		public static function get_widget_stats() {
			$registry = novixa_addons_widgets_registry();
			$total    = count( $registry );
			$enabled  = 0;

			foreach ( array_keys( $registry ) as $slug ) {
				if ( novixa_addons_is_widget_enabled( $slug ) ) {
					++$enabled;
				}
			}

			return array(
				'enabled' => $enabled,
				'total'   => $total,
			);
		}
	}
}
