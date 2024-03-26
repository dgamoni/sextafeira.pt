(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.AjaxController = (function(){});

    BrooksTheme.AjaxController.request = function(data){
        return $.post( BrooksTheme.Ajax.url, data);
    }
})(jQuery, window);