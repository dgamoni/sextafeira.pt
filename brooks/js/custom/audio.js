(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.Audio = function($elem){
        var _self = this;

        this.$elem = $elem;
        this.audio = $elem.find('audio').get(0);
        this.$progress = $elem.find('.load__bar');
        this.$play = $elem.find('.play__btn');
        this.$mute = $elem.find('.volume__btn');

        this.audio.addEventListener("timeupdate", function(){
            _self.update();
        });

        this.audio.addEventListener("onended", function(){
            _self.$elem.removeClass('-is_play');
        });

        this.$play.click(function(){
            if(_self.audio.paused) {
                if(BrooksTheme.Audio.active)
                    BrooksTheme.Audio.active.pause();
                else
                    BrooksTheme.Audio.active = _self.audio;

                _self.audio.play();
                _self.$elem.addClass('-is_play');
            } else {
                _self.audio.pause();
                _self.$elem.removeClass('-is_play');
            }
        });

        this.$mute.click(function(){
            if(_self.audio.volume == 0) {
                _self.audio.volume = 1;
                _self.$elem.removeClass('-is_mute');
            } else {
                _self.audio.volume = 0;
                _self.$elem.addClass('-is_mute');
            }
        });
    }

    BrooksTheme.Audio.prototype.update = function(){
        var progress = (this.audio.currentTime * 100/this.audio.duration) + '%';
        this.$progress.css('width', progress);
    }

    BrooksTheme.Audio.active = null;

    $(document).ready(function() {
        $('.theme__audio__player').each(function() {
            new BrooksTheme.Audio($(this));
        });
    });

})(jQuery, window);