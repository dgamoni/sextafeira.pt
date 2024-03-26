(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.Modal = function(){
        $('.modal-trigger').leanModal();

        $('.modal__close').on('click',function (e)  {
            e.preventDefault();
            e.stopPropagation();

            $(this).parents('.wrapper__modal').closeModal();
        });
    }

    $(document).ready(function(){
        BrooksTheme.Modal();
    });

})(jQuery, window);