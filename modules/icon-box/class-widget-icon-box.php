<?php
/**
 * Icon Box widget.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! class_exists( 'Novixa_Addons_Widget_Icon_Box' ) ) {

	/**
	 * Class Novixa_Addons_Widget_Icon_Box
	 */
	class Novixa_Addons_Widget_Icon_Box extends Novixa_Addons_Widget_Base {

		use Novixa_Addons_Global_Controls;

		/**
		 * Unique widget name registered with Elementor.
		 *
		 * @return string
		 */
		public function get_name() {
			return 'novixa-addons-icon-box';
		}

		/**
		 * Panel label.
		 *
		 * @return string
		 */
		public function get_title() {
			return __( 'Icon Box - Novixa', 'novixa-addons' );
		}

		/**
		 * Panel icon.
		 *
		 * @return string
		 */
		public function get_icon() {
			return 'eicon-icon-box';
		}

		/**
		 * Panel search keywords.
		 *
		 * @return array
		 */
		public function get_keywords() {
			return array_merge( $this->get_base_keywords(), array( 'icon', 'box', 'icon box', 'service' ) );
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
			$this->register_icon_style_controls();
			$this->register_title_style_controls();
			$this->register_description_style_controls();
			$this->register_spacing_controls();
		}

		/**
		 * Content tab.
		 */
		protected function register_content_controls() {
			$this->start_controls_section(
				'novixa_section_icon_box_content',
				array(
					'label' => __( 'Icon Box', 'novixa-addons' ),
				)
			);

			$this->add_control(
				'novixa_icon_type',
				array(
					'label'        => __( 'Type', 'novixa-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'icon',
					'toggle'       => false,
					'options'      => array(
						'icon'   => array(
							'title' => __( 'Icon', 'novixa-addons' ),
							'icon'  => 'eicon-star',
						),
						'number' => array(
							'title' => __( 'Number', 'novixa-addons' ),
							'icon'  => 'eicon-editor-list-ol',
						),
					),
				)
			);

			$this->add_control(
				'novixa_icon',
				array(
					'label'       => __( 'Icon', 'novixa-addons' ),
					'type'        => Controls_Manager::ICONS,
					'default'     => array(
						'value'   => 'fas fa-gem',
						'library' => 'fa-solid',
					),
					'skin'        => 'inline',
					'label_block' => false,
					'condition'   => array(
						'novixa_icon_type' => 'icon',
					),
				)
			);

			$this->add_control(
				'novixa_number',
				array(
					'label'       => __( 'Number', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '01',
					'label_block' => false,
					'condition'   => array(
						'novixa_icon_type' => 'number',
					),
				)
			);

			$this->add_control(
				'novixa_title',
				array(
					'label'       => __( 'Title', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Premium Craftsmanship', 'novixa-addons' ),
					'label_block' => true,
				)
			);

			$this->add_control(
				'novixa_description',
				array(
					'label'       => __( 'Description', 'novixa-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => __( 'A short line describing this feature or service in a clear and elegant way.', 'novixa-addons' ),
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
				'novixa_icon_position',
				array(
					'label'   => __( 'Icon Position', 'novixa-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'top',
					'options' => array(
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
					'prefix_class' => 'novixa-addons-icon-box--position-',
					'toggle'  => false,
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
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
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

			$this->start_controls_tabs( 'novixa_box_style_tabs' );

			$this->start_controls_tab(
				'novixa_box_style_normal',
				array( 'label' => __( 'Normal', 'novixa-addons' ) )
			);

			$this->add_control(
				'novixa_box_bg_color',
				array(
					'label'     => __( 'Background Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'novixa_box_style_hover',
				array( 'label' => __( 'Hover', 'novixa-addons' ) )
			);

			$this->add_control(
				'novixa_box_bg_color_hover',
				array(
					'label'     => __( 'Background Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) . ':hover' => 'background-color: {{VALUE}};',
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
					'prefix_class' => 'novixa-addons-icon-box--lift-',
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'novixa_box_border_heading',
				array(
					'label'     => __( 'Border', 'novixa-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => 'novixa_box_border',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'icon-box' ),
				)
			);

			$this->add_responsive_control(
				'novixa_box_border_radius',
				array(
					'label'      => __( 'Border Radius', 'novixa-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'novixa_box_shadow',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'icon-box' ),
				)
			);

			$this->add_responsive_control(
				'novixa_box_padding',
				array(
					'label'      => __( 'Padding', 'novixa-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'separator'  => 'before',
					'selectors'  => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Style tab > Icon styling.
		 */
		protected function register_icon_style_controls() {
			$this->start_controls_section(
				'novixa_section_icon_style',
				array(
					'label' => __( 'Icon', 'novixa-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_control(
				'novixa_icon_shape',
				array(
					'label'   => __( 'Shape', 'novixa-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'circle',
					'options' => array(
						'circle' => __( 'Circle', 'novixa-addons' ),
						'square' => __( 'Rounded Square', 'novixa-addons' ),
						'none'   => __( 'None', 'novixa-addons' ),
					),
					'prefix_class' => 'novixa-addons-icon-box__icon-shape-',
				)
			);

			$this->add_responsive_control(
				'novixa_icon_size',
				array(
					'label'     => __( 'Icon Size', 'novixa-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 10,
							'max' => 120,
						),
					),
					'default'   => array(
						'unit' => 'px',
						'size' => 26,
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'icon' ) . ' i'      => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'icon' ) . ' svg'    => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'number' )           => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'novixa_icon_spacing',
				array(
					'label'     => __( 'Spacing', 'novixa-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 80,
						),
					),
					'default'   => array(
						'unit' => 'px',
						'size' => 18,
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) => 'gap: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'novixa_icon_box_size',
				array(
					'label'     => __( 'Icon Wrapper Size', 'novixa-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 30,
							'max' => 200,
						),
					),
					'default'   => array(
						'unit' => 'px',
						'size' => 68,
					),
					'condition' => array(
						'novixa_icon_shape!' => 'none',
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'icon' ) => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'novixa_icon_color_tabs' );

			$this->start_controls_tab(
				'novixa_icon_color_normal',
				array( 'label' => __( 'Normal', 'novixa-addons' ) )
			);

			$this->add_control(
				'novixa_icon_color',
				array(
					'label'     => __( 'Icon Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#7c5cff',
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'icon' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_icon_bg_color',
				array(
					'label'     => __( 'Background Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(124,92,255,0.12)',
					'condition' => array(
						'novixa_icon_shape!' => 'none',
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'icon' ) => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'novixa_icon_color_hover',
				array( 'label' => __( 'Hover', 'novixa-addons' ) )
			);

			$this->add_control(
				'novixa_icon_color_hover',
				array(
					'label'     => __( 'Icon Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) . ':hover .' . $this->bem( 'icon-box', 'icon' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_icon_bg_color_hover',
				array(
					'label'     => __( 'Background Color', 'novixa-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'novixa_icon_shape!' => 'none',
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) . ':hover .' . $this->bem( 'icon-box', 'icon' ) => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'novixa_icon_rotate_hover',
				array(
					'label'        => __( 'Rotate on Hover', 'novixa-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'selectors'    => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box' ) . ':hover .' . $this->bem( 'icon-box', 'icon' ) => 'transform: rotate(8deg) scale(1.06);',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

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
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'title' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'novixa_title_typography',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'icon-box', 'title' ),
				)
			);

			$this->add_responsive_control(
				'novixa_title_spacing',
				array(
					'label'     => __( 'Spacing (below title)', 'novixa-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array( 'max' => 60 ),
					),
					'default'   => array(
						'unit' => 'px',
						'size' => 10,
					),
					'selectors' => array(
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'title' ) => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
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
						'{{WRAPPER}} .' . $this->bem( 'icon-box', 'description' ) => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'novixa_description_typography',
					'selector' => '{{WRAPPER}} .' . $this->bem( 'icon-box', 'description' ),
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
			$tag      = $has_link ? 'a' : 'div';

			if ( $has_link ) {
				$this->add_link_attributes( 'novixa_box_link', $settings['novixa_link'] );
			}

			$this->add_render_attribute( 'novixa_box_link', 'class', $this->bem( 'icon-box' ) );

			printf( '<%1$s %2$s>', esc_html( $tag ), $this->get_render_attribute_string( 'novixa_box_link' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			printf( '<div class="%1$s">', esc_attr( $this->bem( 'icon-box', 'icon' ) ) );
			if ( 'number' === $settings['novixa_icon_type'] ) {
				printf(
					'<span class="%1$s">%2$s</span>',
					esc_attr( $this->bem( 'icon-box', 'number' ) ),
					esc_html( $settings['novixa_number'] )
				);
			} else {
				Icons_Manager::render_icon( $settings['novixa_icon'], array( 'aria-hidden' => 'true' ) );
			}
			echo '</div>';

			echo '<div class="' . esc_attr( $this->bem( 'icon-box', 'content' ) ) . '">';

			if ( ! empty( $settings['novixa_title'] ) ) {
				printf(
					'<h3 class="%1$s">%2$s</h3>',
					esc_attr( $this->bem( 'icon-box', 'title' ) ),
					esc_html( $settings['novixa_title'] )
				);
			}

			if ( ! empty( $settings['novixa_description'] ) ) {
				printf(
					'<div class="%1$s">%2$s</div>',
					esc_attr( $this->bem( 'icon-box', 'description' ) ),
					wp_kses_post( $settings['novixa_description'] )
				);
			}

			echo '</div>';

			echo '</' . esc_html( $tag ) . '>';
		}
	}
}
