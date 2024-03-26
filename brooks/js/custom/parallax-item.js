(function($, window){
    var BrooksTheme = window.BrooksTheme || {},
        _global = BrooksTheme.Global;
    var defaults = {
        delta: 100,
        shift: 0,
        startbg: 0
    };
    var
        $win      = $(window),
        winHeight = $win.height(),
        started = false;

    // Parallax constructor
    // @param {string} selector - selector for parallax
    // @param {object} options
    // {number} options.delta - track
    // {number} options.shift - initial offset

    BrooksTheme.ParallaxClass = function(selector, options) {
        this._init(selector, options);
    }
    BrooksTheme.ParallaxClass.prototype = {

        "_init": function (selector, options) {
            this.el = (selector instanceof $) ? selector : $(selector);
            this.pastProgress = 0;
            this.durationValueCache = winHeight + this.el.height();
            var htmlOptions = this.htmlData();

            this.props = $.extend({}, defaults, htmlOptions, options);
            this.el.css({position: 'relative'});
            if (this.props.shift)
                this.el.css({top: this.props.shift + 'px'})

            $(window).on("resize", this._updateDuration.bind(this));
            $(window).triggerHandler("resize");
        },
        "move": function (progress, direction, el) {
            var val = this.props.delta * progress;
            val = this._threshold(val, direction);

            TweenMax.to(this.el, .2, {y: -val, ease: Linear.easeNone});
        },
        "movePages": function (progress, direction, el) {
            var val = this.props.delta * progress;
            val = this.props.delta - this._threshold(val, direction);

            TweenMax.to(this.el, 0, {y: val, ease: Linear.easeNone});
        },


        "moveWave": function (progress, direction) {
            var val = this.props.delta * progress;
            val = this._threshold(val, direction);
            //  this.el.css({
            //   'background-position-x': `${val}px`,
            //   '-webkit-transition': 'opacity 2000ms cubic-bezsier(0.18, 0.89, 0.18, 0.88)',
            //  transition: 'opacity 2000ms cubic-bezier(0.18, 0.89, 0.18, 0.88)',
            // });
            TweenMax.to(this.el, 1, {css: {'background-position-x': val}, ease: Linear.easeNone});
        },


        "moveLand": function (progress, direction) {
            var val = this.props.delta * progress;

            if (this.props.delta > 0)
                val = this._threshold(val, direction);

            if (this.props.delta < 0)
                val = Math.abs(this.props.delta) - this._threshold(Math.abs(val), direction);

            TweenMax.to(this.el, .1, {css: {'background-position-y': this.props.startbg + val}, ease: Linear.easeNone});
        },

        "_threshold": function (progress, direction) {
            const threshold = .1;
            if (direction == "REVERSE") {
                progress = progress + threshold < this.pastProgress ? progress : this.pastProgress;

            } else if (direction == "FORWARD") {
                progress = progress > this.pastProgress + threshold ? progress : this.pastProgress;
            }
            this.pastProgress = progress;
            return progress;
        },

        "_getDuration": function () {
            return this.durationValueCache;
        },

        "_updateDuration": function () {
            this.durationValueCache = $win.height() + this.el.height();
        },

        "setScene": function (scene) {
            scene.duration(this._getDuration.bind(this));
        },

        "htmlData": function(){
            var obj = {},
            data = this.el.data(Object.keys(this.el.data())[0]);

            if ($.isNumeric(data))
                obj.delta = data;
            else if (typeof data === 'object')
                obj = data;

            return obj
        }
    }

    var scrollController = new ScrollMagic.Controller({
        container: 'body',
        loglevel: 2,
        refreshInterval: 16
    });

    function SC_addScene (props) {
        var scene = new ScrollMagic.Scene(props);
        scrollController.addScene(scene);
        return scene
    }



// parallax scenes

    function main(){

        var parallaxType = [''];
        imagesLoaded( document.querySelector('body'), function() {

            // on load action here

            if($win.width() >= 991 && !started){
                started = true;
                parallaxType.forEach(parallax);
            }
        });

    }




    function parallax(slug) {

        $('[data-parallax]').each(function(index, el){

            var $el = $(el),
                parallaxInstance = new BrooksTheme.ParallaxClass($el),
                slugUpper = 'move' + slug.charAt(0).toUpperCase() + slug.slice(1);

            var scene = SC_addScene({
                duration: winHeight + $el.height(),
                triggerHook: 'onEnter',
                triggerElement: el
            })
                .on('progress', function(e){
                    parallaxInstance[slugUpper](e.progress, e.scrollDirection);
                })
            parallaxInstance.setScene(scene);
        });
    }

    BrooksTheme.Loader.done(main);
    $win.on('resize', main);

}(jQuery, window));







