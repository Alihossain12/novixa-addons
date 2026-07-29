<?php
/**
 * Elements screen — grid of widgets with on/off toggle switches.
 *
 * @var array $registry Widget registry from novixa_addons_widgets_registry().
 * @var array $stats    {enabled:int,total:int}
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
			<div class="novixa-addons-panel">
				<div class="novixa-addons-panel__head">
					<div>
						<h2><?php esc_html_e( 'Elements', 'novixa-addons' ); ?></h2>
						<p class="novixa-addons-panel__desc">
							<?php esc_html_e( 'Toggle the widgets you need. Disabled widgets are not loaded on the front-end, keeping your site fast.', 'novixa-addons' ); ?>
						</p>
					</div>
					<span class="novixa-addons-pill">
						<?php
						printf(
							/* translators: 1: enabled count 2: total count */
							esc_html__( '%1$s of %2$s enabled', 'novixa-addons' ),
							esc_html( $stats['enabled'] ),
							esc_html( $stats['total'] )
						);
						?>
					</span>
				</div>

				<div class="novixa-addons-grid">
					<?php foreach ( $registry as $novixa_addons_slug => $novixa_addons_widget ) : ?>
						<div class="novixa-addons-widget-card" data-slug="<?php echo esc_attr( $novixa_addons_slug ); ?>">
							<div class="novixa-addons-widget-card__icon">
								<span class="<?php echo esc_attr( $novixa_addons_widget['icon'] ); ?>"></span>
							</div>
							<div class="novixa-addons-widget-card__body">
								<h4><?php echo esc_html( $novixa_addons_widget['label'] ); ?></h4>
								<p><?php echo esc_html( $novixa_addons_widget['description'] ); ?></p>
							</div>
							<div class="novixa-addons-widget-card__toggle">
								<label class="novixa-addons-switch">
									<input
										type="checkbox"
										class="novixa-addons-widget-toggle"
										data-slug="<?php echo esc_attr( $novixa_addons_slug ); ?>"
										<?php checked( novixa_addons_is_widget_enabled( $novixa_addons_slug ), true ); ?>
									/>
									<span class="novixa-addons-switch__slider"></span>
								</label>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

		</main>
	</div>
</div>
