(function($){


	$(document).ready(function(){

		// Редактор

		var editor = $('#Comments_text');

		// Обработчик для ответа

		$("body").on("click", ".comments-re-link", function(){

			var id = $(this).data("id");

			var username = $(this).data("username");

			$("#Comments_parent_id").val(id);

			$("#comments-re-wrapper").show();

			$("#comments-re-info").html(username);

		});

		// Обработчик для цитаты

		$("body").on("click", ".comments-quote-link", function(){

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

		$("#comments-re-cancel").on("click", function(e){

			$("#Comments_parent_id").val(0);

			$("#comments-re-wrapper").hide();

			$("#comments-re-info").html("");

			e.preventDefault();

		});

	});


})(jQuery);