(function($){

    $.fn.reviewWidget = function () {

        return this.each(function(){

            var bl = $(this),
                form = bl.find('form'),
                successMsg = bl.find('.review-success'),
                errorMsg = bl.find('.review-error'),
                process = false;

            var success = function(data) {

                successMsg.show();
                errorMsg.hide();

                form.yiiActiveForm('resetForm');

                var data = form.yiiActiveForm('data');
                data.validated = false;

                setTimeout(function(){
                    form.hide();
                },3000);
            }

            var error = function(data) {
                successMsg.hide();
                errorMsg.show();
            }

            form.on('submit', function(){
                return false;
            });

            form.on('beforeSubmit', function(e){

                e.preventDefault();

                if(process) {
                    return;
                }

                process = true;

                var action = form.attr('action');

                var jqXhr = $.ajax({
                    url: action,
                    type: 'post',
                    data: form.serialize(),
                    headers: {},
                    dataType: 'json',
                    success: function (data, status, xhr) {
                        if(xhr.status == 201) {
                            success(data);
                        }
                        else {
                            error(data);
                        }
                    },
                    error: function(data, status, xhr) {
                        error(data);
                    }
                });

                jqXhr.always(function(data, status, xhr){
                    process = false;
                });

            });

        });

    }

})(jQuery);
