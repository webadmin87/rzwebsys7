(function($){

    $.fn.feedbackWidget = function(url) {

        return this.each(function () {

            var bl = $(this);

            var process = false;

            bl.find('form').on('submit', function (e) {

                e.preventDefault();

               if(process)
                    return;

                process = true;

                var form = $(this),

                    data = form.serialize(),

                    okMessage = bl.find('.feedback-success'),

                    errorMessage = bl.find('.feedback-error');

                var error = function () {
                    okMessage.hide();
                    errorMessage.show();
                }

                var success = function () {
                    okMessage.show();
                    errorMessage.hide();
                    form.trigger('reset');
                    var data = form.yiiActiveForm('data');
                    data.validated = false;
                    setTimeout(function(){
                        okMessage.hide();
                        errorMessage.hide();
                    },5000);
                }

                var jqXhr = $.ajax({
                        url: url,
                        data: data,
                        method: 'POST',
                        dataType: 'json',
                        success: function (data, status, xhr) {
                            if (xhr.status == 201)
                                success();
                            else
                                error();
                        },
                        error: error
                });

                jqXhr.always(function(){
                    process = false;
                });

            });

        });

    }

})(jQuery);
