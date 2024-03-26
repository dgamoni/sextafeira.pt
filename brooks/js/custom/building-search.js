(function($, window){
    var BrooksTheme = window.BrooksTheme || {};

    BrooksTheme.BuildingSearch = function($elem){
        var _self = this,
            containerId = $elem.data('container-id');

        this.PostGrid = $('#'+containerId).data('PostGrid');

        this.initSearch($elem);
    }

    BrooksTheme.BuildingSearch.prototype.initSearch = function($elem){
        var $country = $elem.find('select.country__select'),
            $city = $elem.find('select.city__select'),
            $type = $elem.find('select.type__select'),
            $submit = $elem.find('button'),
            $cityLoader = $elem.find('.ajax-loader.city-loader'),
            $submitLoader = $elem.find('.ajax-loader.submit-loader'),
            _self = this,
            searchData = {
                country: null,
                city: null,
                type: null
            },
            $searchContainer = $( '#'+_self.containerId );

        _self.loadingSearch = false;


        $country.change(function(){
            var id = this.value;

            searchData.country = id;
            $cityLoader.removeClass('hidden');

            BrooksTheme.AjaxController.request({action: BrooksTheme.Ajax.actions.getLocations, id: id}).done(function(response) {
                $city.find('option').slice(1).remove();

                if(response.success == false || !response.data.length) {
                    $city.attr('disabled', '');

                } else {
                    response.data.forEach(function (elem) {
                        $city.append($('<option value="' + elem.term_id + '" data-icon="' + elem.image + '" class="circle">' + elem.name + '</option>'));
                    });
                    $city.removeAttr('disabled');
                }

                $cityLoader.addClass('hidden');
                $city.val('');
                searchData.city = null;
                $city.material_select();
            });
        });

        $city.change(function(){
            searchData.city = this.value;
        });
        $type.change(function(){
            searchData.type = this.value;
        });

        if(_self.PostGrid)
            $submit.click(function(event){
                event.preventDefault();

                if(_self.loadingSearch)
                    return;

                _self.loadingSearch = true;

                $submitLoader.removeClass('hidden');
                _self.PostGrid.updateGrid(searchData).done(function(){
                    $submitLoader.addClass('hidden');
                    _self.loadingSearch = false;
                });

            });
    }

    $(document).ready(function() {
        $('.building__search__form').each(function() {
            new BrooksTheme.BuildingSearch($(this));
        });
    });

})(jQuery, window);