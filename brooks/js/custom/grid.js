(function($, window){
    var BrooksTheme = window.BrooksTheme || {},
        _global = BrooksTheme.Global;

    BrooksTheme.Loader.done(function(){
        $('.theme__grid').packery({
            itemSelector: '.grid__item'
        });
    });

})(jQuery, window);
