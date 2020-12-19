<?php

/*
 * Add VAT details for Shpping cost
 */
function shipping_tax_callback( $label, $method ) {
    
    $label     = $method->get_label();
    $has_cost  = 0 < $method->cost;
    $hide_cost = ! $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), true );

    if ( $has_cost && ! $hide_cost ) {
            if ( WC()->cart->display_prices_including_tax() ) {
                    //$label .= ': ' . wc_price( $method->cost + $method->get_shipping_tax() );
                    $label .= ': ' . wc_price( $method->cost ) . ' ('. wc_price( $method->cost + $method->get_shipping_tax() ) .' incl VAT)';
                    if ( $method->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
                            $label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
                    }
            } else {
                    //$label .= ': ' . wc_price( $method->cost );
                    $label .= ': ' . wc_price( $method->cost ) . ' ('. wc_price( $method->cost + $method->get_shipping_tax() ) .' incl VAT)';
                    if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
                            $label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
                    }
            }
    }

    return $label;
    
}

add_filter( 'woocommerce_cart_shipping_method_full_label', 'shipping_tax_callback', 10, 2 );

?>
