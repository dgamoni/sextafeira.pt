/**
 * Brooks Social Share for VC
 */

( function( $ ) {
    "use strict";
    var $popup = $( '#vc_ui-panel-edit-element' );

    $popup.find( '.vc_wrapper-param-type-brooks_social_share' ).each( function() {
        var $layout_select      = $( this ),
            $container          = $layout_select.find( '.brooks-layout-repater' ),
            $layout_items       = $layout_select.find( '.brooks-repeater-item' ),
            $layout_value       = $layout_select.find( '.brooks_social_share_field' ),
            minus               = '.brooks-layout-minus' ,
            add                 = '.brooks-layout-add',
            button              = '.button',
            $url                = $layout_select.find( '.brooks-layout-ffield' ),
            $selecter           = $layout_select.find( '.brooks-repeater-selecter' ),
            pull_network        = [],
            valObj              = $layout_value.val().length > 0  ? JSON.parse($layout_value.val()): false ;
        if(valObj) {
            for (var key in valObj) {
                if (valObj.hasOwnProperty(key)) {
                    pull_network.push(valObj[key]);
                }
            }
        }
        $selecter.each(function(){
            $(this).val($(this).data('selected'));
        })

        $container.delegate(add,'click', function(){
            var item = $($layout_items[0]).clone();
            item.find('.brooks-layout-ffield').removeClass('active').val('');
            item.appendTo($container);
        });
        
        $container.delegate(minus,'click', function(){
            pull_network.splice( $(this).closest('.brooks-repeater-item').index(), 1);
            $(this).closest('.brooks-repeater-item').remove();

            push_notify();
        });

        $container.delegate(button, 'click', function() {
            var field = $($(this).closest('.brooks-repeater-item').find('.brooks-layout-ffield')[0]);
            if (isValidURL(field.val()) ) {
                if (!field.hasClass('active')){
                    $($(this).closest('.brooks-repeater-item').find('.brooks-layout-ffield')[0]).addClass('active');

                if(!field.hasClass('changed'))
                    pull_network.push({
                        type: $($(this).closest('.brooks-repeater-item').find('select')[0]).val(),
                        network: $($(this).closest('.brooks-repeater-item').find('.brooks-layout-ffield')[0]).val()
                    });

                push_notify();
                }
            }else{

                $($(this).closest('.brooks-repeater-item').find('.brooks-layout-ffield')[0]).addClass('wrong');

            }
            

        } );
        
        $container.delegate('.brooks-layout-ffield, .brooks-repeater-selecter', 'change', function(){
            $(this).closest('.brooks-repeater-item').find('.brooks-layout-ffield').removeClass('active wrong').addClass('changed');
            pull_network.splice( $(this).closest('.brooks-repeater-item').index(), 1, {
                type: $($(this).closest('.brooks-repeater-item').find('select')[0]).val(),
                network: $($(this).closest('.brooks-repeater-item').find('.brooks-layout-ffield')[0]).val()
            });
        })

        function push_notify(){

            //convert for shortcode type to remove '[' and ']'
            var output = {};

            pull_network.map(function(el, num){
                output[num] = el;
            })

            $($layout_value.get(0))
                .attr('value', JSON.stringify(output))
                .trigger( 'change' );
        }
        
        function isValidURL(url){
            var RegExp = /(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

            if(RegExp.test(url)){
                return true;
            }else{
                return false;
            }
        }

    });

} )( jQuery );
