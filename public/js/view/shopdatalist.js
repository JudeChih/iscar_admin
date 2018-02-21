$(function(){
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

/////////////////////////// 初始化頁面的時候，要根據隱藏的各欄位的值，變更各下拉選單的選項
// 動態變更查尋根據的下拉選單
$('.sd_search option').each(function(){
    if($(this).val() == $('.search_form').find('input[name=search_type]').val()){
        $(this).prop('selected',true);
    }
})

//動態變更店家狀態的下拉選單
$('.sd_activestatus option').each(function(){
    if($(this).val() == $('.search_form').find('input[name=sd_activestatus]').val()){
        $(this).prop('selected',true);
    }
})

//動態變更店家綁定狀態的下拉選單
$('.sd_havebind option').each(function(){
    if($(this).val() == $('.search_form').find('input[name=sd_havebind]').val()){
        $(this).prop('selected',true);
    }
})

// 動態新增店家類型下拉選單
for(var i=0;i<shopdata.text.sd_type_text.length;i++){
    $('.sd_type select').append('<option value="'+shopdata.sd_type[shopdata.text.sd_type_text[i]]+'">'+shopdata.text.sd_type_text[i]+'</option>');
}
$('.sd_type select option').each(function(){
    var val = $('.search_form').find('input[name=sd_type]').val();
    if(val == $(this).val()){
        $(this).prop('selected',true);
    }
});

// 動態新增縣市以及區域的下拉選單
setCountryRegion();


//////////////////////// 各個搜尋條件變更的時候，動態修改下拉選單以及隱藏的input的值
// 店家類型下拉選單變動的時候，隨即變更隱藏的sd_type的值
$('.sd_type select').change(function(){
    $('.sd_type select option').each(function(){
        if($(this).prop('selected')){
            $('.search_form').find('input[name=sd_type]').val($(this).val());
        }
    });
});

// 商家有效狀態下拉選單變動的時候，隨即變更隱藏的sd_activestatus的值
$('.sd_activestatus select').change(function(){
    $('.sd_activestatus select option').each(function(){
        if($(this).prop('selected')){
            $('.search_form').find('input[name=sd_activestatus]').val($(this).val());
        }
    });
});

// 綁定狀態下拉選單變動的時候，隨即變更隱藏的sd_havebind的值
$('.sd_havebind select').change(function(){
    $('.sd_havebind select option').each(function(){
        if($(this).prop('selected')){
            $('.search_form').find('input[name=sd_havebind]').val($(this).val());
        }
    });
});

// 縣市下拉選單變動的時候，隨即變更區域的選項以及隱藏的sd_zipcode的值
$('.sd_countries select').change(function(){
    changeCountryRegion();
});

// 區域下拉選單變動的時候，隨即變更隱藏的sd_zipcode的值
$('.sd_region select').change(function(){
    $('.sd_region select option').each(function(){
        if($(this).prop('selected')){
            $('.search_form').find('input[name=sd_zipcode]').val($(this).val());
        }
    });
});


$('.sd_zipcode_turnText').each(function(){
    var val = $(this).text();
    var country_text = '';
    var region_text = '';
    for(var i=0;i<shopdata.countries.length;i++){
        for(var j=0;j<shopdata.region[shopdata.countries[i]][1].length;j++){
            if(shopdata.region[shopdata.countries[i]][1][j] == val){
                country_text = shopdata.countries[i];
                region_text = shopdata.region[shopdata.countries[i]][0][j];
            }
        }
    }
    if(country_text!= '' && region_text!= ''){
        $(this).text(country_text+' '+region_text);
    }
})

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

// 當縣市的下拉選單變動的時候要執行
function changeCountryRegion(){
    var country = '';
    $('.sd_countries select option').each(function(){
        if($(this).prop('selected')){
            country = $(this).text();
        }
    })
    // 刪除目前區域的下拉選單
    $('.sd_region select option').remove();
    // 動態新增區域的下拉選單
    for(i=0;i<shopdata.region[country][0].length;i++){
        $('.sd_region select').append('<option value="'+shopdata.region[country][1][i]+'">'+shopdata.region[country][0][i]+'</option>');
    }
    $('.search_form').find('input[name=sd_zipcode]').val(shopdata.region[country][1][0]);
}

// 一進入頁面要跑
function setCountryRegion(){

    // 動態新增縣市的下拉選單
    for(var i=0;i<shopdata.countries.length;i++){
        $('.sd_countries select').append('<option>'+shopdata.countries[i]+'</option>');
    }

    // 如果有查詢條件，將縣市跟區域選到條件的值
    if($('.search_form').find('input[name=sd_zipcode]').val() != 0){
        var country = '';
        var region = '';
        var zipcode = $('.search_form').find('input[name=sd_zipcode]').val();
        for(var i=0;i<shopdata.countries.length;i++){
            for(var j=0;j<shopdata.region[shopdata.countries[i]][1].length;j++){
                if(shopdata.region[shopdata.countries[i]][1][j] == zipcode){
                    country = shopdata.countries[i];
                    region = shopdata.region[shopdata.countries[i]][0][j];
                }
            }
        }
        // 選擇搜尋條件的縣市
        $('.sd_countries select option').each(function(){
            if($(this).text() == country){
                $(this).prop('selected',true);
            }
        });
        // 動態新增區域的下拉選單
        for(i=0;i<shopdata.region[country][0].length;i++){
            $('.sd_region select').append('<option value="'+shopdata.region[country][1][i]+'">'+shopdata.region[country][0][i]+'</option>');
        }
        // 選擇搜尋條件的區域
        $('.sd_region select option').each(function(){
            if($(this).text() == region){
                $(this).prop('selected',true);
            }
        });
    }else{
        // 動態新增區域的下拉選單
        var country = '';
        $('.sd_countries select option').each(function(){
            if($(this).prop('selected')){
                country = $(this).text();
            }
        });
        for(i=0;i<shopdata.region[country][0].length;i++){
            $('.sd_region select').append('<option value="'+shopdata.region[country][1][i]+'">'+shopdata.region[country][0][i]+'</option>');
        }
    }

}

// 設置金流協議狀態按鈕
$('.sdl_payment').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能設置一家汽車特店！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.sdmr_body').fadeIn(400);
            $('.sdmr_body .btn_no').on('click',function(){
                $('.sdmr_body').fadeOut(400);
            })

            $('.sdmr_body .btn_yes').on('click',function(){
                $('.sdmr_body').fadeOut(400);
                var reason = $('.sdmr_body textarea').val();
                var sd_id = '';
                var sd_paymentflowagreement = '';

                sd_paymentflowagreement = $('.panel_form form.select_case').find("input[name=sd_paymentflowagreement]").val();
                if(sd_paymentflowagreement == 0 || sd_paymentflowagreement == 2){
                    sd_paymentflowagreement = 1;
                }else{
                    sd_paymentflowagreement = 2;
                }
                sd_id = $('.panel_form form.select_case').find("input[name=sd_id]").val();

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: '/shop/shopdata/modify',
                    type:'POST',
                    cache:false,
                    datatype:'json',
                    data: {_token: token,sd_id: sd_id,sd_paymentflowagreement:sd_paymentflowagreement,sdmr_modifyreason:reason,modify_type:6},
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
        }
    } else {
        setTipBox('請選擇任何一家汽車特店');
    }
})


// 設置metaTag的按鈕
$('.sdl_metatag').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能設置一家汽車特店！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.metatag_body').fadeIn(400);

            $('.metatag_body .btn_no').on('click',function(){
                $('.metatag_body').fadeOut(400);
                $('.metatag_body textarea').val('');
            })

            $('.metatag_body .btn_yes').on('click',function(){
                $('.metatag_body').fadeOut(400);
                var sd_seo_keywords = $('.metatag_body textarea[name=sd_seo_keywords]').val();
                var sd_seo_description = $('.metatag_body textarea[name=sd_seo_description]').val();
                var sd_seo_title = $('.metatag_body textarea[name=sd_seo_title]').val();
                if(sd_seo_description.length > 125){
                    setTipBox('特店描述字數限制125個字！');
                    $('.metatag_body textarea').val('');
                }else if(sd_seo_keywords.length > 125){
                    setTipBox('關鍵字字數限制125個字！');
                    $('.metatag_body textarea').val('');
                }else if(sd_seo_title.length > 50){
                    setTipBox('標題字數限制50個字！');
                    $('.metatag_body textarea').val('');
                }else{
                    var sd_id = '';
                    sd_id = $('.panel_form form.select_case').find("input[name=sd_id]").val();

                    var token = $("input[name='_token']").val();
                    $.ajax({
                        url: '/shop/shopdata/modify',
                        type:'POST',
                        cache:false,
                        datatype:'json',
                        data: {_token: token,sd_id: sd_id,sd_seo_keywords:sd_seo_keywords,sd_seo_description:sd_seo_description,sd_seo_title:sd_seo_title,modify_type:5},
                        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                        success: function(data){
                            $('.prompt_body_admin h2').text(data);
                            $('.prompt_body_admin').fadeIn(400);
                        },
                        error: function(){
                            console.log('error');
                        }
                    })
                }
            })
        }
    } else {
        setTipBox('請選擇任何一家汽車特店！');
    }
})

// 詳情的按鈕
$('.sdl_detail').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能查看一家汽車特店的詳情！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.panel_form form.select_case').submit();
        }
    }else{
        setTipBox('請選擇任何一家汽車特店！');
    }
});

// 設置特店代號的按鈕
$('.sdl_salescode').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能設置一家汽車特店！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.sd_body input[name=sd_salescode]').val($('.select_case').find('input[name=sd_salescode]').val());
            $('.sd_body input[name=sd_salesbind]').val($('.select_case').find('input[name=sd_salesbind]').val());

            $('.sd_body').fadeIn(400);

            $('.sd_body .btn_no').on('click',function(){
                $('.sd_body').fadeOut(400);
                $('.sd_body input').val('');
            })

            $('.sd_body .btn_yes').on('click',function(){
                $('.sd_body').fadeOut(400);
                var sd_salescode = $('.sd_body input[name=sd_salescode]').val();
                var sd_salesbind = $('.sd_body input[name=sd_salesbind]').val();
                if(sd_salescode.length != 7){
                    setTipBox('辨識短碼必須為7碼，英數夾雜！');
                    $('.sd_body input[name=sd_salescode]').val('');
                }else if(sd_salesbind.length != 7){
                    setTipBox('業務代碼必須為7碼，英數夾雜！');
                    $('.sd_body input[name=sd_salescode]').val('');
                }else{
                    if(sd_salescode == $('.select_case').find('input[name=sd_salescode]').val()){
                        sd_salescode = '';
                    }
                    if(sd_salesbind == $('.select_case').find('input[name=sd_salesbind]').val()){
                        sd_salesbind = '';
                    }
                    var sd_id = '';
                    sd_id = $('.panel_form form.select_case').find("input[name=sd_id]").val();

                    var token = $("input[name='_token']").val();
                    $.ajax({
                        url: '/shop/shopdata/modify',
                        type:'POST',
                        cache:false,
                        datatype:'json',
                        data: {_token: token,sd_id: sd_id,sd_salesbind:sd_salesbind,sd_salescode:sd_salescode,modify_type:4},
                        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                        success: function(data){
                            $('.prompt_body_admin h2').text(data);
                            $('.prompt_body_admin').fadeIn(400);
                        },
                        error: function(){
                            console.log('error');
                        }
                    })
                }
            })
        }
    } else {
        setTipBox('請選擇任何一家汽車特店！');
    }
})

// 搜尋的按鈕
$('.sdl_search').on('click',function(){
    //將頁碼歸0回到第一頁
    $('.search_form').find('input[name=skip_page]').val(0);
    $('.search_form').submit();
});

// 綁定解綁的按鈕
$('.sdl_havebind').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能設置一家汽車特店！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.sdmr_body').fadeIn(400);

            $('.sdmr_body .btn_no').on('click',function(){
                $('.sdmr_body').fadeOut(400);
                $('.sdmr_body textarea').val('');
            })

            $('.sdmr_body .btn_yes').on('click',function(){
                $('.sdmr_body').fadeOut(400);
                var reason = $('.sdmr_body textarea').val();
                var sd_id = '';
                sd_id = $('.panel_form form.select_case').find("input[name=sd_id]").val();
                var have_bind = $('.panel_form form.select_case').find("input[name=sd_havebind]").val();
                if(have_bind == 0){
                    have_bind = 1;
                }else{
                    have_bind = 0;
                }
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: '/shop/shopdata/modify',
                    type:'POST',
                    cache:false,
                    datatype:'json',
                    data: {_token: token,sd_id: sd_id,sdmr_modifyreason:reason,have_bind:have_bind,modify_type:3},
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
        }
    } else {
        setTipBox('請選擇任何一家汽車特店！');
    }
})

// 停用啟用的按鈕
$('.sdl_status').on('click',function(){
	if ($('.panel_form form').hasClass('select_case')) {
        $('.sdmr_body').fadeIn(400);

        $('.sdmr_body .btn_no').on('click',function(){
            $('.sdmr_body').fadeOut(400);
            $('.sdmr_body textarea').val('');
        })

        $('.sdmr_body .btn_yes').on('click',function(){
            $('.sdmr_body').fadeOut(400);
            var reason = $('.sdmr_body textarea').val();
            var sd_id = [];
            var status = '';
            $('.panel_form form').each(function(){
                if($(this).hasClass('select_case')){
                    var sd_id_val = $(this).find("input[name=sd_id]").val();
                    sd_id.push(sd_id_val);

                }
            });
            var status_type = $('.panel_form form.select_case').find("input[name=sd_activestatus]").val();
            if(status_type == 0){
                status = 1;
            }else{
                status = 0;
            }
            var token = $("input[name='_token']").val();
            $.ajax({
                url: '/shop/shopdata/modify',
                type:'POST',
                cache:false,
                datatype:'json',
                data: {_token: token,sd_id: sd_id,sdmr_modifyreason:reason,status:status,modify_type:1},
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
        setTipBox('請選擇任何一家汽車特店！');
    }
})

// 刪除的按鈕
$('.sdl_flag').on('click',function(){
    if ($('.panel_form form').hasClass('select_case')) {
        if($('.panel_form form.select_case').length > 1){
            setTipBox('一次只能刪除一家汽車特店！');
            $('.panel_form form').removeClass('select_case');
        }else{
            $('.sdmr_body').fadeIn(400);
            $('.sdmr_body .btn_no').on('click',function(){
                $('.sdmr_body').fadeOut(400);
            })

            $('.sdmr_body .btn_yes').on('click',function(){
                $('.sdmr_body').fadeOut(400);
                var reason = $('.sdmr_body textarea').val();
                var sd_id = '';
                sd_id = $('.panel_form form.select_case').find("input[name=sd_id]").val();

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: '/shop/shopdata/modify',
                    type:'POST',
                    cache:false,
                    datatype:'json',
                    data: {_token: token,sd_id: sd_id,sdmr_modifyreason:reason,modify_type:2},
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
        }
    } else {
        setTipBox('請選擇任何一家汽車特店');
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
    window.location="/shop/shopdata-list"+document.location.search;
})

$('.prompt_body_admin .btn_no').on('click',function(){
	$('.prompt_body_admin').fadeOut(400);
    window.location="/shop/shopdata-list"+document.location.search;
})

$('.prompt_body .btn_yes').on('click',function(){
	$('.prompt_body').fadeOut(400);
	$('.prompt_body').remove();
})



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



});