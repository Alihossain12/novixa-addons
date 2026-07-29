<?php
/**
 * Reusable groups of Elementor controls shared by more than one widget.
 * Keeping these as a trait (rather than copy/pasting) means every
 * module stays visually + behaviourally consistent.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'Novixa_Addons_Global_Controls' ) ) {

	/**
	 * Trait Novixa_Addons_Global_Controls
	 */
	trait Novixa_Addons_Global_Controls {

		/**
		 * Standard responsive text-alignment CHOOSE control, reused
		 * identically across every text-based widget's Style tab.
		 *
		 * @param string $id        Control id.
		 * @param string $selector  CSS selector the alignment applies to.
		 */
		protected function register_alignment_control( $id, $selector ) {
			$this->add_responsive_control(
				$id,
				array(
					'label'     => __( 'Alignment', 'novixa-addons' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => __( 'Left', 'novixa-addons' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => __( 'Center', 'novixa-addons' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => __( 'Right', 'novixa-addons' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => __( 'Justified', 'novixa-addons' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						$selector => 'text-align: {{VALUE}};',
					),
				)
			);
		}

		/**
		 * Standard Blend Mode select, reused across widget style panels.
		 *
		 * @param string $id       Control id.
		 * @param string $selector CSS selector the blend mode applies to.
		 */
		protected function register_blend_mode_control( $id, $selector ) {
			$this->add_control(
				$id,
				array(
					'label'     => __( 'Blend Mode', 'novixa-addons' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => array(
						''            => __( 'Normal', 'novixa-addons' ),
						'multiply'    => 'Multiply',
						'screen'      => 'Screen',
						'overlay'     => 'Overlay',
						'darken'      => 'Darken',
						'lighten'     => 'Lighten',
						'color-dodge' => 'Color Dodge',
						'saturation'  => 'Saturation',
						'color'       => 'Color',
						'difference'  => 'Difference',
						'exclusion'   => 'Exclusion',
						'hue'         => 'Hue',
						'luminosity'  => 'Luminosity',
					),
					'selectors' => array(
						$selector => 'mix-blend-mode: {{VALUE}};',
					),
					'separator' => 'before',
				)
			);
		}

		/**
		 * Standard "Advanced > Spacing" style section, reused by any
		 * widget that opts in via `register_spacing_controls()`.
		 */
		protected function register_spacing_controls() {
			$this->start_controls_section(
				'novixa_section_spacing',
				array(
					'label' => __( 'Spacing', 'novixa-addons' ),
					'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
				)
			);

			$this->add_responsive_control(
				'novixa_margin',
				array(
					'label'      => __( 'Margin', 'novixa-addons' ),
					'type'       => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_section();
		}
	}
}
