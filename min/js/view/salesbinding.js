$(function(){$('[data-toggle="tooltip"]').tooltip(),$(".sb_change").on("click",function(){var t=$(this),o=!0,n=$(this).parents("form").find("input[name=cname]").val();$(".prompt_body_admin h2").text("確定要綁定"+n+"嗎？"),$(".prompt_body_admin").fadeIn(400),$(".prompt_body_admin .btn_yes").on("click",function(){o=!0,$(".prompt_body_admin").fadeOut(400),t.parents("form").submit()}),$(".prompt_body_admin .btn_no").on("click",function(){o=!1,$(".prompt_body_admin").fadeOut(400)})}),$(".prompt_body .btn_yes").on("click",function(){$(".prompt_body").fadeOut(400),$(".prompt_body").remove()}),$(".sb_search").on("click",function(){(function(){var t=!0;return $(".check_unit").each(function(){var o=$(this);0===$.trim(o.val()).length&&(o.tooltip("show"),t=!1)}),t})()&&$(this).parents("form").submit()})});