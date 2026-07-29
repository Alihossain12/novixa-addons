<?php
/**
 * Abstract base widget. Every module extends THIS class rather than
 * \Elementor\Widget_Base directly, so shared behaviour (unique CSS
 * prefix, common style controls) lives in exactly one place.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Novixa_Addons_Widget_Base' ) ) {

	/**
	 * Class Novixa_Addons_Widget_Base
	 */
	abstract class Novixa_Addons_Widget_Base extends \Elementor\Widget_Base {

		/**
		 * All Novixa widgets render inside this CSS namespace so their
		 * front-end styles can never bleed into / clash with markup
		 * produced by another add-on plugin's widget of a similar name.
		 *
		 * @var string
		 */
		const CSS_PREFIX = 'novixa-addons';

		/**
		 * Group every widget under our own custom category + a shared
		 * keyword set (helps the Elementor panel search).
		 *
		 * @return array
		 */
		public function get_categories() {
			return array( 'novixa-addons' );
		}

		/**
		 * Common keywords appended in each concrete widget.
		 *
		 * @return array
		 */
		public function get_base_keywords() {
			return array( 'novixa', 'addons' );
		}

		/**
		 * Icon shown in the Elementor panel — falls back to a generic
		 * icon if a module forgets to override it.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-nerd';
		}

		/**
		 * Helper: build a BEM-style class name inside our own namespace,
		 * e.g. $this->bem( 'heading', 'title' ) => "novixa-addons-heading__title".
		 *
		 * @param string $block   Block name (usually the widget slug).
		 * @param string $element Optional element name.
		 * @param string $mod     Optional modifier name.
		 * @return string
		 */
		protected function bem( $block, $element = '', $mod = '' ) {
			$class = self::CSS_PREFIX . '-' . $block;

			if ( $element ) {
				$class .= '__' . $element;
			}

			if ( $mod ) {
				$class .= '--' . $mod;
			}

			return $class;
		}
	}
}
