$(function(){
$.cookie('search_conditions',null);
////////////////將查詢的值在頁面初始化的時候先存到cookie
$('.search_form').find('input[type=hidden]').each(function(){
    var key = $(this).prop('name');
    var value = $(this).val();
    if($.cookie('search_conditions') == null){
        var json = {};
        json[key] = value;
        $.cookie('search_conditions',JSON.stringify(json));
    }else{
        var json = JSON.parse($.cookie('search_conditions'));
        if(json == null){
        	var json = {};
        }
        json[key] = value;
        $.cookie('search_conditions',JSON.stringify(json));
    }
})

//////////////////////////// 動態長出商品類別
for(var i=0;i<shopdata.text.scm_category[0].length;i++){
    $('.scm_category select').append('<option value="'+shopdata.text.scm_category[1][i]+'">'+shopdata.text.scm_category[0][i]+'</option>');
}

/////////////////////////// 初始化頁面的時候，要根據隱藏的各欄位的值，變更各下拉選單的選項
// 動態變更查尋根據的下拉選單
$('.scm_search option').each(function(){
    if($(this).val() == $('.search_form').find('input[name=search_type]').val()){
        $(this).prop('selected',true);
    }
})
$('.scm_category option').each(function(){
	if($(this).val() == $('.search_form').find('input[name=scm_category]').val()){
		$(this).prop('selected',true);
	}
})
$('.scm_poststatus option').each(function(){
	if($(this).val() == $('.search_form').find('input[name=scm_poststatus]').val()){
		$(this).prop('selected',true);
	}
})

//////////////////////////// 下拉選單改變的時候，動態修改查詢的隱藏欄位的值
$('.scm_search select').change(function(){
	$('.scm_search select option').each(function(){
        if($(this).prop('selected')){
            $('.search_form').find('input[name=search_type]').val($(this).val());
        }
    });
})
$('.scm_category select').change(function(){
	$('.scm_category select option').each(function(){
        if($(this).prop('selected')){
            $('.search_form').find('input[name=scm_category]').val($(this).val());
        }
    });
})
$('.scm_poststatus select').change(function(){
	$('.scm_poststatus select option').each(function(){
        if($(this).prop('selected')){
            $('.search_form').find('input[name=scm_poststatus]').val($(this).val());
        }
    });
})



$('#pagination').pagination({
    items: $('.search_form').find('input[name=total_page]').val(),
    itemsOnPage: 1,
    edges:1,
    currentPage:Number($('.search_form').find('input[name=skip_page]').val()) +1,
    cssStyle: 'light-theme',
    onPageClick: function (page,event) {
        var json = JSON.parse($.cookie('search_conditions'));
        $.each(json,function(k,v){
            $('.search_form').find('input[name='+k+']').val(v);
        });
        $('.search_form').find('input[name=skip_page]').val(page-1);
        $('.search_form').submit();
    }
});

// 詳情的按鈕
$('.scm_detail').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            alert('一次只能查看一個商品的詳情！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.panel_form form.select_case').submit();
        }
    }
});

// 查詢的按鈕
$('.scl_search').on('click',function(){
	//將頁碼歸0回到第一頁
    $('.search_form').find('input[name=skip_page]').val(0);
    $('.search_form').submit();
})

// 停用啟用的按鈕
$('.scm_status').on('click',function(){
	if ($('.panel_form form').hasClass('select_case')) {
		$('.sdmr_body').fadeIn(400);
		$('.sdmr_body .btn_no').on('click',function(){
			$('.sdmr_body').fadeOut(400);
		})

		$('.sdmr_body .btn_yes').on('click',function(){
			$('.sdmr_body').fadeOut(400);
			var reason = $('.sdmr_body textarea').val();
			var sd_id = [];
			var scm_id = [];
	        var status = '';
			$('.panel_form form').each(function(){
				if($(this).hasClass('select_case')){
					var sd_id_val = $(this).find("input[name=sd_id]").val();
					var scm_id_val = $(this).find("input[name=scm_id]").val();
					sd_id.push(sd_id_val);
					scm_id.push(scm_id_val);

				}
			});
	        var status_type = $('.panel_form form.select_case').find("input[name=scm_poststatus]").val(); 
	        if(status_type == 0){
	            status = 1;
	        }else{
	            status = 0;
	        }
			var token = $("input[name='_token']").val();
			$.ajax({
				url: '/shop/shopcoupondata/modify',
				type:'POST',
				cache:false,
				datatype:'json',
				data: {_token: token,scm_id: scm_id,sd_id: sd_id,status:status,sdmr_modifyreason:reason,modify_type:1},
				beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
				success: function(data){
					$('.prompt_body_admin h2').text(data);
					$('.prompt_body_admin').fadeIn(400);
				},
				error: function(){
					console.log('error');
				}
			})
		})
    } else {
    	alert('請選擇任何一個商品');
    }
})

// 選擇一筆資料的highlight
$('.panel_form form').on('click', function() {
  if ($(this).hasClass('select_case')) {
    $(this).removeClass('select_case')
  } else {
    $(this).addClass('select_case');
  }
})
$('.panel_form form').dblclick(function() {
  $(this).submit();
})







$('.prompt_body_admin .btn_yes').on('click',function(){
	$('.prompt_body_admin').fadeOut(400);
	window.location="/shop/shopcoupondata-list"+document.location.search;
})

$('.prompt_body_admin .btn_no').on('click',function(){
	$('.prompt_body_admin').fadeOut(400);
	window.location="/shop/shopcoupondata-list"+document.location.search;
})

$('.prompt_body .btn_yes').on('click',function(){
	$('.prompt_body').fadeOut(400);
	$('.prompt_body').remove();
})




})