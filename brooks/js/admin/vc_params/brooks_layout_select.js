/**
 * Brooks Layout Select Param for VC
 */

( function( $ ) {
    "use strict";
    var $popup = $( '#vc_ui-panel-edit-element' );

    $popup.find( '.vc_wrapper-param-type-brooks_layout_select' ).each( function() {
        var $layout_select      = $( this ),
            $layout_items       = $layout_select.find( '.brooks-layout-item' ),
            $layout_value       = $layout_select.find( '.brooks_layout_select_field' );

        $layout_items.on( 'click', function() {
            $( this ).addClass('active').siblings().removeClass('active');

            $layout_value
                .val( $( this ).attr( 'data-value' ) )
                .trigger( 'change' );
        } );
    });

} )( jQuery );
