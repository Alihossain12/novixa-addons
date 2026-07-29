<?php
/**
 * Fires when the plugin is deleted from wp-admin > Plugins.
 * Only ever touches options/keys that belong to Novixa Addons.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Single site.
delete_option( 'novixa_addons_settings' );
delete_option( 'novixa_addons_activation_redirect' );
delete_option( 'novixa_addons_license_key' );
delete_option( 'novixa_addons_license_status' );
delete_option( 'novixa_addons_version' );

// Multisite: clean every blog.
if ( is_multisite() ) {
	$novixa_addons_site_ids = get_sites( array( 'fields' => 'ids' ) );

	foreach ( $novixa_addons_site_ids as $novixa_addons_site_id ) {
		switch_to_blog( $novixa_addons_site_id );

		delete_option( 'novixa_addons_settings' );
		delete_option( 'novixa_addons_activation_redirect' );
		delete_option( 'novixa_addons_license_key' );
		delete_option( 'novixa_addons_license_status' );
		delete_option( 'novixa_addons_version' );

		restore_current_blog();
	}
}
