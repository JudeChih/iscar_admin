$(function(){



//// 按鈕設定 //////////////////////
$('.prompt_body_admin .btn_yes').on('click',function(){
	$('.prompt_body_admin').fadeOut(400);
	window.location="/service/activity"
})
$('.prompt_body_admin .btn_no').on('click',function(){
	$('.prompt_body_admin').fadeOut(400);
	window.location="/service/activity"
})
// 刪除按鈕
$('.pai_flag').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能刪除一個活動項目！');
            $('.panel_form form').removeClass('select_case');
        }else{
            var action = $('.panel_form form.select_case').prop('action');
            action = action+'/delete';
            $('.panel_form form.select_case').prop('action',action);
            $('.panel_form form.select_case').submit();
        }
    }else{
        setTipBox('請選擇任一個活動項目！');
    }
})
// 修改按鈕
$('.pai_modify').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能設置一個活動項目！');
            $('.panel_form form').removeClass('select_case');
        }else{
            var action = $('.panel_form form.select_case').prop('action');
            action = action+'/modify';
            $('.panel_form form.select_case').prop('action',action);
            $('.panel_form form.select_case').submit();
        }
    }else{
        setTipBox('請選擇任一個活動項目！');
    }
})




///////////////////////////////////// 工具區 /////////////////////////////////////

// 選擇一筆資料的highlight
$('.panel_form form').on('click', function() {
  if ($(this).hasClass('select_case')) {
    $(this).removeClass('select_case')
  } else {
    $(this).addClass('select_case');
  }
})

/**
 * 提示框生成
 */
setTipBox = function(text){
    var text = '<div class="prompt_body_admin tip_box">'+
                    '<div class="prompt_box_admin panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h3>提示框</h3>'+
                        '</div>'+
                        '<h2>'+text+'</h2>'+
                        '<div>'+
                            '<button type="button" class="btn btn-success cancel">確認</button>'+
                        '</div>'+
                    '</div>'+
                '</div>';
    $('body').append(text);
    $('.tip_box').fadeIn(400);
    $('.prompt_body_admin .cancel').on('click',function(){
        $('.tip_box').fadeOut(400);
        $('.tip_box').remove();
    })
}

})