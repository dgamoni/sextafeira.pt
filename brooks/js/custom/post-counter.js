(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.PostCounter = function(){
        $('.theme__like__post').click(function(event){
            event.preventDefault();

            var $this = $(this);
            BrooksTheme.AjaxController.request({action: BrooksTheme.Ajax.actions.brooks_like_post, ID: $this.data('post-id')}).done(function(response) {

                if(response.data.liked){
                    $this.find('.post__liked').removeClass('hidden');
                    $this.find('.post__unliked').addClass('hidden');

                    var n = $this.find('.like__number').text();

                    if(n)
                        $this.find('.like__number').text(parseInt(n) + 1);
                } else {
                    $this.find('.post__unliked').removeClass('hidden');
                    $this.find('.post__liked').addClass('hidden');

                    var n = $this.find('.like__number').text();
                    if(n)
                        $this.find('.like__number').text(parseInt(n) == 0?0:parseInt(n) - 1);
                }
            });
        });
    }

    $(document).ready(function() {
        new BrooksTheme.PostCounter();
    });

})(jQuery, window);