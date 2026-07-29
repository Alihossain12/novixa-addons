<?php
/**
 * Placeholder license handler. Ships inert for the free/WordPress.org
 * build — no remote requests are made anywhere in this class. A future
 * paid extension can hook into `novixa_addons_license_status` without
 * modifying core files.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Novixa_Addons_License' ) ) {

	/**
	 * Class Novixa_Addons_License
	 */
	class Novixa_Addons_License {

		/**
		 * Option name storing the (optional) license key.
		 *
		 * @var string
		 */
		const OPTION_KEY = 'novixa_addons_license_key';

		/**
		 * Option name storing the license status.
		 *
		 * @var string
		 */
		const STATUS_KEY = 'novixa_addons_license_status';

		/**
		 * Whether a Pro license is currently active.
		 *
		 * @return bool
		 */
		public static function is_active() {
			/**
			 * Filter to let a separate Pro add-on plugin report an active
			 * license without this free plugin ever phoning home itself.
			 *
			 * @param bool $active Default false (free version).
			 */
			return (bool) apply_filters( 'novixa_addons_license_status', false );
		}

		/**
		 * Human readable status label for the dashboard badge.
		 *
		 * @return string
		 */
		public static function status_label() {
			return self::is_active()
				? __( 'Pro Active', 'novixa-addons' )
				: __( 'Free Version', 'novixa-addons' );
		}
	}
}
