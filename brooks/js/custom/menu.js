(function($, window){
    function hasClass(element, cls) {
        return document.querySelector(element).className.indexOf(' ' + cls + ' ') > -1;
    }

    var BrooksTheme = window.BrooksTheme || {},
        _global = BrooksTheme.Global
    BrooksTheme.Menu = function($elem){
        this.$elem = $elem,
            this.$asideDropdown = $(".dropdown__content",this.$elem),
            this.debounce = null;

        this.$elem.find(' .dropdown').mouseenter(function(){
            if (_global.windowWidth > 1024){
                $(this).children('.dropdown__menu,  .dropdown__content').addClass('active');
            }
        });
        this.$elem.find('.dropdown').mouseleave(function(){
            if (_global.windowWidth > 1024){
                $(this).children(' .dropdown__menu,  .dropdown__content').removeClass('active');
            }
        });
        
        this.$elem.find('.dropdown').click(function(){

            if (_global.windowWidth <= 1024 || hasClass('body > header > nav', '-mobile__menu') || hasClass('body > header > nav', '-aside__menu') ){

                $(this).siblings().children('.dropdown__menu, .dropdown__content').removeClass('active');
                $(this).siblings().children('.dropdown__content').slideUp('active');
                $(this).children('.dropdown__menu, .dropdown__content').toggleClass('active');
                $(this).children('.dropdown__content').slideToggle();
                event.stopPropagation();
            }
        });



        this.initScroll();
        this.bindFunction.apply(this);
        return this;
    };

    BrooksTheme.Menu.prototype.initScroll = function() {
        var _self = this;

        $(window).on("scroll", function () {
            _self.check();
        });
    };
    BrooksTheme.Menu.prototype.initScrollTo = function(){
        var _self = this;

        _self.$elem.find(' li > a:not(a.dropdown__menu)').each(function(){
            var $this = $(this),
                href = $this.attr('href').match(/#[^\/]*/),
                $row = false;

            if(href) {
                $this.parent().removeClass('active');
                href = href[0];
            }

            try {
                $row = $(href);
            } catch(error) {
                $row = false;
            }

            if($row && $row.length) {

                $this.click(function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    var top = $row.offset().top;

                    TweenMax.to($(window), .8, {
                        scrollTo: {
                            y: top
                        },
                        ease: Power1.easeOut
                    });
                    if(hasClass('body > header > nav', '--menu__list__fullscreen')){
                        $('.open__menu__btn').trigger('click');
                    }
                });
            }

        });
    };

    BrooksTheme.Menu.prototype.check = function() {
        if (BrooksTheme.Global.windowWidth > 1024) {
            if (BrooksTheme.Global.latestKnownScrollY > 10) {
                $(".main__menu").addClass("main__menu--scroll");
            } else {
                $(".main__menu").removeClass("main__menu--scroll");
            }
        }
    };

    BrooksTheme.Menu.prototype.bindFunction = function(){
        $( window ).load((function(){
            this.ckeckAsideDropDown();
        }).bind(this));
        $(window).on('resize',(function () {
            clearTimeout(this.debounce);
            this.debounce = setTimeout(this.ckeckAsideDropDown.bind(this), 100)
        }).bind(this));
    }

    BrooksTheme.Menu.prototype.ckeckAsideDropDown = function() {
        this.$asideDropdown.each(function(num, item){
            var $item = $(item);
            var $parent  = $item.parent(0);

            $item.addClass('push__left');
            $parent.addClass('theme__dropdown__arrow--right');
            var offsetParentPanel = _global.windowWidth - $parent.offset().left - $parent.width();
            //var offsetAsidePanel = _global.windowWidth - $item.offset().left - $item.width();

            if(offsetParentPanel <  20 +  $item.width()) { // lol 20 is tolerance's threshold
                $item.removeClass('push__left');
                $item.addClass('push__right');
                $parent.removeClass('theme__dropdown__arrow--right');
                $parent.addClass('theme__dropdown__arrow--left');
            }else{
                $item.removeClass('push__right');
                $item.addClass('push__left');
                $parent.removeClass('theme__dropdown__arrow--left');
                $parent.addClass('theme__dropdown__arrow--right');
            }
            if(_global.windowWidth <= 1024){
                $item.removeClass('push__left');
                $item.removeClass('push__right');
                $parent.removeClass('theme__dropdown__arrow--right');
                $parent.removeClass('theme__dropdown__arrow--left');

            }
        });


    }


    $(".main__menu__navbar").each(function(){
        var instance = new BrooksTheme.Menu($(this));

        //BrooksTheme.Loader.done(function(){
        instance.initScrollTo();
        //});
    });





})(jQuery, window);