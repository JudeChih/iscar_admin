$(document).ready(function(){$(".sm_change").on("click",function(){var n=$(this),t=!0,o=$(this).parents("form").find("input[name=md_cname]").val(),m=$(this).parents("form").find("input[name=sls_status]").val(),d="";1==m?d="啟用":2==m&&(d="停用"),$(".prompt_body_admin h2").text("確定要"+d+o+"嗎？"),$(".prompt_body_admin").fadeIn(400),$(".prompt_body_admin .btn_yes").on("click",function(){t=!0,$(".prompt_body_admin").fadeOut(400),n.parents("form").submit()}),$(".prompt_body_admin .btn_no").on("click",function(){t=!1,$(".prompt_body_admin").fadeOut(400)})}),$(".prompt_body .btn_yes").on("click",function(){$(".prompt_body").fadeOut(400),$(".prompt_body").remove()})});