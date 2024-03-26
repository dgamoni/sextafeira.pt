(function($, window){
    var BrooksTheme = window.BrooksTheme || {},
        _global = BrooksTheme.Global;

    var _parallax = BrooksTheme.Parallax = function($container) {
        this.$originalContainer = $container;
        this.containerHeight = $container.height();
        this.containerWidth = $container.width();
        this.containerTop = $container.offset().top;

        var _self = this,
            _settings = BrooksTheme.Parallax.settings,
            diff = _global.latestKnownScrollY - this.containerTop;

        var $container = this.$container = $container.clone();
        _settings.$covers.append($container);

        $container.height(this.containerHeight + 100).width(this.containerWidth);


        this.$images = $container.find('.parallax__image');
        this.speed = parseInt($container.data('parallax-speed')) || _settings.speed;
        this.delay = parseInt($container.data('parallax-delay')) || _settings.delay;



        this.tweens = {
            container: new TweenMax($container, 0, {css: { x: 0, y: -diff, z: 0 }, force3D:true, ease:Linear.easeNone}),
            images: []
        }

        this.$images.each(function(index){
            var $this = $(this),
                imgHeight = _self.containerHeight + Math.abs(_global.windowHeight - _self.containerHeight) * _self.speed;

            if(_self.speed > 1) {
                $this.css('top', imgHeight * (1 - _self.speed));
                imgHeight = imgHeight * (2*_self.speed - 1);
            }

            $this.height(imgHeight);

            _self.tweens.images[index] = new TweenMax($this, _self.delay, {css: { x: 0, y: diff * _self.speed, z: 0 }, force3D:true, ease:Linear.easeNone});
        });

        TweenMax.ticker.addEventListener('tick', function(){_self.update()});
    }

    BrooksTheme.Parallax.prototype.update = function(){
        var _self = this,
            diff = _global.latestKnownScrollY - _self.containerTop;

        this.tweens.container.updateTo({css: { x: 0, y: -diff, z: 0 }});

        _self.tweens.images.forEach(function(tween){
            tween.updateTo({css: { x: 0, y: diff * _self.speed, z: 0 }}, Boolean(_self.delay));
        });
    }

    BrooksTheme.Parallax.prototype.resize = function(){
        var _self = this;

        this.containerHeight = this.$originalContainer.height();
        this.containerWidth = this.$originalContainer.width();
        this.containerTop = this.$originalContainer.offset().top;

        this.$container.height(this.containerHeight + 100).width(this.containerWidth);

        this.$images.each(function(index){
            var $this = $(this),
                imgHeight = _self.containerHeight + Math.abs(_global.windowHeight - _self.containerHeight) * _self.speed;

            if(_self.speed > 1) {
                $this.css('top', imgHeight * (1 - _self.speed));
                imgHeight = imgHeight * (2*_self.speed - 1);
            }

            $this.height(imgHeight);
        });

        this.update();
    }

    BrooksTheme.Parallax.settings = {
        containerSelector: '.parallax__wrap',
        imageSelector: '.parallax__image',
        speed: 0.5,
        delay: 0,
        $covers: $('<div class="parallax__covers"></div>'),
        instances: []
    }

    BrooksTheme.Parallax.init = function() {
        var _settings = _parallax.settings;

        if(!_settings.$covers.parent().length) {
            $('body').append(_settings.$covers);

            $(_settings.containerSelector).each(function () {
                var instance = new BrooksTheme.Parallax($(this));
                $(this).data('parallax', instance);

                _settings.instances.push(instance);
            });

            $(window).on("scroll", function(){
                _settings.instances.forEach(function(instance){
                    instance.update();
                });
            });

            $(window).on("resize", function(){
                _settings.instances.forEach(function(instance){
                    instance.resize();
                });
            });
        }
    }

    BrooksTheme.Parallax.resize = function() {
        var _settings = _parallax.settings;

        _settings.instances.forEach(function(instance){
            instance.resize();
        });
    }

    BrooksTheme.Loader.done(function(){
        BrooksTheme.Parallax.init();
    });

})(jQuery, window);
