$(function(){
// 停用啟用的按鈕
$('.sc_status').on('click',function(){
	console.log(111);
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
        var sd_id_val = $('form').find("input[name=sd_id]").val();
        sd_id.push(sd_id_val);
        var scm_id_val = $('form').find("input[name=scm_id]").val();
        scm_id.push(scm_id_val);

        var status_type = $('form').find("input[name=sd_activestatus]").val();
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
            data: {_token: token,scm_id:scm_id,sd_id: sd_id,sdmr_modifyreason:reason,status:status,modify_type:1},
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
})

$('.prompt_body_admin .btn_yes').on('click',function(){
	$('.prompt_body_admin').fadeOut(400);
	window.location="/shop/shopcoupondata-list"
})

$('.prompt_body_admin .btn_no').on('click',function(){
	$('.prompt_body_admin').fadeOut(400);
	window.location="/shop/shopcoupondata-list"
})





})