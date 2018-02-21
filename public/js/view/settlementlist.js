$(document).ready(function(){
$.cookie('search_conditions',null);
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

////// 按鈕設定 ///////////////////////////////////////////////////////////////////////////////
$('.sl_detail').on('click',function(){
	if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能查看一個結算日期！');
            $('.panel_form form').removeClass('select_case');
        }else{
            var setting = {
                "ssrm_settledate": $('.panel_form form.select_case input[name=ssrm_settledate]').val()
            }
            Cookies.set('settledata',JSON.stringify(setting));
            $('.panel_form form.select_case').submit();
        }
    } else {
        setTipBox('請選擇任何一個結算日期');
    }
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
    $(this).removeClass('select_case')
  } else {
    $(this).addClass('select_case');
  }
})

});