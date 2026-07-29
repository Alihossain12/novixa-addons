<?php
/**
 * Plugin Name:       Novixa Addons for Elementor
 * Plugin URI:         https://novixa.com/addons-for-elementor/
 * Description:        A unique, independent collection of creative widgets and a control panel for Elementor page builder.
 * Version:             1.5.1
 * Requires at least:  6.0
 * Requires PHP:        7.4
 * Author:              Novixa
 * Author URI:          https://novixa.com/
 * Text Domain:         novixa-addons
 * Domain Path:         /languages
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Requires Plugins:    elementor
 *
 * @package Novixa_Addons
 */

// Block direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All constants are prefixed with NOVIXA_ADDONS_ so they can never collide
 * with Essential Addons, Ultimate Addons, Happy Addons or any other
 * third-party Elementor add-on plugin.
 */
define( 'NOVIXA_ADDONS_VERSION', '1.5.1' );
define( 'NOVIXA_ADDONS_FILE', __FILE__ );
define( 'NOVIXA_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'NOVIXA_ADDONS_URL', plugin_dir_url( __FILE__ ) );
define( 'NOVIXA_ADDONS_BASENAME', plugin_basename( __FILE__ ) );
define( 'NOVIXA_ADDONS_ASSETS_URL', NOVIXA_ADDONS_URL . 'assets/' );
define( 'NOVIXA_ADDONS_MODULES_PATH', NOVIXA_ADDONS_PATH . 'modules/' );
define( 'NOVIXA_ADDONS_MIN_ELEMENTOR_VERSION', '3.5.0' );
define( 'NOVIXA_ADDONS_MIN_PHP_VERSION', '7.4' );
define( 'NOVIXA_ADDONS_TEXT_DOMAIN', 'novixa-addons' );
define( 'NOVIXA_ADDONS_OPTION_KEY', 'novixa_addons_settings' );

/**
 * Composer-free, self-contained includes.
 * Kept deliberately explicit (no external namespaced autoload) so the
 * plugin has zero dependency collisions when activated next to other
 * Elementor add-on plugins.
 */
require_once NOVIXA_ADDONS_PATH . 'includes/functions.php';
require_once NOVIXA_ADDONS_PATH . 'includes/class-helper.php';
require_once NOVIXA_ADDONS_PATH . 'includes/class-loader.php';
require_once NOVIXA_ADDONS_PATH . 'includes/class-settings.php';
require_once NOVIXA_ADDONS_PATH . 'includes/class-assets.php';
require_once NOVIXA_ADDONS_PATH . 'includes/class-admin.php';
require_once NOVIXA_ADDONS_PATH . 'includes/class-license.php';
require_once NOVIXA_ADDONS_PATH . 'includes/class-plugin.php';

/**
 * Boot the plugin on `plugins_loaded` so Elementor (and translations)
 * are guaranteed to be available first.
 *
 * @return Novixa_Addons_Plugin
 */
function novixa_addons() {
	return Novixa_Addons_Plugin::instance();
}

add_action( 'plugins_loaded', 'novixa_addons' );

/**
 * Activation hook — set sane defaults, never touch other plugins' options.
 */
function novixa_addons_activate() {
	if ( false === get_option( NOVIXA_ADDONS_OPTION_KEY ) ) {
		update_option( NOVIXA_ADDONS_OPTION_KEY, Novixa_Addons_Settings::get_default_settings() );
	}
	update_option( 'novixa_addons_activation_redirect', true );
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'novixa_addons_activate' );

/**
 * Deactivation hook — keep settings, just flush rewrite rules.
 */
function novixa_addons_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'novixa_addons_deactivate' );
