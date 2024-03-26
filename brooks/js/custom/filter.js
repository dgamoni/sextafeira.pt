/**
 * Created by oleg on 02.09.16.
 */
(function($, window){

    var BrooksTheme = window.BrooksTheme || {},
        debug = false,

    Filter = BrooksTheme.Filter = function(opt){
        this.options = Object.assign({} , Filter.default, opt || {});
        this.filter = -1;
        this.addedElem = [];
        this.scene = null;
        this.adminSettings = BrooksTheme.Data.PortfolioGrid;
        this.displayedItems = {};
        this.displayedItemsCount = {};
        this.cachedAll = [];
        this.cachedAdd = [];
        this.times = 0;
        this.exclude = [];
        this.notLoadedAnyMore = [];

        if(this.adminSettings.filter_folio){
            this.init();
        }

    };
    var actions = {
        LOAD_MORE: 'LOAD_MORE',
        LOADED_MORE : 'LOADED_MORE',
        FAILED_MORE : 'FAILED_MORE',
        REMOVED_ALL_ITEMS: 'REMOVED_ALL_ITEMS'
    };

    var dispatcher = {
        _o: $({}),

        on : function() {
            this._o.on.apply(this._o, arguments);
        },

        one :function() {
            this._o.one.apply(this._o, arguments);
        },

        off : function() {
            this._o.off.apply(this._o, arguments);
        },

        trigger : function() {
            this._o.trigger.apply(this._o, arguments);
        }
    };
    var scrollController = new ScrollMagic.Controller({
        container: 'body',
        loglevel: 2,
        refreshInterval: 100
    });

    function SC_addScene (props) {
        var scene = new ScrollMagic.Scene(props);
        scrollController.addScene(scene);
        return scene
    }



    Filter.default = {
        container: '.theme__portfolio__grid',
        triggerElement: '#brooks__loader-trigger',
        downloadbtn :'#brooks__loader-button',
        item: '.grid__item',
        classULfilter: '.brooks__filters',
        classLIfilter: '.brooks__filters-item',
        categoryClass: '.portfolio__categories',
        enablelazyLoad : true,
    };

    Filter.prototype = {
        'init': function() {
            var _self = this;
            _self.handleAddFiltersHTML();

            $(this.options.classULfilter).delegate(this.options.classLIfilter, 'click', this.clickLIfilter.bind(this));

            _self.getDownloadedInfo($(this.options.container));

            $(this.options.container).on( 'removeComplete', function( event, removedItems ) {
                if(debug) console.log('cachedAll '+ (_self.cachedAll.length-1));
                if(debug) console.log('Times '+ _self.times);
                if(_self.times >= _self.cachedAll.length - 1){  // must be ===, but leak
                    setTimeout(function(){dispatcher.trigger(actions.REMOVED_ALL_ITEMS);},0);  // defered
                    _self.times = 0;
                }else{
                    _self.times++;
                }
            } );

            dispatcher.on(actions.REMOVED_ALL_ITEMS, function(){
                _self.cachedAdd != null && _self.cachedAdd.map(function (ind, item) {
                    var cachedd = $(item);
                    $(_self.options.container).append(cachedd).packery('appended', cachedd).packery('layout');
                });
                if(debug) console.log('clickLIfilterON ');
                $(_self.options.classULfilter).delegate(_self.options.classLIfilter, 'click', _self.clickLIfilter.bind(_self));
            });
            if(_self.adminSettings.ajax_folio) {
                this.scene = this._addScene({
                    triggerElement: this.options.triggerElement,
                    triggerHook: 'onEnter'
                });
                if (!_self.adminSettings.ajax_button) {
                    this.scene.on('enter', function() {
                        dispatcher.trigger(actions.LOAD_MORE);

                    });
                } else {
                    $(_self.options.downloadbtn).on('click', function() {
                        dispatcher.trigger(actions.LOAD_MORE);
                    })
                }
                dispatcher.on(actions.LOAD_MORE , function() {
                    _self.handleLoadMore.call(_self)
                });
                dispatcher.on(actions.FAILED_MORE + ' ' + actions.LOADED_MORE, function() {
                    if ($(_self.options.downloadbtn).length > 0) $(_self.options.downloadbtn).removeClass('loading');
                    if ($(_self.options.triggerElement).length > 0) $(_self.options.triggerElement).removeClass('loading');


                });
                dispatcher.on(actions.LOAD_MORE , function() {
                    if ($(_self.options.downloadbtn).length > 0) $(_self.options.downloadbtn).addClass('loading');
                    if ($(_self.options.triggerElement).length > 0) $(_self.options.triggerElement).addClass('loading');


                });

                dispatcher.on(actions.LOADED_MORE, function() {

                })
                $(_self.options.classLIfilter).first().addClass('js-active');
            }

        },
        
        'getDownloadedInfo' : function ($findhere) {
            var _self = this;
            $findhere.find(_self.options.categoryClass).each(function (ind, catClass) {
                _self.cachedAll.push($(this).parents(_self.options.item));
                $(this).parents(_self.options.item).each(function(ind, item){
                    _self.exclude.push(item.id);
                });
              var catNames = $(this).text().split('|'),
                catNamesTrimed = [];
                catNames.map(function(item){
                    catNamesTrimed.push(item.trim().replace(/\s+/g,"_"));
                });
                Object.keys(_self.displayedItems).map(function(item){
                    var attr = '';
                    catNamesTrimed.map(function(catNamesTrimed_item){
                        if(catNamesTrimed_item.indexOf(item) != -1){
                            _self.displayedItemsCount[item] = typeof _self.displayedItemsCount[item] === 'undefined'?1:_self.displayedItemsCount[item]+1;
                            attr = $(catClass).closest(_self.options.item).attr('data-cat' ) || '';
                            $(catClass).closest(_self.options.item).attr('data-cat', attr +' '+item );
                        }
                    });
                })

            });

        },
        'getNamebyId' : function (id) {
            var name = 0,
                _self = this;
            Object.keys(_self.displayedItems).map(function(item){
                if( +_self.displayedItems[item] == +id){
                   name = item;
                }
            })
            return name
        },
        'getOffset' : function () {
            var _self = this,
                count = 0
            if(this.get_filter() > 0){
                Object.keys(_self.displayedItems).map(function(item){
                    if(_self.displayedItems[item] === _self.get_filter()){
                        count =  _self.displayedItemsCount[item]
                    }
                })
            }else{

                _self.displayedItemsCount['ALL'] = typeof _self.displayedItemsCount['ALL'] === 'undefined'?_self.adminSettings.items: (+_self.displayedItemsCount['ALL']) + (+_self.adminSettings.items);
                count = _self.displayedItemsCount['ALL'];

            }
            return count
        },
        'clickLIfilter': function (e) {

            var _self = this;
                e.stopImmediatePropagation();
                e.stopPropagation();
                var cachedAll, cachedAdd;
                var target = e.currentTarget;
                if (_self.filter != target.id) {
                    $(_self.options.classULfilter).off('click');
                    _self.filter = target.id;
                    if(debug) console.log('clickLIfilter ');
                    $(_self.options.classLIfilter).removeClass('js-active');
                    $(target).addClass('js-active');

                    cachedAll = $(_self.cachedAll);
                    cachedAll.each(function (ind, item) {
                        setTimeout(function(){$(_self.options.container).packery('remove', $(item))},0);
                        if(debug) console.log('remove '+cachedAll.length);
                    });
                    $(_self.options.container).packery('shiftLayout');
                    if(target.id == -1 )
                        _self.cachedAdd =cachedAll;
                    else{
                        _self.cachedAdd = cachedAll.filter(function(ind, item){
                            return $(item).data('cat').search(_self.getNamebyId(+target.id)) > -1
                         })
                        if(_self.cachedAdd.length < parseInt(_self.adminSettings.items) && _self.adminSettings.ajax_folio){
                            dispatcher.trigger(actions.LOAD_MORE);
                        }
                    }
                }
            return 0;// stopPropagation IE

        },

        'handleAddFiltersHTML' : function(){
            var _self = this;
            var tempArr = [];
            for ( key in this.adminSettings.terms){
                if(this.adminSettings.terms.hasOwnProperty(key)){
                    tempArr.push(this.adminSettings.terms[key]);
                }
            }
            this.adminSettings.terms = tempArr;
            var terms = Array.prototype.slice.call(this.adminSettings.terms,0);

            this.list = $('<ul/>', {
                'class' : _self.options.classULfilter.substring(1),
            }).insertBefore(this.options.container);



            this.adminSettings.terms.map(function(term){
                $('<li/>', {
                    text: term.name,
                    id: term.term_id,
                    class: _self.options.classLIfilter.substring(1)
                }).appendTo(_self.list);

                _self.displayedItems[term.name.replace(/\s+/g,"_")] = term.term_id;

            });

            this.list.wrap('<div class="brooks__filters-wrap"></div>');
        },
        'handleLoadMore' : function(){
            var _self = this;
            $(_self.options.classULfilter).off('click');
                BrooksTheme.AjaxController.request(Object.assign({

                    action: BrooksTheme.Ajax.actions.getItems,
                    category: _self.filter,
                    offset: _self.getOffset(),
                    exclude: _self.exclude
                }, this.adminSettings)).done(function (response) {
                    dispatcher.trigger(actions.LOADED_MORE, _self.handleLoadedMore.call(_self, response))
                }).fail(function () {
                    dispatcher.trigger(actions.FAILED_MORE, _self.handleFailedLoadMore)
                });


        },
        'handleLoadedMore' : function(response){
            var _self = this;

                new Promise(function (resolse) {
                    _self.render(response, resolse);
                }).then(function () {
                    BrooksTheme.CssAnimation(_self.addedElem);
                    _self.addedElem = []; // clear array
                    _self.scene.update();
                    $(_self.options.classULfilter).delegate(_self.options.classLIfilter, 'click', _self.clickLIfilter.bind(_self));
                });


        },
        'handleFailedLoadMore' : function () {
            alert('Failed load')
        },
        'get_filter': function(){
            return parseInt(this.filter)
        },
        '_addScene': function(props) {

            var scene = new ScrollMagic.Scene(props);
            scrollController.addScene(scene);
            return scene

        },

        'render': function(chunk, cb) {
            var _self = this;
            if(typeof chunk === 'object'){
                chunk.data.map(function(chunk){
                    // ckeched
                    var $chunk = $(chunk);

                    // collection live selector for animation
                    _self.addedElem.push($chunk[0]);

                    _self.getDownloadedInfo($chunk);

                    $(_self.options.container).append( $chunk )
                        .packery( 'appended', $chunk );
                });
            }else{
                $(_self.options.container).append(chunk);
            }

            cb();


        },

    };




    window.BrooksTheme.Loader.done(function(){
            new Filter();
    })








})(jQuery, window)