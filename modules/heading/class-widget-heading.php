<?php
/**
 * Heading widget.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Utils;

if ( ! class_exists( 'Novixa_Addons_Widget_Heading' ) ) {

	/**
	 * Class Novixa_Addons_Widget_Heading
	 */
	class Novixa_Addons_Widget_Heading extends Novixa_Addons_Widget_Base {

		use Novixa_Addons_Global_Controls;

		/**
		 * Unique widget name registered with Elementor.
		 *
		 * @return string
		 */
		public function get_name() {
			return 'novixa-addons-heading';
		}

		/**
		 * Panel label.
		 *
		 * @return string
		 */
		public function get_title() {
			return __( 'Heading - Novixa', 'novixa-addons' );
		}

		/**
		 * Panel icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-t-letter';
		}

		/**
		 * Panel search keywords.
		 *
		 * @return array
		 */
		public function get_keywords() {
			return array_merge( $this->get_base_keywords(), array( 'heading', 'title', 'text' ) );
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
			$this->register_heading_style_controls();
			$this->register_subtitle_style_controls();
			$this->register_spacing_controls();
		}

		/**
		 * Content tab.
		 */
		protected function register_content_controls() {
			$this->start_controls_section(
				'novixa_section_heading_content',
				array(
					'label' => __( 'Heading', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_title',
				array(
					'label'       => __( 'Title', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => __( 'Add Your Heading Text Here', 'novixa-addons' ),
					'placeholder' => __( 'Type your title here', 'novixa-addons' ),
					'label_block' => true,
				)
			);

			$this->add_control(
				'novixa_sub_title',
				array(
					'label'       => __( 'Sub Title', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'placeholder' => __( 'Optional sub title', 'novixa-addons' ),
					'label_block' => true,
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
						'url'         => '',
						'is_external' => false,
						'nofollow'    => false,
					),
				)
			);

			$this->add_control(
				'novixa_html_tag',
				array(
					'label'   => __( 'HTML Tag', 'novixa-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					),
					'default' => 'h2',
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab > Heading section — mirrors Elementor's own
		 * Heading-widget style panel: Alignment, Typography, Text
		 * Stroke, Text Shadow, Blend Mode, then Normal/Hover color tabs.
		 */
		protected function register_heading_style_controls() {
			$this->start_controls_section(
				'novixa_section_heading_style',
				array(
					'label' => __( 'Heading', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->register_alignment_control( 'novixa_alignment', '{{WRAPPER}}.' . $this->bem( 'heading' ) );

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'novixa_title_typography',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'heading', 'title' ),
				)
			);

			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				array(
					'name'     => 'novixa_title_stroke',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'heading', 'title' ),
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'novixa_title_shadow',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'heading', 'title' ),
				)
			);

			$this->register_blend_mode_control( 'novixa_title_blend_mode', '{{WRAPPER}} .' . $this->bem( 'heading', 'title' ) );

			$this->start_controls_tabs( 'novixa_title_color_tabs' );

			$this->start_controls_tab(
				'novixa_title_color_normal',
				array(
					'label' => __( 'Normal', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_title_color',
				array(
					'label'     => __( 'Text Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'heading', 'title' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'novixa_title_color_hover',
				array(
					'label' => __( 'Hover', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_title_hover_color',
				array(
					'label'     => __( 'Text Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}}:hover .' . $this->bem( 'heading', 'title' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_title_hover_transition',
				array(
					'label'     => __( 'Transition Duration', 'novixa-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'max'  => 3,
							'step' => 0.1,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'heading', 'title' ) => 'transition-duration: {{SIZE}}s;',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();
		}

		/**
		 * Style tab > Sub Title section.
		 */
		protected function register_subtitle_style_controls() {
			$this->start_controls_section(
				'novixa_section_subtitle_style',
				array(
					'label'     => __( 'Sub Title', 'novixa-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => array(
						'novixa_sub_title!' => '',
					),
				)
			);

			$this->add_control(
				'novixa_sub_title_color',
				array(
					'label'     => __( 'Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'heading', 'subtitle' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'novixa_sub_title_typography',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'heading', 'subtitle' ),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Front-end render.
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			$tag = ! empty( $settings['novixa_html_tag'] ) ? $settings['novixa_html_tag'] : 'h2';

			$this->add_render_attribute( 'novixa_title_wrap', 'class', $this->bem( 'heading', 'title' ) );

			$has_link = ! empty( $settings['novixa_link']['url'] );

			if ( $has_link ) {
				$this->add_link_attributes( 'novixa_link', $settings['novixa_link'] );
			}

			printf( '<div class="%1$s">', esc_attr( $this->bem( 'heading' ) ) );

			if ( $has_link ) {
				echo '<a ' . $this->get_render_attribute_string( 'novixa_link' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			printf(
				'<%1$s %2$s>%3$s</%1$s>',
				Utils::validate_html_tag( $tag ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$this->get_render_attribute_string( 'novixa_title_wrap' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				wp_kses_post( $settings['novixa_title'] )
			);

			if ( $has_link ) {
				echo '</a>';
			}

			if ( ! empty( $settings['novixa_sub_title'] ) ) {
				printf(
					'<div class="%1$s">%2$s</div>',
					esc_attr( $this->bem( 'heading', 'subtitle' ) ),
					wp_kses_post( $settings['novixa_sub_title'] )
				);
			}

			echo '</div>';
		}

		/**
		 * Editor-side (JS) render template for a faster preview.
		 */
		protected function content_template() {
			?>
			<#
			var tag = settings.novixa_html_tag || 'h2';
			var hasLink = settings.novixa_link && settings.novixa_link.url;
			#>
			<div class="novixa-addons-heading">
				<# if ( hasLink ) { #><a href="{{ settings.novixa_link.url }}"><# } #>
				<{{{ tag }}} class="novixa-addons-heading__title">{{{ settings.novixa_title }}}</{{{ tag }}}>
				<# if ( hasLink ) { #></a><# } #>
				<# if ( settings.novixa_sub_title ) { #>
					<div class="novixa-addons-heading__subtitle">{{{ settings.novixa_sub_title }}}</div>
				<# } #>
			</div>
			<?php
		}
	}
}
