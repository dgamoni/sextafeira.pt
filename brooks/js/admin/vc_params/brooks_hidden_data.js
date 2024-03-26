/**
 * Brooks Hidden Data Param for VC
 */

( function( $ ) {
    "use strict";
    var $popup = $( '#vc_ui-panel-edit-element' );

    $popup.find( '.vc_wrapper-param-type-brooks_hidden_data .brooks_hidden_data_field' ).each( function() {
        var $input = $(this),
            dataAjax = {
                action: 'brooks_set_hidden_data',
                postId: $input.data('postId')
            };

    });

} )( jQuery );
