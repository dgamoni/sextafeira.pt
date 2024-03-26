/**
 * Brooks Offset Box Param for VC
 */

( function( $ ) {
    "use strict";
    var $popup = $( '#vc_ui-panel-edit-element' );

    $popup.find( '.brooks-offset-box-field' ).each( function() {
        var $this = $( this),
            $position_input = $this.find('.vc_padding > input'),
            $z_input        = $this.find('.z-index-position'),
            $param_value    = $this.find('.offset-box-value'),
            $disable        = $this.find('.offset-box-disable_position'),
            positionValue = $param_value.val() ? JSON.parse($param_value.val()) : {};

        $disable.attr('data-name', 'disable');

        for(var slug in positionValue) {
            $this.find('[data-name="'+slug+'"]').val(positionValue[slug]);
        }

        $position_input.on( 'blur', function() {
            var val = $(this).val();

            if(!val.match( /^-?[0-9]+((px)|(%))?$/ )) {
                val = isNaN( parseInt( val ) ) ? '' : ( parseInt( val ) + 'px' );
                $(this).val( val );
            } else if(val.match( /^-?[0-9]+$/ )) {
                val = parseInt( val ) + 'px';
                $(this).val( val );
            }

            positionValue[$(this).data('name')] = val;
            $param_value.val(JSON.stringify( positionValue ));
        } );

        $z_input.on('blur', function(){
            var val = $(this).val();

            if(!val.match( /^[0-9]+$/ )){
                val = isNaN( parseInt( val ) ) ? '' : parseInt( val );
                $(this).val( val );
            }

            positionValue[$(this).data('name')] = val;
            $param_value.val(JSON.stringify( positionValue ));
        });

        $disable.change(function(){
            var val = $(this).val();

            positionValue[$(this).data('name')] = val;
            $param_value.val(JSON.stringify( positionValue ));
        });
    });

} )( jQuery );
