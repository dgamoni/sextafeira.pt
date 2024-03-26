(function($, window) {

    var vendors = ['webkit', 'moz'];
    for (var i = 0; i < vendors.length && !window.requestAnimationFrame; ++i) {
        var vp = vendors[i];
        window.requestAnimationFrame = window[vp+'RequestAnimationFrame'];
        window.cancelAnimationFrame = (window[vp+'CancelAnimationFrame'] || window[vp+'CancelRequestAnimationFrame']);
    }

    if (/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) // iOS6 is buggy
        || !window.requestAnimationFrame || !window.cancelAnimationFrame) {
        var lastTime = 0;
        window.requestAnimationFrame = function(callback) {
            var now = Date.now();
            var nextTime = Math.max(lastTime + 16, now);
            return setTimeout(function() { callback(lastTime = nextTime); },
                nextTime - now);
        };
        window.cancelAnimationFrame = clearTimeout;
    }


    var BrooksTheme = window.BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.Global = function(){};

    BrooksTheme.Global.initSettings = function(){

        BrooksTheme.Global.uAgent = navigator.userAgent;
        BrooksTheme.Global.macOS = BrooksTheme.Global.uAgent.match(/(iPad|iPhone|iPod|Macintosh)/g) ? true : false;
        BrooksTheme.Global.mobileIE = BrooksTheme.Global.uAgent.indexOf('IEMobile') !== -1;
        BrooksTheme.Global.touch = ('ontouchstart' in window || 'onmsgesturechange' in window) ? true : false;

        BrooksTheme.Global.isNewerIe = BrooksTheme.Global.uAgent.match(/msie (9|([1-9][0-9]))/i),
        BrooksTheme.Global.isOlderIe = BrooksTheme.Global.uAgent.match(/msie/i) && !isNewerIe,
        BrooksTheme.Global.isAncientIe = BrooksTheme.Global.uAgent.match(/msie 6/i);
        BrooksTheme.Global.isIe = BrooksTheme.Global.isAncientIe || BrooksTheme.Global.isOlderIe || BrooksTheme.Global.isNewerIe;

        BrooksTheme.Global.latestKnownScrollY = $('html').scrollTop() || $('body').scrollTop();

        BrooksTheme.Global.setSizes();
    }

    BrooksTheme.Global.setSizes = function() {
        BrooksTheme.Global.documentHeight = $(document).height();
        BrooksTheme.Global.windowWidth = $(window).width();
        BrooksTheme.Global.windowHeight = $(window).height();
    }

    BrooksTheme.Global.getUniqueId = function() {
        return parseInt(Math.random() * (9000 - 1000) + 1000) + '-' + parseInt(Math.random() * (9999 - 1000) + 1000);
    }

    BrooksTheme.Global.fillTemplate = function( template, vars){
        $.each(vars, function(name, value){
            value = value || '';
            template = template.replace(new RegExp('{{'+ name + '}}', 'g'), value);
        });

        return template;
    }

    BrooksTheme.Global.initSettings();

    $(window).on("scroll", function () {
        BrooksTheme.Global.latestKnownScrollY = $('html').scrollTop() || $('body').scrollTop();
    });

    $(document).ready(function(){
        BrooksTheme.Global.setSizes();
    });

    $(window).on('load', function(){
        BrooksTheme.Global.setSizes();
    });

    $(window).on("resize", function () {
        BrooksTheme.Global.setSizes();
    });
})(jQuery, window);
