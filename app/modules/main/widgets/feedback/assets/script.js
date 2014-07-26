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

                var form = $(this);

                var data = form.serialize();

                var error = function () {
                    bl.find('.feedback-success').hide();
                    bl.find('.feedback-error').show();
                }

                var success = function () {
                    bl.find('.feedback-success').show();
                    bl.find('.feedback-error').hide();
                    form.trigger('reset');
                    var data = form.yiiActiveForm('data');
                    data.validated = false;
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
