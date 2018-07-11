jQuery(document).ready(function($) {

	$('.persian-woocommerce').on( 'click', '.select_all', function() {
		jQuery( this ).closest( 'td' ).find( 'select option' ).attr( 'selected', 'selected' );
		jQuery( this ).closest( 'td' ).find( 'select' ).trigger( 'change' );
		return false;
	});

	$('.persian-woocommerce').on( 'click', '.select_none', function() {
		jQuery( this ).closest( 'td' ).find( 'select option' ).removeAttr( 'selected' );
		jQuery( this ).closest( 'td' ).find( 'select' ).trigger( 'change' );
		return false;
	});
	
	$('select#PW_Options\\[allowed_states\\]').change( function() {
		if ( jQuery( this ).val() === 'specific' ) {
			jQuery( this ).parent().parent().next( 'tr' ).show();
		} else {
			jQuery( this ).parent().parent().next( 'tr' ).hide();
		}
	}).change();
	
});