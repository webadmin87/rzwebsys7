(function($){
    $.fn.ajaxLauncher = function(url){

        return this.each(function(){

            var bl = $(this);

           bl.find('.launcher-btn').on("click", function(){

                var btn = $(this);

                var progressBar = bl.find('.launcher-progress');

                var label = bl.find(".launcher-label");

                if(btn.attr("disabled") == "disabled")
                    return;

                btn.attr("disabled", "disabled");

                progressBar.css("width", "0%");

                label.removeClass("alert-danger alert-success").html("").hide("fast");

                var starter = new AjaxStarter(url, function(){

                    if(this.errors) {

                        progressBar.css("width", 0+"%");

                        btn.attr("disabled", false);

                        $.each(this.errors, function(k,v){

                            var div = $("<div>"+v+"</div>");

                            label.append(div);

                        });

                        label.addClass("alert-danger").show("fast");

                        return;
                    }

                    progressBar.css("width", this.procents+"%");

                    if(this.procents >= 100) {
                        label.addClass("alert-success").html("OK").show("fast");
                        btn.attr("disabled", false);
                    }

                });

                starter.request();
            })
        });
    }
})(jQuery);