<?php
/**
 * General settings screen.
 *
 * @var array $settings Current merged settings.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
			<div class="novixa-addons-panel">
				<h2><?php esc_html_e( 'Settings', 'novixa-addons' ); ?></h2>

				<form id="novixa-addons-settings-form" class="novixa-addons-form">

					<div class="novixa-addons-form__row">
						<div class="novixa-addons-form__label">
							<label for="novixa_load_font_awesome"><?php esc_html_e( 'Load Font Awesome', 'novixa-addons' ); ?></label>
							<p><?php esc_html_e( 'Enable only if your theme does not already load Font Awesome.', 'novixa-addons' ); ?></p>
						</div>
						<label class="novixa-addons-switch">
							<input
								type="checkbox"
								id="novixa_load_font_awesome"
								name="novixa_load_font_awesome"
								<?php checked( ! empty( $settings['novixa_load_font_awesome'] ), true ); ?>
							/>
							<span class="novixa-addons-switch__slider"></span>
						</label>
					</div>

					<div class="novixa-addons-form__row">
						<div class="novixa-addons-form__label">
							<label for="novixa_disable_editor_notice"><?php esc_html_e( 'Hide "Getting Started" tips in editor', 'novixa-addons' ); ?></label>
							<p><?php esc_html_e( 'Removes the on-boarding hints from the Elementor editor panel.', 'novixa-addons' ); ?></p>
						</div>
						<label class="novixa-addons-switch">
							<input
								type="checkbox"
								id="novixa_disable_editor_notice"
								name="novixa_disable_editor_notice"
								<?php checked( ! empty( $settings['novixa_disable_editor_notice'] ), true ); ?>
							/>
							<span class="novixa-addons-switch__slider"></span>
						</label>
					</div>

					<div class="novixa-addons-form__actions">
						<button type="submit" class="novixa-addons-button novixa-addons-button--primary">
							<?php esc_html_e( 'Save Settings', 'novixa-addons' ); ?>
						</button>
					</div>

				</form>
			</div>

		</main>
	</div>
</div>
