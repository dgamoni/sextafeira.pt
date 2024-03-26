(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.PostGrid = function($elem, dataOptions){
        var _self = this;

        this.settings = {
            gridQuery: null,
            template: null,
            mapId: null
        }

        $.extend(true, this.settings, dataOptions);


        this.$container = $elem;
        this.$loadedItems = $elem.find('.search__results__item');

        this.$emptyResult = $elem.find('.empty__search__result');

        this.loadedIDs = Array();
        this.$loadedItems.each(function(){
            _self.loadedIDs.push(this.id);
        });

        this.$container.data('PostGrid', this);
    };

    BrooksTheme.PostGrid.prototype.getMap = function(){
        if(!this.mapInit) {
            var $map = $(document.getElementById(this.settings.mapId)),
                _self = this;

            this.mapInit = $.Deferred();

            if (!$map.data('Map')) {

                $map.on('mapInit', function () {
                    _self.map = $map.data('Map');
                    _self.mapInit.resolve();
                });

            } else {
                this.map = $map.data('Map');
                this.mapInit.resolve();
            }
        }

        return this.mapInit;
    }

    BrooksTheme.PostGrid.prototype.updateGrid = function(data){
        var request = $.Deferred(),
            _self = this;

        $.extend(data, {action: BrooksTheme.Ajax.actions.getGridPosts}, this.settings.gridQuery);

        BrooksTheme.AjaxController.request(data).done(function(response){

            _self.renderGrid(response.data);

            _self.getMap().then(function(){
                _self.map.updateMapMarkers(response.data.map(function(item){
                    return item.marker;
                }));
            });

            request.resolve();
        });

        return request.promise();
    }

    BrooksTheme.PostGrid.prototype.renderGrid = function(data) {
        var _self = this;

        if(!data.length) {
            this.$loadedItems.addClass('hidden');
            this.$emptyResult.removeClass('hidden');
            return;
        }

        this.$emptyResult.addClass('hidden');

        var $newItems = $(),
            $prevPost = null;

        data.forEach(function(item){
            var postID = 'brooks-grid-single-post-' + item.ID;

            if(_self.loadedIDs.indexOf(postID) < 0) {

                var $post = $(BrooksTheme.Global.fillTemplate(
                    _self.settings.template, {
                        id: postID,
                        permalink: item.permalink,
                        responsive_item_class: _self.settings.gridQuery.element_width,
                        image: item.image,
                        title: item.post_title,
                        address: item.address
                    }
                ) );

                $post.addClass('hidden');
                $newItems.push.apply($newItems, $post);

                _self.$loadedItems.push.apply(_self.$loadedItems, $post);
                _self.loadedIDs.push(postID);

                if(!$prevPost)
                    _self.$container.prepend($post);
                else
                    $prevPost.after($post);

                $prevPost = $post;

                return;
            }

            $prevPost = _self.$container.find('#brooks-grid-single-post-'+item.ID);
            $newItems.push.apply($newItems, $prevPost);
        });

        this.$loadedItems.addClass('hidden');
        $newItems.removeClass('hidden');

        if(BrooksTheme.Parallax)
            BrooksTheme.Parallax.resize();
    };


    $('.search__results__container').each(function(){
        var dataOptions = BrooksTheme.Data.PostGrid[ $(this).attr('id') ] || {};
        new BrooksTheme.PostGrid($(this), dataOptions);
    });

})(jQuery, window);