(function($, window){
    var BrooksTheme = window.BrooksTheme || {},
        _global = BrooksTheme.Global;

    BrooksTheme.Chart = function( $elem ){
        this.$elem = $elem;
        this.$chart = this.$elem.find('.chart__holder');

        var _self = this;

        this.settings = {
            type: this.$elem.data('type'),
            bgColor: this.$elem.data('bg-color'),
            activeColor: this.$elem.data('active-color'),
            percentage: parseInt(this.$elem.data('percentage')),
            duration: 3
        };

        if(this.settings.type == 'pie')
            this.initPieChart();
        else if(this.settings.type == 'linear')
            this.initLinearChart();


        BrooksTheme.Loader.done(function(){
            $elem.waypoint(function () {
                _self.updateChart();
                _self.updateLabel();
            }, {
                offset: "70%",
                triggerOnce: true
            });
        });
    }

    BrooksTheme.Chart.prototype.initPieChart = function(){
        var width = this.$chart.width(),
            height = this.$chart.height(),
            radius = Math.min(width, height) / 2,
            $svg = this.$chart.find('svg');

        this.$active = this.$chart.find('circle.active');

        $svg.attr('width', width).attr('height', height);
        $svg.find('circle').attr('cx', radius).attr('cy', radius).attr('r', radius - 10);

        TweenMax.set(this.$active, {drawSVG:"0% 0%"});
    }

    BrooksTheme.Chart.prototype.initLinearChart = function(){
        var width = this.$chart.width(),
            height = this.$chart.height(),
            $svg = this.$chart.find('svg');

        this.$active = this.$chart.find('line.active');

        $svg.attr('width', width).attr('height', height);
        $svg.find('line').attr('x2', width);

        TweenMax.set(this.$active, {drawSVG:"0% 0%"});
    }

    BrooksTheme.Chart.prototype.updateLabel = function(){
        _self = this;

        this.$elem.find('.label__data .label__number').each(function(){
            var counter = { var: 0},
                $this = $(this);

            TweenMax.to(counter, _self.settings.duration, {
                var: parseInt( $this.data('number') ),
                onUpdate: function () {
                    $this.text(~~counter.var);
                }
            });
        });
    }

    BrooksTheme.Chart.prototype.updateChart = function(){
        if(!this.$active)
            return;

        TweenMax.to(this.$active, this.settings.duration, {drawSVG:"0% "+this.settings.percentage+"%"});
    }

    $('.theme__chart__block').each(function(){
        new BrooksTheme.Chart($(this));
    });

})(jQuery, window);
