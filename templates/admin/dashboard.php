<?php
/**
 * Dashboard overview screen.
 *
 * @var array $stats {enabled:int,total:int}
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$novixa_addons_percent = $stats['total'] ? round( ( $stats['enabled'] / $stats['total'] ) * 100 ) : 0;
?>
			<div class="novixa-addons-hero">
				<div class="novixa-addons-hero__text">
					<h2 id="novixa-addons-hero-title" class="novixa-addons-hero__title"><?php esc_html_e( 'Welcome back 👋', 'novixa-addons' ); ?></h2>
					<p><?php esc_html_e( 'Manage your Elementor widgets, monitor status and fine-tune settings — all from one clean dashboard.', 'novixa-addons' ); ?></p>
					<a class="novixa-addons-button novixa-addons-button--primary" href="<?php echo esc_url( admin_url( 'admin.php?page=novixa-addons-elements' ) ); ?>">
						<?php esc_html_e( 'Manage Elements', 'novixa-addons' ); ?>
					</a>
				</div>
				<div class="novixa-addons-hero__ring" style="--novixa-percent: <?php echo esc_attr( $novixa_addons_percent ); ?>;">
					<span class="novixa-addons-hero__ring-value"><?php echo esc_html( $novixa_addons_percent ); ?>%</span>
					<span class="novixa-addons-hero__ring-label"><?php esc_html_e( 'Elements Active', 'novixa-addons' ); ?></span>
				</div>
			</div>

			<div class="novixa-addons-cards">

				<div class="novixa-addons-card">
					<div class="novixa-addons-card__icon novixa-addons-card__icon--violet">
						<span class="dashicons dashicons-layout"></span>
					</div>
					<div class="novixa-addons-card__content">
						<h3><?php esc_html_e( 'Active Elements', 'novixa-addons' ); ?></h3>
						<p class="novixa-addons-card__stat"><?php echo esc_html( $stats['enabled'] ); ?> / <?php echo esc_html( $stats['total'] ); ?></p>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=novixa-addons-elements' ) ); ?>">
							<?php esc_html_e( 'Manage Elements', 'novixa-addons' ); ?> &rarr;
						</a>
					</div>
				</div>

				<div class="novixa-addons-card">
					<div class="novixa-addons-card__icon novixa-addons-card__icon--gold">
						<span class="dashicons dashicons-admin-appearance"></span>
					</div>
					<div class="novixa-addons-card__content">
						<h3><?php esc_html_e( 'Elementor Status', 'novixa-addons' ); ?></h3>
						<p class="novixa-addons-card__stat">
							<?php
							echo Novixa_Addons_Helper::is_elementor_active()
								? esc_html__( 'Connected', 'novixa-addons' )
								: esc_html__( 'Not Active', 'novixa-addons' );
							?>
						</p>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">
							<?php esc_html_e( 'Edit a Page', 'novixa-addons' ); ?> &rarr;
						</a>
					</div>
				</div>

				<div class="novixa-addons-card">
					<div class="novixa-addons-card__icon novixa-addons-card__icon--emerald">
						<span class="dashicons dashicons-star-filled"></span>
					</div>
					<div class="novixa-addons-card__content">
						<h3><?php esc_html_e( 'License', 'novixa-addons' ); ?></h3>
						<p class="novixa-addons-card__stat"><?php echo esc_html( Novixa_Addons_License::status_label() ); ?></p>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=novixa-addons-settings' ) ); ?>">
							<?php esc_html_e( 'View Settings', 'novixa-addons' ); ?> &rarr;
						</a>
					</div>
				</div>

			</div>

			<div class="novixa-addons-panel">
				<h2><?php esc_html_e( 'Getting Started', 'novixa-addons' ); ?></h2>
				<ol class="novixa-addons-steps">
					<li><?php esc_html_e( 'Go to the Elements tab and enable the widgets you want to use.', 'novixa-addons' ); ?></li>
					<li><?php esc_html_e( 'Open any page with Elementor — your enabled widgets appear under the "Novixa Addons" category.', 'novixa-addons' ); ?></li>
					<li><?php esc_html_e( 'Drag a widget onto the canvas and start customizing.', 'novixa-addons' ); ?></li>
				</ol>
			</div>

		</main>
	</div>
</div>
