<?php
/**
 * Button widget — Uiverse.io "blob" hover-effect button
 * (design credit: Uiverse.io by Randdose).
 *
 * Rebuilt to use a single element with a radial-gradient background
 * instead of absolutely-positioned pseudo-elements/spans. Colors live
 * in --novixa-* CSS custom properties (set via each control's
 * `selectors`) so the Elementor editor preview updates instantly with
 * no AJAX re-render; hover/active states are driven by a small scoped
 * <style> block written in render(), not JS, so they never depend on
 * a script finishing loading/binding first.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

if ( ! class_exists( 'Novixa_Addons_Widget_Button' ) ) {

	/**
	 * Class Novixa_Addons_Widget_Button
	 */
	class Novixa_Addons_Widget_Button extends Novixa_Addons_Widget_Base {

		/**
		 * Unique widget name registered with Elementor.
		 *
		 * @return string
		 */
		public function get_name() {
			return 'novixa-addons-button';
		}

		/**
		 * Panel label.
		 *
		 * @return string
		 */
		public function get_title() {
			return __( 'Button - Novixa', 'novixa-addons' );
		}

		/**
		 * Panel icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-button';
		}

		/**
		 * Panel search keywords.
		 *
		 * @return array
		 */
		public function get_keywords() {
			return array_merge( $this->get_base_keywords(), array( 'button', 'blob', 'uiverse', 'hover', 'cta' ) );
		}

		/**
		 * Kept as a dependency for consistency with the other widgets;
		 * this widget itself no longer needs JS (hover/active are pure
		 * CSS), but frontend.css (wrapper alignment) still applies.
		 *
		 * @return array
		 */
		public function get_script_depends() {
			return array( 'novixa-addons-frontend' );
		}

		/**
		 * Register all controls.
		 */
		protected function register_controls() {
			$this->register_content_controls();
			$this->register_style_controls();
		}

		/**
		 * Content tab.
		 */
		protected function register_content_controls() {
			$this->start_controls_section(
				'novixa_section_button_content',
				array(
					'label' => __( 'Button', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_text',
				array(
					'label'       => __( 'Text', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Button', 'novixa-addons' ),
					'label_block' => false,
				)
			);

			$this->add_control(
				'novixa_link',
				array(
					'label'         => __( 'Link', 'novixa-addons' ),
					'type'          => Controls_Manager::URL,
					'placeholder'   => __( 'https://your-link.com', 'novixa-addons' ),
					'show_external' => true,
					'default'       => array(
						'url' => '',
					),
				)
			);

			$this->add_responsive_control(
				'novixa_alignment',
				array(
					'label'     => __( 'Alignment', 'novixa-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options'   => array(
						'left'   => array(
							'title' => __( 'Left', 'novixa-addons' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => __( 'Center', 'novixa-addons' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => __( 'Right', 'novixa-addons' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'btn', 'wrap' ) => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab. Each color control writes a --novixa-* CSS custom
		 * property via `selectors` (instant, no-AJAX live preview);
		 * render() then reads the same settings only as a PHP fallback
		 * baked into var(--novixa-x, fallback).
		 */
		protected function register_style_controls() {
			$this->start_controls_section(
				'novixa_section_button_style',
				array(
					'label' => __( 'Button', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_control(
				'novixa_color',
				array(
					'label'     => __( 'Accent Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#00fa9a',
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'btn' ) => '--novixa-accent: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_hover_text_color',
				array(
					'label'     => __( 'Hover Text Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#212121',
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'btn' ) => '--novixa-hover-text: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_active_color',
				array(
					'label'     => __( 'Active / Blob Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#008080',
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'btn' ) => '--novixa-active: {{VALUE}};',
					),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Strip anything that isn't a plausible CSS color character.
		 * Defensive only (Elementor's COLOR control already validates
		 * input) — needed because these values are written straight
		 * into a <style> block below without further HTML-escaping.
		 *
		 * @param string $color Raw color value.
		 * @return string
		 */
		private function safe_color( $color ) {
			return preg_replace( '/[^a-zA-Z0-9#(),.%\s\-]/', '', (string) $color );
		}

		/**
		 * Build a two-stop radial-gradient "blob" circle string for a
		 * given color (hard 71% cutoff = a crisp circle, not a soft
		 * radial fade).
		 *
		 * @param string $color Any valid CSS color.
		 * @return string
		 */
		private function blob_gradient( $color ) {
			return 'radial-gradient(circle, ' . $color . ' 0%, ' . $color . ' 70%, transparent 71%)';
		}

		/**
		 * Front-end render.
		 *
		 * The blob effect is done with a background made of two
		 * circular radial-gradients (one per side) instead of extra
		 * DOM elements or ::before/::after content — everything lives
		 * on the single button/link element via inline style, and the
		 * hover/active state is toggled by a tiny scoped <style> block
		 * (see below), not JS.
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			// PHP-side fallbacks only — the *actual* live colors come from
			// the --novixa-* CSS custom properties written by the style
			// controls' `selectors` above, so the preview updates the
			// instant a color is changed (no AJAX re-render round trip,
			// which is what previously made color changes feel "stuck").
			$accent       = ! empty( $settings['novixa_color'] ) ? $this->safe_color( $settings['novixa_color'] ) : '#00fa9a';
			$hover_text   = ! empty( $settings['novixa_hover_text_color'] ) ? $this->safe_color( $settings['novixa_hover_text_color'] ) : '#212121';
			$active_color = ! empty( $settings['novixa_active_color'] ) ? $this->safe_color( $settings['novixa_active_color'] ) : '#008080';

			$accent_var     = 'var(--novixa-accent, ' . $accent . ')';
			$hover_text_var = 'var(--novixa-hover-text, ' . $hover_text . ')';
			$active_var     = 'var(--novixa-active, ' . $active_color . ')';

			$bg_rest   = $this->blob_gradient( $accent_var ) . ',' . $this->blob_gradient( $accent_var );
			$bg_active = $this->blob_gradient( $active_var ) . ',' . $this->blob_gradient( $active_var );
			$pos_rest  = '-8em center, calc(100% + 8em) center';
			$pos_hover = '-1em center, calc(100% + 1em) center';

			// Unique id so the base + hover/active states below can be
			// scoped with plain CSS instead of an inline style attribute.
			// This matters: an inline style="" declaration with
			// !important can NEVER be overridden by a stylesheet rule's
			// !important (inline always wins), which is why the base
			// look must live in this <style> block too, not in the
			// element's style="" attribute — otherwise :hover/:active
			// below would never be able to change anything.
			$uid = 'novixa-btn-' . esc_attr( $this->get_id() );

			$this->add_render_attribute( 'novixa_btn', 'id', $uid );
			$this->add_render_attribute( 'novixa_btn', 'class', $this->bem( 'btn' ) );

			$base_css = 'display: inline-flex !important;'
				. 'align-items: center !important;'
				. 'position: relative !important;'
				. 'box-sizing: border-box !important;'
				. 'padding: 0.6em 2em !important;'
				. 'border-style: solid !important;'
				. 'border-width: 0.15em !important;'
				. 'border-color: ' . $accent_var . ' !important;'
				. 'border-radius: 0.25em !important;'
				. 'box-shadow: none !important;'
				. 'font-size: 1.5em !important;'
				. 'font-weight: 600 !important;'
				. 'line-height: normal !important;'
				. 'cursor: pointer !important;'
				. 'overflow: hidden !important;'
				. 'transition: border-color 300ms, color 300ms, background-position 400ms, background-image 300ms !important;'
				. 'user-select: none !important;'
				. 'text-decoration: none !important;'
				. 'text-transform: none !important;'
				. 'width: auto !important;'
				. 'height: auto !important;'
				. 'margin: 0 !important;'
				. 'outline: none !important;'
				. 'appearance: none !important;'
				. '-webkit-appearance: none !important;'
				. '-moz-appearance: none !important;'
				. 'vertical-align: middle !important;'
				. 'font-family: inherit !important;'
				. 'color: ' . $accent_var . ' !important;'
				. 'background-color: transparent !important;'
				. 'background-repeat: no-repeat, no-repeat !important;'
				. 'background-size: 9em 9em, 9em 9em !important;'
				. 'background-image: ' . $bg_rest . ' !important;'
				. 'background-position: ' . $pos_rest . ' !important;';

			$has_link = ! empty( $settings['novixa_link']['url'] );

			if ( $has_link ) {
				$this->add_link_attributes( 'novixa_btn', $settings['novixa_link'] );
			}

			$tag = $has_link ? 'a' : 'button';

			printf( '<div class="%1$s">', esc_attr( $this->bem( 'btn', 'wrap' ) ) );

			// Base look + hover/active states all live in one scoped
			// stylesheet block keyed to this button's unique id — NOT
			// in a style="" attribute, so :hover/:active can actually
			// override the resting look (see note above).
			printf(
				'<style>#%1$s{%2$s}#%1$s:hover{background-position:%3$s !important;color:%4$s !important;}#%1$s:active{background-image:%5$s !important;}</style>',
				esc_attr( $uid ),
				$base_css, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built entirely from fixed strings + color values already destined for a style attribute.
				esc_attr( $pos_hover ),
				esc_attr( $hover_text_var ),
				esc_attr( $bg_active )
			);

			echo '<' . $tag . ' ' . $this->get_render_attribute_string( 'novixa_btn' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			echo '<p class="' . esc_attr( $this->bem( 'btn', 'text' ) ) . '" style="margin:0 !important;padding:0 !important;position:relative;">' . esc_html( $settings['novixa_text'] ) . '</p>';

			echo '</' . $tag . '>';
			echo '</div>';
		}
	}
}
