$(document).ready(function(){
var setting = {
    "ssrm_settledate": $('.sc_form input[name=ssrm_settledate]').val(),
    "sd_id": $('.sc_form input[name=sd_id]').val()
}
Cookies.set('settledata',JSON.stringify(setting));
window.onload = function(){
	//數字欄位三位一個點
	var j_n_l = $('.change_num').length;
	for (var i = 0; i <= j_n_l; i++) {
	    $('.change_num').eq(i).text(thousandComma($('.change_num').eq(i).text()));
	}
}
////// 按鈕設定 //////////////////////////////////////////////////////////////////
//返回按鈕
$('.sc_back').on('click',function(){
	$('.back_form').submit();
})
//明細按鈕
$('.sc_detail').on('click',function(){
	$('.sc_form').submit();
})

/////////////////////////////////////////////////////////////////////////////////
thousandComma = function(number){
    var num = number.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while(pattern.test(num)){
        num = num.replace(pattern, "$1,$2");
    }
    return num;
}
});