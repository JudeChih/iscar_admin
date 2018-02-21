$(document).ready(function(){
Cookies.remove('search_conditions');
var setting = {
    "ssrm_settledate": $('.search_form input[name=ssrm_settledate]').val()
}
Cookies.set('settledata',JSON.stringify(setting));

//將查詢的值在頁面初始化的時候先存到cookie
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

$('.ssrm_settlementreview option').each(function(){
    var aa = $('.search_form').find('input[name=ssrm_settlementreview]').val();
    if($(this).val() == aa){
        $(this).prop('selected',true);
    }
})
$('.ssrm_settlementreview select').change(function(){
    $('.search_form').find('input[name=ssrm_settlementreview]').val($(this).find('option:selected').val());
})

////// 按鈕設定 ///////////////////////////////////////////////////////////////////////////////
// 詳情按鈕
$('.ssl_detail').on('click',function(){
	if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能查看一家特店！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.panel_form form.select_case').submit();
        }
    } else {
        setTipBox('請選擇任何一家特店');
    }
})
// 查詢按鈕
$('.ssl_search').on('click',function(){
    $('.search_form').prop('action','/settle/settlementshoplist');
	$('.search_form').submit();
})
// 清除按鈕
$('.ssl_clear').on('click',function(){
	$('.search_form input[name=total_page]').val('');
	$('.search_form input[name=skip_page]').val(0);
	$('.search_form input[name=sort]').val('sd_shopname');
	$('.search_form input[name=order]').val('DESC');
	$('.search_form input[name=query_name]').val('');
    $('.search_form input[name=ssrm_settlementreview]').val(0);
    $('.search_form input[name=ssrm_id]').val('');
	$('.search_form').submit();
})
// 覆核按鈕
$('.ssl_review').on('click',function(){
    if($('.ssl_form').length > 0){
        var array = [];
        $('.ssl_form').each(function(){
            array.push($(this).find('input[name=ssrm_id]').val());
        })
        $('.search_form').find('input[name=ssrm_id]').val(JSON.stringify(array));
        $('.search_form').prop('action','/settle/review');
        $('.search_form').submit();
    }
})
// 匯出出款按鈕
$('.ssl_out_payment').on('click',function(){
    if($('.ssl_form').length > 0){
        var array = [];
        $('.ssl_form').each(function(){
            array.push($(this).find('input[name=ssrm_id]').val());
        })
        $('.search_form').find('input[name=ssrm_id]').val(JSON.stringify(array));
        $('.search_form').prop('action','/settle/outpayment');
        $('.search_form').submit();
    }
})
// 匯入出款按鈕
$('.ssl_in_payment').on('click',function(){
    $('.ssl_body').fadeIn(400);
    $('.inpayment_form').find('input[name=ssrm_settlementreview]').val($('.search_form').find('input[name=ssrm_settlementreview]').val());
    $(document).mouseup(function(e){
        var _con1 = $('.ssl_box');
        if(!_con1.is(e.target) && _con1.has(e.target).length === 0){
            $('.ssl_body').fadeOut(400);
            $(document).unbind('mouseup');
        }
    });
})
// 匯入出款按鈕視窗裡面的匯入按鈕
$('.btn_import').on('click',function(){
    $('.loading_body').fadeIn(400);
})
//////////////////////////////////////////////////////////////////////////////////////////////


// 下方頁碼所使用的plugin
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
// 選擇一筆資料的highlight
$('.panel_form form').on('click', function() {
	if ($(this).hasClass('select_case')) {
	    $(this).removeClass('select_case');
	} else {
        $('.panel_form form').removeClass('select_case');
	    $(this).addClass('select_case');
	}
})

});