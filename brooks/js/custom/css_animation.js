(function($, window){
    var BrooksTheme = window.BrooksTheme || {},
        i = 0,
        time = null;

    BrooksTheme.CssAnimation = function(el){
        $(el).find('.theme__animation').each(function(ind, aElem){
            BrooksTheme.CssAnimation.update($(aElem));
        });
    
    }

    BrooksTheme.CssAnimation.update = function($el){

        $el.waypoint(function () {

            if ( $el.offset().top + $el.outerHeight()  < $(document).scrollTop()){

                $el.addClass('-animateIt');
                return;
            }

            $el.addClass('-animateIt');

            clearTimeout(time);
            time = setTimeout(function () {
                i = 0;
            },20);

            $el.addClass('-animation_delay_'+(++i % 10));

        }, {
            offset: "90%",
            triggerOnce: true
        });
    }

    BrooksTheme.Loader.done(
        $('.theme__section').each(function(ind, el) {
            BrooksTheme.CssAnimation(el);
        })
    );

})(jQuery, window);