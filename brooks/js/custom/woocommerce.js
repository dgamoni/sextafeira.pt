/**
 * Created by Ion-Digital on 30.06.2016.
 */
(function($, window) {

    Woocommerce = BrooksTheme.Woocommerce = function () {
        this.vars = {
            'container' : $('.products'),
            'toggleButton' : $('#box-toggle'),
            'toggleClassIcon' : 'js-toggle-icon',
            'toggleClassContainer' :  'js-toggle-view',
            'toggleClassItem' : 'theme__product__item--list',
        };
        this.InitQuantityButtons.apply(this);
        this.initModal.apply(this);
        this.search.apply(this);
        this.toggleView.apply(this);
        this.cookies.apply(this);
        this.bindingFunctions.apply(this);
        return this;

    }
    Woocommerce.prototype.bindingFunctions = function () {
        $('body').on('click', '.wc-tabs li a, ul.tabs li a', function (e) {
            e.preventDefault();
            BrooksTheme.Parallax.settings.instances.forEach(function (instance) {
                instance.resize.apply(instance);
            });
        })

    }
    Woocommerce.prototype.InitQuantityButtons = function () {

        $('body').on('click', '.quantity-minus, .quantity-plus', function (e) {
            e.stopPropagation();

            var button = $(this),
                inputField = button.siblings('.quantity-input'),
                step = parseFloat(inputField.attr('step')) || 1,
                max = parseFloat(inputField.attr('max')) || 1000,
                minus = false,
                inputValue = parseFloat(inputField.val()) || 1,
                newInputValue;

            if (button.hasClass('quantity-minus')) {
                minus = true;
            }

            if (minus) {
                newInputValue = inputValue - step;
                if (newInputValue >= 1) {
                    inputField.val(newInputValue);
                } else {
                    inputField.val(1);
                }
            } else {
                newInputValue = inputValue + step;
                if (max === undefined) {
                    inputField.val(newInputValue);
                } else {
                    if (newInputValue >= max) {
                        inputField.val(max);
                    } else {
                        inputField.val(newInputValue);
                    }
                }
            }
            if( $('input[name="update_cart"]').length > 0){

                $('input[name="update_cart"]').prop("disabled", false);
                setTimeout(function(){new BrooksTheme.Form()}, 1000);
            }
        });
    }

    Woocommerce.prototype.initModal = function(){
        if( $('.modal-trigger').length > 0 ) {
            $('.modal-trigger').leanModal();

            $('.modal__close').on('click',function (e)  {
                e.preventDefault();
                e.stopPropagation();
                $('.wrapper__modal').closeModal();
                $('.lean-overlay').detach();
            })

        }
    }

    Woocommerce.prototype.search = function(){
        if( $('.menu__item__search').length > 0 ) {
            $('.menu__item__search').on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).toggleClass('js-search-open');
            });
        }
    }

    //bind click action
    Woocommerce.prototype.toggleView = function(){
        var _self = this;
        if( this.vars.toggleButton.length > 0 ) {
            this.vars.toggleButton.on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                window.location.hash = (window.location.hash === '#tile' || window.location.hash === '') ? '#list' : '#tile';
                Woocommerce._setCookie('hash',window.location.hash, 100);
                _self._toggleClasses.apply(_self);
            });
        }
    }

    // for toggle class
    Woocommerce.prototype._toggleClasses = function() {
        this.vars.toggleButton.toggleClass(this.vars.toggleClassIcon);
        this.vars.container.toggleClass(this.vars.toggleClassContainer);
        $('.theme__product__item', this.vars.container).toggleClass(this.vars.toggleClassItem);
    };

    Woocommerce.prototype.cookies = function (hash) {
        if(( Woocommerce._getCookie('hash') === '#list' || window.location.hash === '#list' ) && $('body').hasClass('archive')){
            window.location.hash = '#list';
            this._toggleClasses.apply(this);
        }
        if($(window).width() <= 767 && window.location.hash === '#tile'){
            window.location.hash = '#list';
            this._toggleClasses.apply(this);
        }
    }
    Woocommerce._setCookie = function(cname, cvalue, exdays){ // static private function
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();

        if(Woocommerce._getCookie(cname) != "")
            Woocommerce._delete_cookie(cname);
        document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/";

    }

    Woocommerce._getCookie = function(cname){ // static private function
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length,c.length);
            }
        }
        return "";
    }
     Woocommerce._delete_cookie = function(cname) {
        document.cookie = cname + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    };
    
    $(document).ready(function () {
        new Woocommerce();
    });
})(jQuery, window);
