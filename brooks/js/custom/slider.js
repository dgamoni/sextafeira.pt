(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.Slider = function(){

        $('.theme__slider__block').each(function(){
            var $slider = $(this),
                items = $slider.data('items') || 1,
                autoplay = $slider.data('autoplay') || false;

            new Swiper($slider, {
                pagination: $slider.find('.swiper-pagination'),
                paginationClickable: true,
                autoplay: autoplay,
                slidesPerView: items,
                speed: 500
            });

        });
    }


    BrooksTheme.Loader.done(function(){
        BrooksTheme.Slider();
    });

})(jQuery, window);