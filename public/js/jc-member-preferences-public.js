(function( $ ) {
	'use strict';

	function setPreference( nonce, value ) {

		var options = {
			message: "Setting your putter type preference"
		};


		HoldOn.open(options);

		var params = {
			action: 'jc_set_putter_type',
			putter_type: value,
			nonce: nonce
		}

		$.post( jc_member_preferences.ajaxurl, params, function( result ) {

			var status = $(result).find( 'response_data' ).text();
			var message = $(result).find( 'supplemental message' ).text();
			var $messageBox = $('.message');

			if ( status === 'success' ) {

				$messageBox.removeClass('alert').addClass('success');
				$messageBox.html( message ).slideDown();
				$('.putter-type-preference').hide();
				HoldOn.close();

			} else {

				$messageBox.html( message ).slideDown();
				HoldOn.close();
			}

		});


	}

    $(function() {

		$('.putter-type-preference').submit( function(e) {

			e.preventDefault();

			var value = $("[name='putter-type']:checked").val();
			var nonce = $("#_wpnonce").val();
			setPreference( nonce, value );

		});

    });	


})( jQuery );
