$(document).ready(function(){
Cookies.remove('search_conditions');

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

$('.ssrd_billingtype select').change(function(){
	$('.search_form').find('input[name=ssrd_billingtype]').val($(this).find('option:selected').val());
	$('.search_form').submit();
})
// 頁面載入完畢以後要做的事情
window.onload = function(){
  // 遮蔽重要訊息
	$('.change_scg').each(function(){
		var string = $(this).text();
		string = setCharAt(string,1,'*');
		$(this).text(string);
	})

	//數字欄位三位一個點
	var j_n_l = $('.change_num').length;
	for (var i = 0; i <= j_n_l; i++) {
	    $('.change_num').eq(i).text(thousandComma($('.change_num').eq(i).text()));
	}
	$('.ssrd_billingtype select option').each(function(){
		if($(this).val() == $('.search_form').find('input[name=ssrd_billingtype]').val()){
			$(this).prop('selected',true);
		}
	})
}



////// 按鈕設定 //////////////////////////////////////////////////////////////////
//返回按鈕
$('.soc_back').on('click',function(){
	$('.back_form').submit();
})


/////////////////////////////////////////////////////////////////////////////////


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

setCharAt = function (str,index,chr) {
	var string = '';
  if(index > str.length-2) return str;
  if(str.length > 10){
  	for(var i=0;i<str.length-10;i++){
  		string = string + chr;
  	}
  	return str.substr(0,2) + string + str.substr(str.length-2);
  }
  return str.substr(0,index) + chr + str.substr(index+1);
}

thousandComma = function(number){
    var num = number.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while(pattern.test(num)){
        num = num.replace(pattern, "$1,$2");
    }
    return num;
}



});