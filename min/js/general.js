$(function(){$('[data-toggle="tooltip"]').tooltip(),$(".sort_check").each(function(){var a=$(this).data("val"),o=$("form.search_form").find('input[name="sort"]').val(),r=$("form.search_form").find("input[name=order]").val(),e=$(this).find("i");if(a==o)switch($(".sort_check").each(function(){e.addClass("dis_none")}),e.removeClass("dis_none"),r){case"ASC":e.addClass("fa-caret-up");break;case"DESC":e.addClass("fa-caret-down")}}),$(".sort_check").on("click",function(){var a=$(this).data("val"),o=$("form.search_form").find('input[name="sort"]').val(),r=$("form.search_form").find("input[name=order]").val();a==o&&"DESC"==r?($("form.search_form").find("input[name=order]").val("ASC"),$("form.search_form").find('input[name="sort"]').val(a)):a==o&&"ASC"==r?($("form.search_form").find("input[name=order]").val("DESC"),$("form.search_form").find('input[name="sort"]').val(a)):($("form.search_form").find("input[name=order]").val("ASC"),$("form.search_form").find('input[name="sort"]').val(a)),$("form.search_form").submit()}),$(".easy-sidebar-toggle").click(function(a){a.preventDefault(),$("body").toggleClass("toggled"),$(".navbar.easy-sidebar").removeClass("toggled")}),$(".btn_authority").on("click",function(){$(".panel_form form").hasClass("select_case")?($path=document.location.pathname,$(".panel_form form.select_case").prop("action",$path+"/auth"),$(".panel_form form.select_case").submit()):alert("請選擇任一筆資料")}),$(".btn_yes").on("click",function(){$(".prompt_body").fadeOut(400,function(){$(".prompt_body").remove()})})});