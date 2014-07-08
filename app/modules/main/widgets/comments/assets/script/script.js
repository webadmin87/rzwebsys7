(function($){

    $.fn.commentsWidget = function() {

        return this.each(function(){

            var bl = $(this);

            var editor = bl.find('textarea');

            var blId = bl.attr("id");

            var errors = function(){

                bl.find('.comments-ok').hide();
                bl.find('.comments-error').show();

            }

            var success = function(modelId){

                bl.find('.comments-ok').show();
                bl.find('.comments-error').hide();

                var id= "pjax-"+blId;

                $(document).on('pjax:end', function() {
                    scrollTo(modelId);
                    $(document).off('pjax:end');
                })

                $.pjax.reload({container:'#'+id});

                editor.val('');

                bl.find(".comments-re-cancel").trigger('click');

            }

            var scrollTo = function(id) {
                var elem = $("#comments-item-"+id);
                if(elem.length>0) {
                    var top = elem.offset().top;
                    $(window).scrollTop(top);
                }

            }

            $("body").on("click", "#"+blId+" .comments-re-link", function(){

                var id = $(this).data("id");

                var username = $(this).data("username");

                bl.find("input[name='parent_id']").val(id);

                bl.find(".comments-re-wrapper").show();

                bl.find(".comments-re-info").html(username);

            });

            // Обработчик для цитаты

            $("body").on("click",  "#"+blId+" .comments-quote-link", function(){

                var id = $(this).data("id");
                var text = $(this).parents('.comments-item').find('.comments-body').text();
                editor.markItUp('insert',
                    { 	openWith:'[quote]',
                        closeWith:'[\/quote]',
                        placeHolder: $.trim(text)
                    }
                );

            });

            // Обработчик для отмены ответа

           bl.find(".comments-re-cancel").on("click", function(e){

               bl.find("input[name='parent_id']").val(0);

               bl.find(".comments-re-wrapper").hide();

               bl.find(".comments-re-info").html("");

               e.preventDefault();

            });

            // Обработчик добавления комментария

            bl.find('.comments-add').on('click', function(e){

                e.preventDefault();

                var form = $(this).parents('form');

                var action = form.attr('action');

                var initValidate = function() {

                    form.find("input,select,textarea").each(function(){
                        $(this).trigger('blur');
                    });

                }

                $.ajax({
                    url: action,
                    type: 'post',
                    data: form.serialize(),
                    headers: {},
                    dataType: 'json',
                    success: function (data, status, xhr) {
                        if(xhr.status == 201) {
                            success(data.id);
                        }
                        else
                            errors();
                    },
                    error: function() {
                        initValidate();
                        errors();
                    }
                });

            })



        });

    }

})(jQuery);