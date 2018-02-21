$(function(){
// 提示欄位未填的功能，初始化
$('[data-toggle="tooltip"]').tooltip();

// 點擊停用/啟用按鈕
$('.sb_change').on('click',function(){
	var $this = $(this);
	var boolean = true;
	var salesname = $(this).parents('form').find('input[name=cname]').val();
	var word = '綁定';

	$('.prompt_body_admin h2').text('確定要'+word+salesname+'嗎？');
	$('.prompt_body_admin').fadeIn(400);

	// 點擊確認送出表單
	$('.prompt_body_admin .btn_yes').on('click',function(){
		boolean = true;
		$('.prompt_body_admin').fadeOut(400);
		$this.parents('form').submit();
	})
	// 點擊取消關閉提示框
	$('.prompt_body_admin .btn_no').on('click',function(){
		boolean = false;
		$('.prompt_body_admin').fadeOut(400);
	})
})

$('.prompt_body .btn_yes').on('click',function(){
	$('.prompt_body').fadeOut(400);
	$('.prompt_body').remove();
})



// 查詢按鈕
$('.sb_search').on('click',function(){
	var isFormValid = checkForm();
	if(isFormValid){
		$(this).parents('form').submit();
	}
})





// 表單送出前的判斷
function checkForm(){
	var isFormValid = true;
	$('.check_unit').each(function(){
		var $this = $(this);
		if($.trim($this.val()).length === 0){
			$this.tooltip('show');
			isFormValid = false;
		}
	})
	return isFormValid;
}



})