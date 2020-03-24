jQuery( function( $ ) {
	var $allowEmbed = $( 'input[name=allow_embed]' ),
		$allowNonSSL = $( 'input[name=allow_non_ssl_embed]' );

	$allowEmbed.on( 'click', function() {
		var $field = $allowNonSSL.closest( '.form-group' );
		this.checked ? $field.show() : $field.hide();
	} );
	$allowEmbed.triggerHandler( 'click' );
} );
