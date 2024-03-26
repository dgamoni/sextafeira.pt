(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.Gallery = function(){
        $('.theme__media__gallery').lightGallery({
            selector: '.gallery__item'
        });
    }

    $(document).ready(function(){
        BrooksTheme.Gallery();
    });

})(jQuery, window);

