<?php
/**
 * Global procedural helpers.
 * Every function name is prefixed with novixa_addons_ to avoid any
 * collision with other plugins' global function namespaces.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'novixa_addons_get_settings' ) ) {
	/**
	 * Fetch the merged (saved + defaults) settings array.
	 *
	 * @return array
	 */
	function novixa_addons_get_settings() {
		return Novixa_Addons_Settings::get_settings();
	}
}

if ( ! function_exists( 'novixa_addons_is_widget_enabled' ) ) {
	/**
	 * Check whether a single widget/module is toggled on in the dashboard.
	 *
	 * @param string $slug Module slug, e.g. 'heading'.
	 * @return bool
	 */
	function novixa_addons_is_widget_enabled( $slug ) {
		return Novixa_Addons_Settings::is_widget_enabled( $slug );
	}
}

if ( ! function_exists( 'novixa_addons_get_option' ) ) {
	/**
	 * Read a single settings value with a fallback.
	 *
	 * @param string $key     Option key.
	 * @param mixed  $default Fallback value.
	 * @return mixed
	 */
	function novixa_addons_get_option( $key, $default = '' ) {
		$settings = novixa_addons_get_settings();
		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'novixa_addons_asset_url' ) ) {
	/**
	 * Build a URL inside this plugin's /assets/ folder.
	 *
	 * @param string $path Relative path, e.g. 'css/admin.css'.
	 * @return string
	 */
	function novixa_addons_asset_url( $path ) {
		return NOVIXA_ADDONS_ASSETS_URL . ltrim( $path, '/' );
	}
}

if ( ! function_exists( 'novixa_addons_get_template' ) ) {
	/**
	 * Load an admin/template partial, isolated in its own scope.
	 *
	 * @param string $template_name File name inside /templates/ (no extension).
	 * @param array  $args          Variables extracted into the template scope.
	 */
	function novixa_addons_get_template( $template_name, $args = array() ) {
		$file = NOVIXA_ADDONS_PATH . 'templates/' . $template_name . '.php';

		if ( ! file_exists( $file ) ) {
			return;
		}

		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args, EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract
		}

		include $file;
	}
}

if ( ! function_exists( 'novixa_addons_widgets_registry' ) ) {
	/**
	 * Central registry describing every widget/module the plugin ships.
	 * Adding a new module later only means adding one row here plus
	 * its own modules/<slug>/ folder — nothing else has to change.
	 *
	 * @return array
	 */
	function novixa_addons_widgets_registry() {
		return array(
			'heading'     => array(
				'label'       => __( 'Heading', 'novixa-addons' ),
				'icon'        => 'eicon-t-letter',
				'description' => __( 'A flexible heading widget with highlighted-text and sub-title support.', 'novixa-addons' ),
				'category'    => __( 'Common', 'novixa-addons' ),
				'class_file'  => 'class-widget-heading.php',
				'class_name'  => 'Novixa_Addons_Widget_Heading',
			),
			'text-editor' => array(
				'label'       => __( 'Text Editor', 'novixa-addons' ),
				'icon'        => 'eicon-text',
				'description' => __( 'A rich-text editor widget with drop-cap and column support.', 'novixa-addons' ),
				'category'    => __( 'Common', 'novixa-addons' ),
				'class_file'  => 'class-widget-text-editor.php',
				'class_name'  => 'Novixa_Addons_Widget_Text_Editor',
			),
			'icon-box'    => array(
				'label'       => __( 'Icon Box', 'novixa-addons' ),
				'icon'        => 'eicon-icon-box',
				'description' => __( 'A luxury icon box with shape, hover animation and box-shadow controls.', 'novixa-addons' ),
				'category'    => __( 'Common', 'novixa-addons' ),
				'class_file'  => 'class-widget-icon-box.php',
				'class_name'  => 'Novixa_Addons_Widget_Icon_Box',
			),
			'image-box'   => array(
				'label'       => __( 'Image Box', 'novixa-addons' ),
				'icon'        => 'eicon-image-box',
				'description' => __( 'A luxury image box with hover zoom/grayscale effects and flexible layout.', 'novixa-addons' ),
				'category'    => __( 'Common', 'novixa-addons' ),
				'class_file'  => 'class-widget-image-box.php',
				'class_name'  => 'Novixa_Addons_Widget_Image_Box',
			),
			'button'      => array(
				'label'       => __( 'Button', 'novixa-addons' ),
				'icon'        => 'eicon-button',
				'description' => __( 'A button widget with a Uiverse.io-style blob hover effect.', 'novixa-addons' ),
				'category'    => __( 'Common', 'novixa-addons' ),
				'class_file'  => 'class-widget-button.php',
				'class_name'  => 'Novixa_Addons_Widget_Button',
			),
		);
	}
}
