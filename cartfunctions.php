<?php

// Add a product to cart based on the cart subtotal and remove it if the subtotal goes below that threshold
add_action( 'template_redirect', 'greyadd_to_cart' );
function greyadd_to_cart() {
  if ( ! is_admin() ) {
		global $woocommerce;
		$product_id = 2405; //replace with your product id
		$found = false;
		$cart_total = 1499; //replace with your cart total needed to add above item

		if( $woocommerce->cart->total >= $cart_total ) {
			//check if product already in cart
			if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
				foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
					$_product = $values['data'];
					if ( $_product->get_id() == $product_id )
						$found = true;
				}
				// if product not found, add it
				if ( ! $found )
					$woocommerce->cart->add_to_cart( $product_id );
			} else {
				// if no products in cart, add it
				$woocommerce->cart->add_to_cart( $product_id );
			}
		} 
		else {
				$product_cart_id = WC()->cart->generate_cart_id( $product_id );
				$cart_item_key = WC()->cart->find_product_in_cart( $product_cart_id );
				if ( $cart_item_key ) WC()->cart->remove_cart_item( $cart_item_key );
		}
	}
}
