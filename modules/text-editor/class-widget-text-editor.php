<?php
/**
 * Text Editor widget.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! class_exists( 'Novixa_Addons_Widget_Text_Editor' ) ) {

	/**
	 * Class Novixa_Addons_Widget_Text_Editor
	 */
	class Novixa_Addons_Widget_Text_Editor extends Novixa_Addons_Widget_Base {

		use Novixa_Addons_Global_Controls;

		/**
		 * Unique widget name registered with Elementor.
		 *
		 * @return string
		 */
		public function get_name() {
			return 'novixa-addons-text-editor';
		}

		/**
		 * Panel label.
		 *
		 * @return string
		 */
		public function get_title() {
			return __( 'Text Editor - Novixa', 'novixa-addons' );
		}

		/**
		 * Panel icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-text';
		}

		/**
		 * Panel search keywords.
		 *
		 * @return array
		 */
		public function get_keywords() {
			return array_merge( $this->get_base_keywords(), array( 'text', 'editor', 'content', 'rich text' ) );
		}

		/**
		 * Style dependency.
		 *
		 * @return array
		 */
		public function get_style_depends() {
			return array( 'novixa-addons-frontend' );
		}

		/**
		 * Register all controls.
		 */
		protected function register_controls() {
			$this->register_content_controls();
			$this->register_editor_style_controls();
			$this->register_drop_cap_style_controls();
			$this->register_spacing_controls();
		}

		/**
		 * Content tab.
		 */
		protected function register_content_controls() {
			$this->start_controls_section(
				'novixa_section_editor_content',
				array(
					'label' => __( 'Text Editor', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_editor',
				array(
					'label'       => __( 'Content', 'novixa-addons' ),
					'type'        => Controls_Manager::WYSIWYG,
					'default'     => __( 'Add your custom text here. Keep it short and simple.', 'novixa-addons' ),
					'placeholder' => __( 'Type your text here', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_drop_cap',
				array(
					'label'        => __( 'Drop Cap', 'novixa-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'On', 'novixa-addons' ),
					'label_off'    => __( 'Off', 'novixa-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'prefix_class' => 'novixa-addons-drop-cap-',
				)
			);

			$this->add_responsive_control(
				'novixa_columns',
				array(
					'label'     => __( 'Columns', 'novixa-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '1',
					'options'   => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) => 'column-count: {{VALUE}};',
					),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab > Text Editor section — Alignment, Typography, Text
		 * Shadow, Paragraph Spacing, then Normal/Hover color tabs
		 * (Text Color + Link Color).
		 */
		protected function register_editor_style_controls() {
			$this->start_controls_section(
				'novixa_section_editor_style',
				array(
					'label' => __( 'Text Editor', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->register_alignment_control( 'novixa_alignment', '{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) );

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'novixa_text_typography',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ),
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'novixa_text_shadow',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ),
				)
			);

			$this->add_responsive_control(
				'novixa_paragraph_spacing',
				array(
					'label'      => __( 'Paragraph Spacing', 'novixa-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', '%' ),
					'range'      => array(
						'px' => array(
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) . ' > *:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'novixa_editor_color_tabs' );

			$this->start_controls_tab(
				'novixa_editor_color_normal',
				array(
					'label' => __( 'Normal', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_text_color',
				array(
					'label'     => __( 'Text Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_link_color',
				array(
					'label'     => __( 'Link Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) . ' a' => 'color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'novixa_editor_color_hover',
				array(
					'label' => __( 'Hover', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_link_hover_color',
				array(
					'label'     => __( 'Link Hover Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) . ' a:hover' => 'color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();
		}

		/**
		 * Style tab > Drop Cap section.
		 */
		protected function register_drop_cap_style_controls() {
			$this->start_controls_section(
				'novixa_section_drop_cap_style',
				array(
					'label'     => __( 'Drop Cap', 'novixa-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => array(
						'novixa_drop_cap' => 'yes',
					),
				)
			);

			$this->add_control(
				'novixa_drop_cap_color',
				array(
					'label'     => __( 'Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) . '::first-letter' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_drop_cap_bg_color',
				array(
					'label'     => __( 'Background Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'text-editor', 'content' ) . '::first-letter' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Front-end render.
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			$content = $settings['novixa_editor'];

			// TinyMCE normally wraps multi-line content in <p> tags itself,
			// but plain text saved without any block tag would otherwise be
			// a single text node — which leaves the Paragraph Spacing
			// control with nothing to apply margin between. wpautop() here
			// guarantees real <p> blocks exist so that control always works.
			if ( false === stripos( $content, '<p' ) && false === stripos( $content, '<div' ) ) {
				$content = wpautop( $content );
			}

			// TinyMCE inserts an empty "<p>&nbsp;</p>" for every blank line
			// left in the editor. Left in place, that empty paragraph still
			// takes up a full line-height of vertical space on the front
			// end even when Paragraph Spacing is set to 0 — visually
			// indistinguishable from a stray gap. Strip those out so the
			// only spacing between paragraphs is the one the Paragraph
			// Spacing control actually produces.
			$content = preg_replace( '#<p[^>]*>(?:\s|&nbsp;|<br\s*/?>)*</p>#i', '', $content );

			$this->add_render_attribute( 'novixa_editor_wrap', 'class', $this->bem( 'text-editor', 'content' ) );

			printf( '<div class="%1$s">', esc_attr( $this->bem( 'text-editor' ) ) );
			printf(
				'<div %1$s>%2$s</div>',
				$this->get_render_attribute_string( 'novixa_editor_wrap' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				wp_kses_post( $content )
			);
			echo '</div>';
		}

		/**
		 * Editor-side (JS) render template.
		 * Mirrors render()'s empty-paragraph cleanup so the live editor
		 * preview (used for style-only changes like Paragraph Spacing)
		 * never shows a gap that the front-end render already removed.
		 */
		protected function content_template() {
			?>
			<#
			var novixaAddonsContent = settings.novixa_editor;
			novixaAddonsContent = novixaAddonsContent.replace( /<p[^>]*>(?:\s|&nbsp;|<br\s*\/?>)*<\/p>/gi, '' );
			#>
			<div class="novixa-addons-text-editor">
				<div class="novixa-addons-text-editor__content">{{{ novixaAddonsContent }}}</div>
			</div>
			<?php
		}
	}
}
