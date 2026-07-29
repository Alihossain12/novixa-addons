<?php
/**
 * Image Box widget.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

if ( ! class_exists( 'Novixa_Addons_Widget_Image_Box' ) ) {

	/**
	 * Class Novixa_Addons_Widget_Image_Box
	 */
	class Novixa_Addons_Widget_Image_Box extends Novixa_Addons_Widget_Base {

		use Novixa_Addons_Global_Controls;

		/**
		 * Unique widget name registered with Elementor.
		 *
		 * @return string
		 */
		public function get_name() {
			return 'novixa-addons-image-box';
		}

		/**
		 * Panel label.
		 *
		 * @return string
		 */
		public function get_title() {
			return __( 'Image Box - Novixa', 'novixa-addons' );
		}

		/**
		 * Panel icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-image-box';
		}

		/**
		 * Panel search keywords.
		 *
		 * @return array
		 */
		public function get_keywords() {
			return array_merge( $this->get_base_keywords(), array( 'image', 'box', 'image box', 'photo' ) );
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
			$this->register_box_style_controls();
			$this->register_image_style_controls();
			$this->register_title_style_controls();
			$this->register_description_style_controls();
			$this->register_spacing_controls();
		}

		/**
		 * Content tab.
		 */
		protected function register_content_controls() {
			$this->start_controls_section(
				'novixa_section_image_box_content',
				array(
					'label' => __( 'Image Box', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_image',
				array(
					'label'   => __( 'Choose Image', 'novixa-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'default' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'    => 'novixa_image_size',
					'default' => 'medium',
				)
			);

			$this->add_control(
				'novixa_title',
				array(
					'label'       => __( 'Title', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Elegant Interior Design', 'novixa-addons' ),
					'label_block' => true,
				)
			);

			$this->add_control(
				'novixa_description',
				array(
					'label'       => __( 'Description', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => __( 'A short line describing this image, project or service.', 'novixa-addons' ),
					'label_block' => true,
					'rows'        => 4,
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

			$this->add_control(
				'novixa_image_position',
				array(
					'label'        => __( 'Image Position', 'novixa-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'top',
					'options'      => array(
						'top'   => array(
							'title' => __( 'Top', 'novixa-addons' ),
							'icon'  => 'eicon-v-align-top',
						),
						'left'  => array(
							'title' => __( 'Left', 'novixa-addons' ),
							'icon'  => 'eicon-h-align-left',
						),
						'right' => array(
							'title' => __( 'Right', 'novixa-addons' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
					'prefix_class' => 'novixa-addons-image-box--position-',
					'toggle'       => false,
				)
			);

			$this->add_responsive_control(
				'novixa_content_alignment',
				array(
					'label'     => __( 'Alignment', 'novixa-addons' ),
					'type'      => Controls_Manager::CHOOSE,
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
						'{{WRAPPER}} .' . $this->bem( 'image-box' ) => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab > Box (card) styling.
		 */
		protected function register_box_style_controls() {
			$this->start_controls_section(
				'novixa_section_box_style',
				array(
					'label' => __( 'Box', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_control(
				'novixa_box_bg_color',
				array(
					'label'     => __( 'Background Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'image-box' ) => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_box_hover_lift',
				array(
					'label'        => __( 'Hover Lift Effect', 'novixa-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'On', 'novixa-addons' ),
					'label_off'    => __( 'Off', 'novixa-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'prefix_class' => 'novixa-addons-image-box--lift-',
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => 'novixa_box_border',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'image-box' ),
				)
			);

			$this->add_responsive_control(
				'novixa_box_border_radius',
				array(
					'label'      => __( 'Border Radius', 'novixa-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .' . $this->bem( 'image-box' )           => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
						'{{WRAPPER}} .' . $this->bem( 'image-box', 'media' ) . ' img' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'novixa_box_shadow',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'image-box' ),
				)
			);

			$this->add_responsive_control(
				'novixa_box_padding',
				array(
					'label'      => __( 'Content Padding', 'novixa-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'separator'  => 'before',
					'selectors'  => array(
						'{{WRAPPER}} .' . $this->bem( 'image-box', 'content' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab > Image styling.
		 */
		protected function register_image_style_controls() {
			$this->start_controls_section(
				'novixa_section_image_style',
				array(
					'label' => __( 'Image', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_responsive_control(
				'novixa_image_width',
				array(
					'label'      => __( 'Width', 'novixa-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'%' => array(
							'min' => 10,
							'max' => 100,
						),
					),
					'default'    => array(
						'unit' => '%',
						'size' => 100,
					),
					'selectors'  => array(
						'{{WRAPPER}} .' . $this->bem( 'image-box', 'media' ) . ' img' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'novixa_image_hover_effect',
				array(
					'label'   => __( 'Hover Effect', 'novixa-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'zoom',
					'options' => array(
						'none'      => __( 'None', 'novixa-addons' ),
						'zoom'      => __( 'Zoom In', 'novixa-addons' ),
						'grayscale' => __( 'Grayscale to Color', 'novixa-addons' ),
					),
					'prefix_class' => 'novixa-addons-image-box__hover-',
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab > Title styling.
		 */
		protected function register_title_style_controls() {
			$this->start_controls_section(
				'novixa_section_title_style',
				array(
					'label' => __( 'Title', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_control(
				'novixa_title_color',
				array(
					'label'     => __( 'Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'image-box', 'title' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'novixa_title_typography',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'image-box', 'title' ),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab > Description styling.
		 */
		protected function register_description_style_controls() {
			$this->start_controls_section(
				'novixa_section_description_style',
				array(
					'label' => __( 'Description', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_control(
				'novixa_description_color',
				array(
					'label'     => __( 'Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'image-box', 'description' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'novixa_description_typography',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'image-box', 'description' ),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Front-end render.
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			$has_link = ! empty( $settings['novixa_link']['url'] );

			if ( $has_link ) {
				$this->add_link_attributes( 'novixa_box_link', $settings['novixa_link'] );
			}

			printf( '<div class="%1$s">', esc_attr( $this->bem( 'image-box' ) ) );

			if ( $has_link ) {
				echo '<a ' . $this->get_render_attribute_string( 'novixa_box_link' ) . ' class="' . esc_attr( $this->bem( 'image-box', 'media' ) ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				echo '<div class="' . esc_attr( $this->bem( 'image-box', 'media' ) ) . '">';
			}

			echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'novixa_image_size', 'novixa_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			echo $has_link ? '</a>' : '</div>';

			echo '<div class="' . esc_attr( $this->bem( 'image-box', 'content' ) ) . '">';

			if ( ! empty( $settings['novixa_title'] ) ) {
				printf(
					'<h3 class="%1$s">%2$s</h3>',
					esc_attr( $this->bem( 'image-box', 'title' ) ),
					esc_html( $settings['novixa_title'] )
				);
			}

			if ( ! empty( $settings['novixa_description'] ) ) {
				printf(
					'<div class="%1$s">%2$s</div>',
					esc_attr( $this->bem( 'image-box', 'description' ) ),
					wp_kses_post( $settings['novixa_description'] )
				);
			}

			echo '</div>';

			echo '</div>';
		}
	}
}
