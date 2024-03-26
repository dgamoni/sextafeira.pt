/**
 * Created by Ion-Digital on 26.07.2016.
 */
(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    var _comingSoon = BrooksTheme.comingSoon = {
        initialize: function(){

            //Useful vars
            var $countdown = $('#countdown'),
                $introProgress = $('.intro__progress-track'),
                percentage = $introProgress.data('percentage'),
                countMoment = moment( $countdown.data('date') + ' ' + $countdown.data('hour')),
                MarkLabels = {
                    data: {},
                    getLabel: function(num, labelsKey) {
                        var label = "";
                        this.data[labelsKey].forEach(function(elem) {
                            if(elem.type == 'num') {
                                if( num >= elem.rule )
                                    label = elem.label;
                            } else if(elem.rule.test(num)) {
                                label = elem.label;
                                return false;
                            }
                        });
                        return label;
                    },
                    setLabels: function( labelsObj ){
                        var key = BrooksTheme.Global.getUniqueId();
                        this.data[key] = labelsObj;
                        return key;
                    }
                };
            
            $countdown.find('.intro__count-in').each(function(index) {
                var newLabels = $(this).find('.datamark').data('labels').split('|').map(function (elem) {
                    var rule = elem.trim().split(':');

                    if (!isNaN(parseInt(rule[0])))
                        return {
                            rule: parseInt(rule[0]),
                            label: rule[1],
                            type: 'num'
                        };
                    else
                        return {
                            rule: new RegExp(rule[0].replace(/\#/g, '')),
                            label: rule[1],
                            type: 'reg'
                        };
                });

                $(this).find('.datamark').data('labelsKey', MarkLabels.setLabels(newLabels));
            });

            setInterval(function(){
                var startElem = true;
                $countdown.find('.intro__count-in').each(function(index) {
                    var mark = $(this).data('mark'),    
                        time = countMoment.countdown()[mark],
                        $datatime = $(this).find('.datatime'),
                        $datamark = $(this).find('.datamark'),
                        labelsKey = $datamark.data('labelsKey');

                    if(startElem &&  time == 0) {
                        $(this).addClass('hidden');
                        return;
                    }

                    startElem = false;

                    $(this).removeClass('hidden');
                    $datatime.text(time);
                    $datamark.text(MarkLabels.getLabel(time, labelsKey));

                });

            }, 1000);
        }
    }

    $(document).ready(function(){
        _comingSoon.initialize();
    });

})(jQuery, window);
