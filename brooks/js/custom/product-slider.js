/**
 * Created by Ion-Digital on 23.06.2016.
 */
(function($, window){
    var BrooksTheme = window.BrooksTheme || {};
    var defaultOptions = {
        container : 'body'
    };
    var _pSlider = BrooksTheme.Gallery = {
        initialize: function(opt){
            var option = Object.assign({},defaultOptions, opt);
                $( '.product .slick-container', option.container ).imagesLoaded( function() {
                    $( '.product .slick-container-nav', option.container ).slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        asNavFor: '.product .slick-container-for',
                        dots: false,
                        centerMode: false,
                        focusOnSelect: false,
                        arrows: false,
                    });
                    $( '.product .slick-container-for', option.container ).slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        asNavFor: '.product .slick-container-nav',
                        dots: false,
                        centerMode: false,
                        focusOnSelect: true,
                        vertical: true,
                        verticalSwiping: true,
                        arrows: false,
                    });
                } );


        }
    }

    $(document).ready(function(){
        _pSlider.initialize();
    });

})(jQuery, window);
