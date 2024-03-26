(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.Loader = $.Deferred();

    BrooksTheme.Loader.done( function() {
        $('#page-preloader').addClass('-preloader__done');

        $('[data-bg-src]').each(function(){
            $(this).css('background-image', 'url(' + $(this).data('bg-src') + ')');
        });

        BrooksTheme.Global.setSizes();
    });

    if(BrooksTheme.ThemeOptions.enable_preloader) {
        var loader = imagesLoaded($("body"), { background: true }, function() {
            BrooksTheme.Loader.resolve();
        }).on( 'progress', function( instance, image ) {
            var result = image.isLoaded ? 'loaded' : 'broken';
            console.log( 'image is ' + result + ' for ' + image.img.src );
        });

        $('[data-bg-src]').each(function(){
            loader.addBackground( $(this).data('bg-src'), this );
        });


    } else
        $(window).load(function(){
            BrooksTheme.Loader.resolve();
        });

})(jQuery, window);