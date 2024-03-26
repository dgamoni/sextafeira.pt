(function(window, $) {

    var IonProgressImporter = function($container){
        this.started = this.inProcess = false;
        this.timer = false;

        this.$container = $container;
        this.id = $container.attr('id');
        this.$button = this.$container.find('button');
        this.$progressBar = this.$container.find('.progress-bar');
        this.$progressValue = this.$container.find('.progress-value');

        this.ajax_url = ajaxurl;
        this.ajax_action_process = this.$container.data('ajax-action-process');
        this.ajax_action_reset = this.$container.data('ajax-action-reset');

        this.init();
    }


    IonProgressImporter.instances = [];


    IonProgressImporter.prototype.init = function(){
        var _self = this;

        this.$button.click(function(event){
            event.preventDefault();

            if(!_self.started) {
                _self.startImport();
            } else {
                _self.stopImport();
            }
        });
    }


    IonProgressImporter.prototype.disableImport = function(){
        this.$container.addClass('disabled');
        this.$button.attr('disabled', 'disabled');
    }


    IonProgressImporter.prototype.enableImport = function(){
        this.$container.removeClass('disabled');
        this.$button.removeAttr('disabled');
    }


    IonProgressImporter.prototype.resetImport = function(){
        var _self = this;

        $.post( this.ajax_url, {
            action: this.ajax_action_reset
        }).done(function(response){
            if(!response.success)
                return false;

            _self.updateProgress(response.data.progress);
        });
    }


    IonProgressImporter.prototype.processImport = function(){
        if(this.inProcess)
            return false;

        var _self = this;
        this.inProcess = true;

        $.post( this.ajax_url, {
            action: this.ajax_action_process,
            fetch_attachments: this.$container.find('#import-attachments').is(':checked') * 1,
            force_update: this.$container.find('#force-update').is(':checked') * 1
        }).done(function(response){
            _self.inProcess = false;

            if(!response.success)
                return false;

            if(response.data.message) {
                _self.$container.find('.progress-bar-message').append(response.data.message).scrollTop(20000);
            }

            if(!response.data.progress)
                return false;

            if(response.data.state == 1)
                return _self.stopImport();

            _self.updateProgress(response.data.progress);
        });
    }

    IonProgressImporter.prototype.startImport = function(){
        this.$button.text(this.$button.data('pause-title'));
        this.$progressBar.addClass('active');

        var _self = this;
        this.started = true;

        IonProgressImporter.instances.forEach(function(instance){
            if(instance.id == _self.id)
                return;

            instance.disableImport();
            instance.resetImport();
        });

        this.timer = setInterval(function(){
            _self.processImport();
        }, 100);
    }

    IonProgressImporter.prototype.stopImport = function(){
        var _self = this;

        IonProgressImporter.instances.forEach(function(instance){
            if(instance.id == _self.id)
                return;

            instance.enableImport();
        });

        this.$button.text(this.$button.data('start-title'));

        this.$progressBar.removeClass('active');

        this.started = false;
        clearTimeout(this.timer);
    }

    IonProgressImporter.prototype.updateProgress = function(progress){
        if(progress > 0) {
            this.$container.find('#force-update').attr('disabled', 'disabled');
            this.$container.find('#import-attachments').attr('disabled', 'disabled');
        }

        this.$progressBar.find('.progress').css('width', progress + '%');
        this.$progressValue.text(parseInt(progress) + '%');
    }

    $('.ion-progress-importer').each(function(){
        IonProgressImporter.instances.push(new IonProgressImporter($(this)));
    });

})(window, jQuery);
