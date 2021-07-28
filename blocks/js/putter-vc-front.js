/**
 * Generic JS for viewing and managing async reports.
 *
 * @author Roger Coathup.
 */
 (function( $ ) {
	'use strict';

	/**
	 * 
	 * @param {*} nonce 
	 * @param {*} data 
	 */
	function generateReport( baseAction, $reports ) {

		var options = {
			message: "Starting the report"
		};

		HoldOn.open(options);

		var params = {
			action: baseAction + '_trigger',
		}

		$.post( jc_async_reports.ajaxurl, params, function( result ) {

			var status = $(result).find( 'response_data' ).text();

			if ( status === 'started' ) {

				var template = $(result).find( 'supplemental template' ).text();
				$reports.prepend( template );
				HoldOn.close();

			} else {

				var message = $(result).find( 'supplemental message' ).text();
				$reports.find('.notice').show().html( message );
				HoldOn.close();
			}

		});
	}

	function redeemCovers( action, $reports ) {

		var options = {
			message: "Starting the redemptions"
		};

		HoldOn.open(options);

		var params = {
			action: action + '_trigger',
		}

		$.post( jc_async_reports.ajaxurl, params, function( result ) {

			var status = $(result).find( 'response_data' ).text();

			if ( status === 'started' ) {

				var template = $(result).find( 'supplemental template' ).text();
				$reports.prepend( template );
				HoldOn.close();

			} else {

				var message = $(result).find( 'supplemental message' ).text();
				$reports.find('.notice').show().html( message );
				HoldOn.close();
			}

		});
	}

    /**
     * document ready handling
     */
    $(function() {

		var baseAction = 'jc_putter_cover_report';
		var $reports = $('.async-report-vc .reports');

		$('#generate-report').click( function(e) {

			e.preventDefault();
			generateReport( baseAction, $reports );

		});

		var redemptionAction = 'jc_putter_cover_redemption';
		$('#redeem-covers').click( function(e) {

			e.preventDefault();
			redeemCovers( redemptionAction, $reports );

		});

    });
})( jQuery );