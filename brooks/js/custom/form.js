(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.Form = function() {
        var _self = this,
            parentClass = '.wpcf7-form-control-wrap';

        $('input, textarea, select').each(function(){
            var $this = $(this),
                id = $this.attr('id'),
                placeholder = $this.attr('placeholder');

            if(! $this.hasClass('has-placeholder'))
                $this.removeAttr('placeholder').parents(parentClass).addClass('input-field');



            if(!id) {
                id = 'brooks-input-' + BrooksTheme.Global.getUniqueId();
                $this.attr('id', id);
            }

            if($this.attr('type') == 'text' || $this.attr('type') == 'email' || $this.attr('type') == 'tel' || $this.attr('type') == 'url' || $this.attr('type') == 'number' || $this.attr('type') == 'password') {

                _self.setLabel($this, id, placeholder);

            } else if( $this.prop("tagName") == 'TEXTAREA' ) {
                $this.addClass('materialize-textarea');

                _self.setLabel($this, id, placeholder);
            } else if( $this.prop("tagName") == 'SELECT' ) {
                $this.material_select();
            } else if($this.attr('type') == 'checkbox' || $this.attr('type') == 'radio') {
                placeholder = $this.val();

                if($this.parents('.filled-in').length)
                    $this.addClass('filled-in');

                $this.parent().find('span').remove();
                _self.setLabel($this, id, placeholder);
            } else if($this.attr('type') == 'range') {
                $this.parents(parentClass).addClass('range-field');
            } else if($this.attr('type') == 'date') {
                _self.setLabel($this, id, placeholder);

                $this.addClass('datepicker').pickadate({
                    selectMonths: true,
                    format: 'dd.mm.yyyy'
                });

            } else if($this.attr('type') == 'submit') {
                var $loader = $('<div class="progress ajax-loader hidden"><div class="indeterminate"></div></div>');

                $this.addClass('btn waves-effect').after($loader);
                //$this.parents('form').ajaxStart(function(){
                //    $loader.removeClass('hidden');
                //}).ajaxComplete(function(){
                //    $loader.addClass('hidden');
                //});
            } else if($this.attr('type') == 'file') {
                var $label = $('label[for='+id+']'),
                    buttonText = $label.text();

                if(!$label.length || !buttonText)
                    return;

                $label.remove();
                $this.removeAttr('placeholder').parents(parentClass).addClass('file-field');
                $this.wrap('<button class="btn btn-color">').before('<span>'+buttonText+'</span>');

                $this.parent().after('<div class="file-path-wrapper"><input class="file-path validate" type="text"></div>')

            }
        });

    }

    BrooksTheme.Form.prototype.setLabel = function($elem, id, placeholder) {
        if($elem.hasClass('theme__form__box__style'))
            return;

        if(!$elem.parent().find('label').length)
            $elem.after('<label for="'+id+'">'+(placeholder?placeholder:'')+'</label>');
        else {
            
            var label = $elem.parent().find('label').detach();
            $elem.after(label);
            $elem.parent().find('label').attr('for', id);
          
            if( $elem.parent().find('label').hasClass('active') && $elem.attr('value') == "" ){
                $elem.parent().find('label').removeClass('active');
            }
        }
    }


    BrooksTheme.Loader.done( function() {
        new BrooksTheme.Form();

    });
    $( document.body ).on( 'updated_shipping_method', function () {
         new BrooksTheme.Form();
    });
})(jQuery, window);
