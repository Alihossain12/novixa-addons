/**
 * Novixa Addons — Admin Dashboard behaviour.
 * Wrapped in an IIFE so nothing here can collide with another
 * plugin's admin.js loaded on the same wp-admin screen.
 */
( function ( $ ) {
	'use strict';

	var NovixaAddonsDashboard = {

		init: function () {
			this.bindWidgetToggles();
			this.bindSettingsForm();
		},

		showNotice: function ( message, isError ) {
			var $notice = $( '#novixa-addons-notice' );

			if ( ! $notice.length ) {
				return;
			}

			$notice
				.text( message )
				.toggleClass( 'is-error', !! isError )
				.prop( 'hidden', false );

			window.clearTimeout( NovixaAddonsDashboard._noticeTimer );
			NovixaAddonsDashboard._noticeTimer = window.setTimeout( function () {
				$notice.prop( 'hidden', true );
			}, 2500 );
		},

		bindWidgetToggles: function () {
			$( document ).on( 'change', '.novixa-addons-widget-toggle', function () {
				var $checkbox = $( this );
				var slug = $checkbox.data( 'slug' );
				var enabled = $checkbox.is( ':checked' );

				$.post( NovixaAddonsAdmin.ajaxUrl, {
					action: 'novixa_addons_toggle_widget',
					nonce: NovixaAddonsAdmin.nonce,
					slug: slug,
					enabled: enabled
				} ).done( function ( response ) {
					if ( response && response.success ) {
						NovixaAddonsDashboard.showNotice( NovixaAddonsAdmin.i18n.saved, false );
					} else {
						$checkbox.prop( 'checked', ! enabled );
						NovixaAddonsDashboard.showNotice( NovixaAddonsAdmin.i18n.error, true );
					}
				} ).fail( function () {
					$checkbox.prop( 'checked', ! enabled );
					NovixaAddonsDashboard.showNotice( NovixaAddonsAdmin.i18n.error, true );
				} );
			} );
		},

		bindSettingsForm: function () {
			$( document ).on( 'submit', '#novixa-addons-settings-form', function ( e ) {
				e.preventDefault();

				var settings = {};

				$( this ).find( 'input[type="checkbox"]' ).each( function () {
					settings[ this.name ] = this.checked;
				} );

				$.post( NovixaAddonsAdmin.ajaxUrl, {
					action: 'novixa_addons_save_settings',
					nonce: NovixaAddonsAdmin.nonce,
					settings: settings
				} ).done( function ( response ) {
					var ok = response && response.success;
					NovixaAddonsDashboard.showNotice(
						ok ? NovixaAddonsAdmin.i18n.saved : NovixaAddonsAdmin.i18n.error,
						! ok
					);
				} ).fail( function () {
					NovixaAddonsDashboard.showNotice( NovixaAddonsAdmin.i18n.error, true );
				} );
			} );
		}
	};

	$( function () {
		NovixaAddonsDashboard.init();
	} );

} )( jQuery );
