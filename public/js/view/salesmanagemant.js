$(document).ready(function(){

// 點擊停用/啟用按鈕
$('.sm_change').on('click',function(){
	var $this = $(this);
	var boolean = true;
	var salesname = $(this).parents('form').find('input[name=md_cname]').val();
	var status = $(this).parents('form').find('input[name=sls_status]').val();
	var word = '';
	if(status ==1){
		word = '啟用';
	}else if(status ==2){
		word = '停用';
	}
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




})