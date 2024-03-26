/**
 * Brooks Layout Select Param for VC
 */

( function( $ ) {
    "use strict";
    var $popup = $( '#vc_ui-panel-edit-element' );

    $popup.find( '.brooks-range-field' ).each( function() {
        var $range_input        = $( this ).find('.input-range'),
            $text_input         = $( this ).find('.input-text');

        $range_input.on( 'change input', function() {
            $text_input.val($text_input.data('display-value').replace(/\{\{value\}\}/g, $(this).val()));
        } );
    });

} )( jQuery );
