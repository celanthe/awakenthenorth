/* jshint devel: true */
/* global BP_Confirm */

jQuery( function() {
	jQuery( '#buddypress' ).on( 'click', 'a.confirm', function() {
		if ( confirm( BP_Confirm.are_you_sure ) ) {
			return true;
		} else {
			return false;
		}
	} );
} );
