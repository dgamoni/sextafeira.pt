(function($) {
	$(document).ready(function() {
        UpdateIconOptions();
		InitAdditionalItemOptions();
	});

	/**
	 * Function that serializes additional menu item options in a single field.
	 */
	function InitAdditionalItemOptions() {
		var navForm = $('#update-nav-menu');

		navForm.on('change', '[data-item-option]', function() {
			GenerateSerializedString();
		});
	}

	function GenerateSerializedString() {
		var dataArrayString = '';
		var navForm = $('#update-nav-menu');
		var menuItemsData = navForm.find("[data-name]");
		menuItemsData.each(function() {
			//get it's value and name
			var attributeName = $(this).data('name');
			var attributeVal  = $(this).val();

			if(attributeVal !== '') {
				//check if current field is checkbox
				if($(this).is('input[type="checkbox"]')) {
					//append it to serialized string only if it's checked
					if($(this).is(':checked')) {
						dataArrayString += attributeName+"="+attributeVal+'&';
					}
				} else {
					dataArrayString += attributeName+"="+attributeVal+'&';
				}
			}
		});

		//remove last & character
		dataArrayString = dataArrayString.substr(0, dataArrayString.length - 1);

		if($('input[name="brooks_menu_options"]').length) {
			$('input[name="brooks_menu_options"]').val(encodeURIComponent(dataArrayString));
		} else {
			//generate hidden input field html with serialized string value
			var hiddenMenuItem = '<input type="hidden" name="brooks_menu_options" value="'+encodeURIComponent(dataArrayString)+'">';

			//append hidden options field to navigation form
			navForm.append(hiddenMenuItem);
		}
	}

    /**
     * Function that loads icon options via AJAX based on icon pack option
     */
    function UpdateIconOptions() {
        var navForm = $('#update-nav-menu');

        navForm.on('change', '[data-icon-pack]', function() {
            var chosenIconPack = $(this).find('option:selected').val();
            var iconDropdown   = $(this).parents('p').first().next('.brooks-icon-select-holder').find('select');
            var spinner        = $(this).parents('li.menu-item').first().find('.spinner');

            var data = {
                action: 'update_admin_nav_icon_options',
                icon_pack: chosenIconPack
            }

            spinner.css('visibility','visible');
            iconDropdown.attr('disabled', 'disabled');

            $.post(ajaxurl, data, function(data){
                iconDropdown.html(data)
				spinner.css('visibility','hidden');
                iconDropdown.removeAttr('disabled');
            });
        });
    }
})(jQuery);