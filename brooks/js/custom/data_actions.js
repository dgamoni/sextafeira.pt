(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.DataActions = function(arg) {
        var _self = this;
        if ( arg && arg.length > 0 )
            arg.forEach(function (currentValue) {
               if(currentValue.selector.length > 0) _self[currentValue.method].call(_self,currentValue.selector);
            });
        return this
    }
    BrooksTheme.DataActions.prototype.dataToggleClass = function ($elements) {
            //var $elements = $('[data-toggle="class"]');

            $elements.click(function () {
                var $this = $(this),
                    toggleClass = $this.data('class') || 'active',
                    $target = $($this.data('target')),
                    targetClass = $this.data('target-class') || $target.data('class') || 'active';

                $this.toggleClass(toggleClass);
                $target.toggleClass(targetClass);
            });

            return $elements;
    }

    BrooksTheme.DataActions.prototype.dataMoveNext = function ($elements) {
            //var $elements = $('[data-move="next"]');

            $elements.click(function () {
                var $this = $(this),
                    $moveTo = $this.parent().next();

                TweenMax.to($(window), .6, {
                    scrollTo: {
                        y: $moveTo.offset().top
                    },
                    ease: Power1.easeOut
                });
            });

            return $elements;
    }

    BrooksTheme.DataActions.prototype.dataShare = function ($elements) {
            //var $elements = $('[data-share]');

            var share = {
                twitter: function() {
                    window.open('http://twitter.com/intent/tweet?text=' + jQuery("h2.text-title").text() + ' ' + window.location,
                        "twitterWindow",
                        "width=650,height=350");
                    return false;
                },

                // Facebook

                facebook: function(){
                    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(location.href),
                        'facebookWindow',
                        'width=650,height=350');
                    return false;
                },

                // Pinterest

                pinterest: function(){
                    window.open('http://pinterest.com/pin/create/bookmarklet/?description=' + jQuery("h2.text-title").text() + ' ' + encodeURIComponent(location.href),
                        'pinterestWindow',
                        'width=750,height=430, resizable=1');
                    return false;
                },

                // Google Plus

                google: function(){
                    window.open('https://plus.google.com/share?url=' + encodeURIComponent(location.href),
                        'googleWindow',
                        'width=500,height=500');
                    return false;
                },

                // Linkedin

                linkedin: function(){
                    window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(location.href) + '&title=' + jQuery("h1").text(),
                        'linkedinWindow',
                        'width=650,height=450, resizable=1');
                    return false;
                }
            }

            $elements.click(function (event) {
                event.preventDefault();
                var $this = $(this);

                share[$this.data('share')].call();

            });

            return $elements;
    }
    $(document).ready(function(){
        new BrooksTheme.DataActions([
            {
                'selector': $('[data-share]'),
                'method': 'dataShare'
            },
            {
                'selector': $('[data-move="next"]'),
                'method': 'dataMoveNext'
            },
            {
                'selector': $('[data-toggle="class"]'),
                'method': 'dataToggleClass'
            }
        ]);
    });

})(jQuery, window);
