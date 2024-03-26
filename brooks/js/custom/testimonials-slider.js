(function($, window){
    var BrooksTheme = window.BrooksTheme || {};
    var defaultOptions = {
        container : 'body'
    };
    BrooksTheme.Testimonials = function(opt){
      $('.testimonials-block').each(function(){
        var id = this.attributes.id.textContent;
        var option = Object.assign({},defaultOptions, opt);
        $( '#' + id, option.container ).imagesLoaded( function() {
          $( '#' + id +'.testimonials-block .tab-content', option.container ).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '#' + id +'.testimonials-block .customers__tab__list',
            dots: false,
            centerMode: false,
            focusOnSelect: false,
            arrows: false
          });

          $( '#' + id +'.testimonials-block .customers__tab__list', option.container ).slick({
            asNavFor: '#' + id +'.testimonials-block .tab-content',
            dots: false,
            centerMode: false,
            focusOnSelect: true,
            arrows: false,
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3
                }
              },
              {
                breakpoint: 767,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          });
        });
      });
    }

    BrooksTheme.Loader.done(function(){
        BrooksTheme.Testimonials();
    });

})(jQuery, window);