jQuery( document ).ready( function() {

	// Reload the cart
	if ( woosmcVars.reload == 'yes' ) {
		woosmc_get_cart();
	}

	// Perfect scrollbar
	woosmc_perfect_scrollbar();

	// Qty minus
	jQuery( 'body' ).on( 'click', '#woosmc-area .woosmc-item-qty-minus', function() {
		var qtyMin = 1;
		var step = 1;
		var qtyInput = jQuery( this ).parent().find( 'input.qty' );
		var qty = Number( qtyInput.val() );
		if ( (
			     qtyInput.attr( 'min' ) != ''
		     ) && (
			     qtyInput.attr( 'min' ) != null
		     ) ) {
			qtyMin = Number( qtyInput.attr( 'min' ) );
		}
		if ( qtyInput.attr( 'step' ) != '' ) {
			step = Number( qtyInput.attr( 'step' ) );
		}
		var qtyStep = qtyMin + step;
		if ( qty >= qtyStep ) {
			qtyInput.val( qty - step );
		}
		qtyInput.trigger( 'change' );
	} );

	// Qty plus
	jQuery( 'body' ).on( 'click', '#woosmc-area .woosmc-item-qty-plus', function() {
		var qtyMax = 1000;
		var step = 1;
		var qtyInput = jQuery( this ).parent().find( 'input.qty' );
		var qty = Number( qtyInput.val() );
		if ( (
			     qtyInput.attr( 'max' ) != ''
		     ) && (
			     qtyInput.attr( 'max' ) != null
		     ) ) {
			qtyMax = Number( qtyInput.attr( 'max' ) );
		}
		if ( qtyInput.attr( 'step' ) != '' ) {
			step = Number( qtyInput.attr( 'step' ) );
		}
		var qtyStep = qty + step;
		if ( qtyMax >= qtyStep ) {
			qtyInput.val( qtyStep );
		}
		qtyInput.trigger( 'change' );
	} );

	// Qty on change
	jQuery( 'body' ).on( 'change', '#woosmc-area input.qty', function() {
		var item_key = jQuery( this ).attr( 'name' );
		var item_qty = jQuery( this ).val();
		woosmc_update_qty( item_key, item_qty );
	} );

	// Qty validate
	var t = false;
	jQuery( 'body' ).on( 'focus', '#woosmc-area input.qty', function() {
		var thisQty = jQuery( this );
		var thisQtyMin = thisQty.attr( 'min' );
		var thisQtyMax = thisQty.attr( 'max' );
		if ( (
			     thisQtyMin == null
		     ) || (
			     thisQtyMin == ''
		     ) ) {
			thisQtyMin = 1;
		}
		if ( (
			     thisQtyMax == null
		     ) || (
			     thisQtyMax == ''
		     ) ) {
			thisQtyMax = 1000;
		}
		t = setInterval(
			function() {
				if ( (
					     thisQty.val() < thisQtyMin
				     ) || (
					     thisQty.val().length == 0
				     ) ) {
					thisQty.val( thisQtyMin )
				}
				if ( thisQty.val() > thisQtyMax ) {
					thisQty.val( thisQtyMax )
				}
			}, 50 )
	} );

	jQuery( 'body' ).on( 'blur', '#woosmc-area input.qty', function() {
		if ( t != false ) {
			window.clearInterval( t )
			t = false;
		}
		var item_key = jQuery( this ).attr( 'name' );
		var item_qty = jQuery( this ).val();
		woosmc_update_qty( item_key, item_qty );
	} );

	// Remove item
	jQuery( 'body' ).on( 'click', '#woosmc-area .woosmc-item-remove', function() {
		jQuery( this ).closest( '.woosmc-item' ).addClass( 'woosmc-item-removing' );
		var item_key = jQuery( this ).attr( 'data-key' );
		woosmc_remove_item( item_key );
		jQuery( this ).closest( '.woosmc-item' ).slideUp();
	} );

	jQuery( 'body' ).on( 'click tap', '.woosmc-overlay', function() {
		woosmc_hide_cart();
	} );

	jQuery( 'body' ).on( 'click tap', '.woosmc-close', function() {
		woosmc_hide_cart();
	} );

	jQuery( 'body' ).on( 'click tap', '#woosmc-continue', function() {
		woosmc_hide_cart();
	} );

	// Count button
	jQuery( 'body' ).on( 'click', '#woosmc-count', function() {
		woosmc_show_cart();
	} );

	// Auto show
	if ( woosmcVars.auto_show == 'yes' ) {
		jQuery( 'body' ).on( 'added_to_cart', function() {
			woosmc_get_cart();
			woosmc_show_cart();
		} );
	} else {
		jQuery( 'body' ).on( 'added_to_cart', function() {
			woosmc_get_cart();
		} );
	}

	// Manual show
	if ( woosmcVars.manual_show != '' ) {
		jQuery( 'body' ).on( 'click', woosmcVars.manual_show, function() {
			woosmc_show_cart();
		} );
	}
} );

function woosmc_update_qty( cart_item_key, cart_item_qty ) {
	jQuery( '#woosmc-count' ).addClass( 'woosmc-count-loading' ).removeClass( 'woosmc-count-shake' );
	var data = {
		action: 'woosmc_update_qty',
		cart_item_key: cart_item_key,
		cart_item_qty: cart_item_qty,
		nonce: jQuery( '#woosmc-nonce' ).val(),
		security: woosmcVars.nonce
	};
	jQuery.post( woosmcVars.ajaxurl, data, function( response ) {
		var cart_response = JSON.parse( response );
		jQuery( '#woosmc-subtotal' ).html( cart_response['subtotal'] );
		jQuery( '#woosmc-count-number' ).html( cart_response['count'] );
		jQuery( '#woosmc-count' ).addClass( 'woosmc-count-shake' ).removeClass( 'woosmc-count-loading' );
		if ( (
			     woosmcVars.hide_count_empty == 'yes'
		     ) && (
			     cart_response['count'] == 0
		     ) ) {
			jQuery( '#woosmc-count' ).addClass( 'woosmc-count-hide' );
		} else {
			jQuery( '#woosmc-count' ).removeClass( 'woosmc-count-hide' );
		}
	} );
}

function woosmc_remove_item( cart_item_key ) {
	jQuery( '#woosmc-count' ).addClass( 'woosmc-count-loading' ).removeClass( 'woosmc-count-shake' );
	var data = {
		action: 'woosmc_remove_item',
		cart_item_key: cart_item_key,
		nonce: jQuery( '#woosmc-nonce' ).val(),
		security: woosmcVars.nonce
	};
	jQuery.post( woosmcVars.ajaxurl, data, function( response ) {
		var cart_response = JSON.parse( response );
		jQuery( '#woosmc-subtotal' ).html( cart_response['subtotal'] );
		jQuery( '#woosmc-count-number' ).html( cart_response['count'] );
		jQuery( '#woosmc-count' ).addClass( 'woosmc-count-shake' ).removeClass( 'woosmc-count-loading' );
		if ( (
			     woosmcVars.hide_count_empty == 'yes'
		     ) && (
			     cart_response['count'] == 0
		     ) ) {
			jQuery( '#woosmc-count' ).addClass( 'woosmc-count-hide' );
		} else {
			jQuery( '#woosmc-count' ).removeClass( 'woosmc-count-hide' );
		}
	} );
}

function woosmc_get_cart() {
	jQuery( '#woosmc-area' ).addClass( 'woosmc-area-loading' );
	jQuery( '#woosmc-count' ).addClass( 'woosmc-count-loading' ).removeClass( 'woosmc-count-shake' );
	var data = {
		action: 'woosmc_get_cart',
		nonce: jQuery( '#woosmc-nonce' ).val(),
		security: woosmcVars.nonce
	};
	jQuery.post( woosmcVars.ajaxurl, data, function( response ) {
		var cart_response = JSON.parse( response );
		jQuery( '#woosmc-area' ).html( cart_response['html'] );
		woosmc_perfect_scrollbar();
		jQuery( '#woosmc-count-number' ).html( cart_response['count'] );
		jQuery( '#woosmc-area' ).removeClass( 'woosmc-area-loading' );
		jQuery( '#woosmc-count' ).addClass( 'woosmc-count-shake' ).removeClass( 'woosmc-count-loading' );
		if ( (
			     (
				     woosmcVars.hide_count_empty == 'yes'
			     ) && (
				     cart_response['count'] == 0
			     )
		     ) || (
			     (
				     woosmcVars.hide_count_checkout == 'yes'
			     ) && (
				     jQuery( 'body' ).hasClass( 'woocommerce-cart' ) || jQuery( 'body' ).hasClass( 'woocommerce-checkout' )
			     )
		     ) ) {
			jQuery( '#woosmc-count' ).addClass( 'woosmc-count-hide' );
		} else {
			jQuery( '#woosmc-count' ).removeClass( 'woosmc-count-hide' );
		}
	} );
}

function woosmc_perfect_scrollbar() {
	jQuery( '#woosmc-area .woosmc-area-mid' ).perfectScrollbar( {suppressScrollX: true, theme: 'woosmc'} );
}

function woosmc_show_cart() {
	jQuery( 'body' ).addClass( 'woosmc-body-show' );
	jQuery( '#woosmc-area' ).addClass( 'woosmc-area-show' );
}

function woosmc_hide_cart() {
	jQuery( '#woosmc-area' ).removeClass( 'woosmc-area-show' );
	jQuery( 'body' ).removeClass( 'woosmc-body-show' );
}