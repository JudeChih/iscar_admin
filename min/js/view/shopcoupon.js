$(function(){$(".sc_status").on("click",function(){console.log(111),$(".sdmr_body").fadeIn(400),$(".sdmr_body .btn_no").on("click",function(){$(".sdmr_body").fadeOut(400)}),$(".sdmr_body .btn_yes").on("click",function(){$(".sdmr_body").fadeOut(400);var o=$(".sdmr_body textarea").val(),n=[],t=[],d="",a=$("form").find("input[name=sd_id]").val();n.push(a);var i=$("form").find("input[name=scm_id]").val();t.push(i);d=0==$("form").find("input[name=sd_activestatus]").val()?1:0;var s=$("input[name='_token']").val();$.ajax({url:"/shop/shopcoupondata/modify",type:"POST",cache:!1,datatype:"json",data:{_token:s,scm_id:t,sd_id:n,sdmr_modifyreason:o,status:d,modify_type:1},beforeSend:function(o){o.setRequestHeader("X-CSRF-TOKEN",$("#token").attr("content"))},success:function(o){$(".prompt_body_admin h2").text(o),$(".prompt_body_admin").fadeIn(400)},error:function(){console.log("error")}})})}),$(".prompt_body_admin .btn_yes").on("click",function(){$(".prompt_body_admin").fadeOut(400),window.location="/shop/shopcoupondata-list"}),$(".prompt_body_admin .btn_no").on("click",function(){$(".prompt_body_admin").fadeOut(400),window.location="/shop/shopcoupondata-list"})});