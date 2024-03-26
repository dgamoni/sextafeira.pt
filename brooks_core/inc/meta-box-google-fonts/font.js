(function(window, $){

    var FontSelect = function($elem){
        if(!BrooksCoreFonts)
            return;

        this.$elem = $elem;
        this.$fontSelect = $elem.find('.font-family-select select');
        this.$fontStyle = $elem.find('.font-style-select select');
        this.$fontPreview = $elem.find('.font-preview-holder textarea');
        this.$input = $elem.find('.font-total-input');
        this.font = null;
        this.family = null;
        this.style = null;

        this.init();
    }

    FontSelect.prototype.previewFont = function(){
        var style = [this.family];

        if(this.style)
            style.push(this.style);

        WebFont.load({
            google: {
                families: [style.join(':')]
            }

        });

        this.$fontPreview.css('font-family', this.family);
        this.$fontPreview.css('font-style', 'normal');

        if(this.style) {
            this.$fontPreview.css('font-weight', this.style.replace('italic', ''));

            if(this.style.indexOf('italic') !== -1)
                this.$fontPreview.css('font-style', 'italic');
        }
    }

    FontSelect.prototype.saveFont = function(){
        if(!this.font) {
            this.$input.val('');
            return;
        }

        var result = {
            font: this.font,
            family: this.family,
            variants: BrooksCoreFonts[this.font].variants.map(function(item){return item.id})
        };

        if(this.style)
            result.style = this.style;

        this.$input.val(JSON.stringify(result));

        this.previewFont();
    }

    FontSelect.prototype.changeFont = function($select){
        this.font = $select.val();
        this.family = null;
        this.style = null;

        var font = BrooksCoreFonts[this.font];

        if(font) {
            this.family = font.name;

            if(font.variants && font.variants.length) {
                this.$fontStyle.find('option').slice(1).remove();

                var options = font.variants.map(function(style){
                    return '<option value="'+style.id+'">'+style.name+'</option>';
                });

                options = options.join();
                this.$fontStyle.append(options);
                this.$fontStyle.val('').trigger('change');
            }
        }

        this.saveFont();
    }

    FontSelect.prototype.init = function(){
        var _self = this,
            initial = this.$input.val()?JSON.parse(this.$input.val()):{};

        if(initial) {
            this.font = initial.font;
            this.family = initial.family;
            this.style = initial.style;
        }

        this.saveFont();

        this.$fontSelect.on('change', function(){
            _self.changeFont($(this));
        }).on('select2:unselect', function (event) {
            _self.font = null;
            _self.family = null;
            _self.style = null;

            _self.$fontStyle.find('option').remove();
            _self.$fontStyle.val('').trigger('change');

            _self.saveFont();
        });

        this.$fontStyle.change(function(){
            _self.style = $(this).val();

            _self.saveFont();
        });
    }

    $('.brooks-rwmb-google-font').each(function(){
        new FontSelect($(this));
    })

})(window, jQuery)