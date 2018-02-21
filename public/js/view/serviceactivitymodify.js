$(function(){
//////////////////// 需初始化的功能 ////////////////////
$('#pai_startdate').datetimepicker({
    format: 'yyyy-mm-dd',//format: 'yyyy-mm-dd hh:ii:ss',
    language: 'zh-TW',
    weekStart: 7,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 3,
    minView: 2,
    forceParse: 0
});
$('#pai_enddate').datetimepicker({
    format: 'yyyy-mm-dd',//format: 'yyyy-mm-dd hh:ii:ss',
    language: 'zh-TW',
    weekStart: 7,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 3,
    minView: 2,
    forceParse: 0
});
// 頁面載入完畢以後要做的事情
window.onload = function(){
    activitySetContentUpDown();
    advanceSetContentUpDown();
}


////////// 如果有servicedata，需要設定的欄位 ////////////////
if($('input[name=pai_gifttype]').val() != ''){
    var gift_type = $('input[name=pai_gifttype]').val();
    $('.gift_type').each(function(){
        if($(this).val() == gift_type){
            $(this).prop('checked',true);
        }
    })
}
$('.pai_gifttype :radio').change(function() {
    var gift_type = $(this).val();
    $('input[name=pai_gifttype').val(gift_type);
});
if($('input[name=pai_poststatus]').val() != ''){
    var post_status = $('input[name=pai_poststatus]').val();
    $('.post_status').each(function(){
        if($(this).val() == post_status){
            $(this).prop('checked',true);
        }
    })
}
$('.pai_poststatus :radio').change(function() {
    var post_status = $(this).val();
    $('input[name=pai_poststatus').val(post_status);
});
if($('input[name=pa_id]').val() == ''){
    $('input[name=pa_id]').val($('.pai_shortcode select').find('option:selected').val());
}else{
    $('.pai_shortcode select option').each(function(){
        if($('input[name=pa_id]').val() == $(this).val()){
            $(this).prop('selected',true);
        }
    })
}

$('.pai_shortcode select').change(function(){
    var option = $(this).find('option:selected').val();
    $('input[name=pa_id]').val(option);
    console.log(option);
})
//////////////////////////////////////////////////////////




/////////////////////// 按鈕設定 //////////////////////////////////
// 提示框按鈕
$('.prompt_body_admin .btn_yes').on('click',function(){
    $('.prompt_body_admin').fadeOut(400);
    window.location="/service/announcement"
})
$('.prompt_body_admin .btn_no').on('click',function(){
    $('.prompt_body_admin').fadeOut(400);
    window.location="/service/announcement"
})
// 存檔按鈕
$('.pai_save').on('click',function(){
    var isFormValid = checkForm();
    if(isFormValid){
        var sd = (Date.parse( $('.service_form').find('input[name=pai_startdate]').val() ) ).valueOf();
        var ed = (Date.parse( $('.service_form').find('input[name=pai_enddate]').val() ) ).valueOf();
        if(sd > ed){
            setTipBox('起始日不能大於結束日');
            isFormValid = false;
        }
        if(isFormValid){
            $('.service_form').submit();
        }
    }
})
// 換圖按鈕
$('.mainpic_change').on('click',function(){
    var text = '<div class="img_body_admin tip_box">'+
                    '<div class="img_box_admin panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h3>選擇圖片</h3>'+
                        '</div>'+
                        $('.pa_mainpic').html()+
                        '<button class="delete-btn">刪除</button>'+
                    '</div>'+
                '</div>';
    $('body').append(text);
    $('.img_body_admin .mainpic_change').remove();
    $('.img_body_admin img').css("width","100%");
    $('.tip_box').fadeIn(400);
    $('.delete-btn').on('click',function(){
        $('.tip_box').fadeOut(400);
        $('.tip_box').remove();
        $('.pai_mainpic').find('img').remove();
        $('input[name=pai_mainpic]').val('');
        $('.change').removeClass('mainpic_change').addClass('btn_select').text('選圖');
        $('.btn_select').on('click',function(){
            var modify_type = $('.service_form').find('input[name=modifytype]').val();
            var text = '<div class="img_body_admin tip_box">'+
                            '<div class="img_box_admin panel-primary">'+
                                '<div class="panel-heading">'+
                                    '<h3>選擇圖片</h3>'+
                                '</div>'+
                                '<form method="post" id="myForm" action="upload?pai_id='+$('.service_form').find('input[name=pai_id]').val()+'&folder=serviceannouncement&type=sub&position='+modify_type+'" enctype="multipart/form-data">'+
                                    '<input type="hidden" name="_token" value="'+$('html head').find("meta[name=csrf-token]").prop('content')+'">'+
                                    '<input type="file" id="file" name="file" class="form-control check_unit" value="">'+
                                    '<input name="pai_mainpic" type="text" class="set-img-block" onclick="this.form.file.click();">'+
                                    '<div id="result"></div>'+
                                    '<button class="upload-btn" type="button">上傳</button>'+
                                '</form>'+
                                '<button class="crop-btn">剪裁</button>'+
                                '<button class="delete-btn">刪除</button>'
                                // '<div>'+
                                //     '<button type="button" class="btn btn-success cancel">取消</button>'+
                                // '</div>'+
                            '</div>'+
                        '</div>';
            $('body').append(text);
            $('.delete-btn').css('display', 'none');
            $('.upload-btn').css('display', 'none');
            $('.crop-btn').css('display', 'none');
            $('.set-img-block').css('display', 'none');
            $(document).mouseup(function(e){
                var _con1 = $('.img_box_admin.panel-primary');
                if(!_con1.is(e.target) && _con1.has(e.target).length === 0){
                    $('.tip_box').fadeOut(400,function(){
                        $('.img_body_admin.tip_box').remove();
                        $(document).unbind('mouseup');
                    });
                }
            });
            $('.tip_box').fadeIn(400);
            $('.upload-btn').on('click',function(){
                if($('input[name=file]').val()){
                    getServiceData();
                    $('#myForm').submit();
                }
            })
            $('.prompt_body_admin .cancel').on('click',function(){
                $('.tip_box').fadeOut(400);
                $('.tip_box').remove();
            })

            document.getElementById("file").addEventListener('change', readFile, false);

            // $('input[name=pai_mainpic]').change(function(){
            //     readFile();
            // });
        })
    })
})

// 選圖按鈕
$('.btn_select').on('click',function(){
    var modify_type = $('.service_form').find('input[name=modifytype]').val();
    var text = '<div class="img_body_admin tip_box">'+
                    '<div class="img_box_admin panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h3>選擇圖片</h3>'+
                        '</div>'+
                        '<form method="post" id="myForm" action="upload?pai_id='+$('.service_form').find('input[name=pai_id]').val()+'&folder=serviceannouncement&type=sub&position='+modify_type+'" enctype="multipart/form-data">'+
                            '<input type="hidden" name="_token" value="'+$('html head').find("meta[name=csrf-token]").prop('content')+'">'+
                            '<input type="file" id="file" name="file" class="form-control check_unit" value="">'+
                            '<input name="pai_mainpic" type="text" class="set-img-block" onclick="this.form.file.click();">'+
                            '<div id="result"></div>'+
                            '<button class="upload-btn" type="button">上傳</button>'+
                        '</form>'+
                        '<button class="crop-btn">剪裁</button>'+
                        '<button class="delete-btn">刪除</button>'
                        // '<div>'+
                        //     '<button type="button" class="btn btn-success cancel">取消</button>'+
                        // '</div>'+
                    '</div>'+
                '</div>';
    $('body').append(text);
    $('.delete-btn').css('display', 'none');
    $('.upload-btn').css('display', 'none');
    $('.crop-btn').css('display', 'none');
    $('.set-img-block').css('display', 'none');
    $(document).mouseup(function(e){
        var _con1 = $('.img_box_admin.panel-primary');
        if(!_con1.is(e.target) && _con1.has(e.target).length === 0){
            $('.tip_box').fadeOut(400,function(){
                $('.img_body_admin.tip_box').remove();
                $(document).unbind('mouseup');
            });
        }
    });
    $('.tip_box').fadeIn(400);
    $('.upload-btn').on('click',function(){
        if($('input[name=file]').val()){
            getServiceData();
            $('#myForm').submit();
        }
    })
    $('.prompt_body_admin .cancel').on('click',function(){
        $('.tip_box').fadeOut(400);
        $('.tip_box').remove();
    })

    document.getElementById("file").addEventListener('change', readFile, false);

    // $('input[name=pai_mainpic]').change(function(){
    //     readFile();
    // });
})

$('.activity_add_img').on('click',function(){
    var modify_type = $('.service_form').find('input[name=modifytype]').val();
    var text = '<div class="img_body_admin tip_box">'+
                    '<div class="img_box_admin panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h3>選擇圖片</h3>'+
                        '</div>'+
                        '<form method="post" id="my_Form" action="upload?pai_id='+$('.service_form').find('input[name=pai_id]').val()+'&folder=serviceactivity&type=sub&position='+modify_type+'" enctype="multipart/form-data">'+
                            '<input type="hidden" name="_token" value="'+$('html head').find("meta[name=csrf-token]").prop('content')+'">'+
                            '<input type="file" id="file" name="file" class="form-control check_unit" value="">'+
                            '<input name="pai_activepics" type="text" class="set-img-block" onclick="this.form.file.click();">'+
                            '<div id="result"></div>'+
                            '<button class="upload-btn" type="button">上傳</button>'+
                        '</form>'+
                        '<button class="crop-btn">剪裁</button>'+
                    '</div>'+
                '</div>';
    $('body').append(text);
    $('.delete-btn').css('display', 'none');
    $('.upload-btn').css('display', 'none');
    $('.crop-btn').css('display', 'none');
    $('.set-img-block').css('display', 'none');
    $(document).mouseup(function(e){
        var _con1 = $('.img_box_admin.panel-primary');
        if(!_con1.is(e.target) && _con1.has(e.target).length === 0){
            $('.tip_box').fadeOut(400,function(){
                $('.img_body_admin.tip_box').remove();
                $(document).unbind('mouseup')
            });
        }
    });
    $('.tip_box').fadeIn(400);
    $('.upload-btn').on('click',function(){
        if($('input[name=file]').val()){
            getServiceData();
            $('#my_Form').submit();
        }
    })
    $('.prompt_body_admin .cancel').on('click',function(){
        $('.tip_box').fadeOut(400);
        $('.tip_box').remove();
    })

    document.getElementById("file").addEventListener('change', readFile, false);
})

$('.add_img').on('click',function(){
    var modify_type = $('.service_form').find('input[name=modifytype]').val();
    var text = '<div class="img_body_admin tip_box">'+
                    '<div class="img_box_admin panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h3>選擇圖片</h3>'+
                        '</div>'+
                        '<form method="post" id="my_Form" action="upload?pai_id='+$('.service_form').find('input[name=pai_id]').val()+'&folder=serviceannouncement&type=sub&position='+modify_type+'" enctype="multipart/form-data">'+
                            '<input type="hidden" name="_token" value="'+$('html head').find("meta[name=csrf-token]").prop('content')+'">'+
                            '<input type="file" id="file" name="file" class="form-control check_unit" value="">'+
                            '<input name="pai_advancedescribe" type="text" class="set-img-block" onclick="this.form.file.click();">'+
                            '<div id="result"></div>'+
                            '<button class="upload-btn" type="button">上傳</button>'+
                        '</form>'+
                        '<button class="crop-btn">剪裁</button>'+
                    '</div>'+
                '</div>';
    $('body').append(text);
    $('.delete-btn').css('display', 'none');
    $('.upload-btn').css('display', 'none');
    $('.crop-btn').css('display', 'none');
    $('.set-img-block').css('display', 'none');
    $(document).mouseup(function(e){
        var _con1 = $('.img_box_admin.panel-primary');
        if(!_con1.is(e.target) && _con1.has(e.target).length === 0){
            $('.tip_box').fadeOut(400,function(){
                $('.img_body_admin.tip_box').remove();
                $(document).unbind('mouseup')
            });
        }
    });
    $('.tip_box').fadeIn(400);
    $('.upload-btn').on('click',function(){
        if($('input[name=file]').val()){
            getServiceData();
            $('#my_Form').submit();
        }
    })
    $('.prompt_body_admin .cancel').on('click',function(){
        $('.tip_box').fadeOut(400);
        $('.tip_box').remove();
    })

    document.getElementById("file").addEventListener('change', readFile, false);
})

$('.add_text').on('click',function(){
    var text = '<div class="prompt_body_admin tip_box">'+
                    '<div class="prompt_box_admin panel-primary">'+
                        '<div class="panel-heading">'+
                            '<h3>文字內容</h3>'+
                        '</div>'+
                        '<div class="panel-body">'+
                            '<textarea class="addText"></textarea>'+
                        '</div>'+
                        '<button class="send-text-btn">確定</button>'+
                        // '<div>'+
                        //     '<button type="button" class="btn btn-success cancel">取消</button>'+
                        // '</div>'+
                    '</div>'+
                '</div>';
    $('body').append(text);
    $('.tip_box').fadeIn(400);
    $('.send-text-btn').on('click',function(){
        var text = $('.addText').val();
        var text_html = '<div class="content_box">'+
                            '<div class="content_btn">'+
                                '<i class="fa fa-2x fa-chevron-up content_up" aria-hidden="true"></i>'+
                                '<i class="fa fa-2x fa-chevron-down content_down" aria-hidden="true"></i>'+
                            '</div>'+
                            '<div class="context">'+text+'</div>'+
                            '<button type="button" class="content_delete">刪除</button>'+
                        '</div>';
        $('.content_block').append(text_html);
        $('.tip_box').fadeOut(400);
        $('.tip_box').remove();
        if($('input[name=pai_advancedescribe]').val() != ''){
            var pai_advancedescribe = JSON.parse($('input[name=pai_advancedescribe]').val());
            pai_advancedescribe.push({'content_text':text});
            $('input[name=pai_advancedescribe]').val(JSON.stringify(pai_advancedescribe));
        }else{
            pai_advancedescribe = [];
            pai_advancedescribe.push({'content_text':text});
            $('input[name=pai_advancedescribe]').val(JSON.stringify(pai_advancedescribe));
        }
        $(document).unbind('mouseup');
        advanceSetContentUpDown();
    })
    $(document).mouseup(function(e){
        var _con1 = $('.prompt_box_admin.panel-primary');
        if(!_con1.is(e.target) && _con1.has(e.target).length === 0){
            $('.tip_box').fadeOut(400,function(){
                $('.prompt_body_admin.tip_box').remove();
                $(document).unbind('mouseup');
            });
        }
    });
})




///////////////////////////////////// 工具區 /////////////////////////////////////

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

/**
 * 選擇檔案圖片時瀏覽圖片
 */
readFile = function() {
    var img_width = 560;
    var img_height = 350;
    var file = this.files[0];
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(e) {
        document.getElementById("result").innerHTML = '<img id="pre-img" class="pre-img" src="' + this.result + '" alt="" width="'+img_width+'" />';

        //剪裁圖片設置
        var uploadCrop = $('.pre-img').croppie({
            enableExif: true,
            viewport: { //剪裁大小
                width: img_width,
                height: img_height
            },
            boundary: { //背景可見大小
                width: img_width,
                height: img_height
            }
        });
        $('.delete-btn').css('display', 'none');
        $('.upload-btn').css('display', 'none');
        $('.crop-btn').css('display', 'inline-block');
        $('.crop-btn').click(function() {
            uploadCrop.croppie('result', {
                type: 'base64', //圖片輸出方式
                format: 'jpeg', //圖片格式
                quality: 0.8 //圖片質量
            }).then(function(html) {
                result.innerHTML = '<img id="pre-img" class="pre-img" src="' + html + '" alt="" height="' + img_height + '" width="' + img_width + '" />';
                $('.set-img-block').val(html);
                $('.crop-btn').css('display', 'none');
                $('.upload-btn').css('display', 'inline-block');
            });
        });

    }
};

// 檢查必填欄位是否填寫
checkForm = function(){
    var isFormValid = true;
    $('.check_unit').each(function(){
        var $this = $(this);
        if($.trim($this.val()).length === 0){
            $this.tooltip('show');
            isFormValid = false;
        }
    })
    if($('input[name=pai_mainpic]').val() == ''){
        $('.pai_mainpic').tooltip('show');
        isFormValid = false;
    }
    if($('input[name=pai_activepics]').val() == ''){
        $('.activity_add_img').tooltip('show');
        isFormValid = false;
    }
    if(($('input[name=pai_shortcode]').val()).length != 3){
        $('.pai_shortcode').tooltip('show');
        isFormValid = false;
    }
    return isFormValid;
}

// 將資料臨時存在cookie
getServiceData = function(){
    var save_data = {};
    save_data.pa_id = $('.service_form').find('input[name=pa_id]').val();
    save_data.pai_id = $('.service_form').find('input[name=pai_id]').val();
    save_data.pai_shortcode = $('.service_form').find('input[name=pai_shortcode]').val();
    save_data.pai_title = $('.service_form').find('input[name=pai_title]').val();
    save_data.pai_mainpic = $('.service_form').find('input[name=pai_mainpic]').val();
    save_data.pai_fulldescript = $('.service_form').find('input[name=pai_fulldescript]').val();
    save_data.pai_gifttype = $('.service_form').find('input[name=pai_gifttype]').val();
    save_data.pai_giftamount = $('.service_form').find('input[name=pai_giftamount]').val();
    save_data.pai_startdate = $('.service_form').find('input[name=pai_startdate]').val();
    save_data.pai_enddate = $('.service_form').find('input[name=pai_enddate]').val();
    save_data.pai_poststatus = $('.service_form').find('input[name=pai_poststatus]').val();
    save_data.pai_condition = $('.service_form').find('input[name=pai_condition]').val();
    save_data.pai_eventtarget_url = $('.service_form').find('input[name=pai_eventtarget_url]').val();
    save_data.pai_giftcontent = $('.service_form').find('input[name=pai_giftcontent]').val();
    save_data.pai_advancedescribe = $('.service_form').find('input[name=pai_advancedescribe]').val();
    save_data.pai_activepics = $('.service_form').find('input[name=pai_activepics]').val();
    Cookies.set('pai_servicedata',JSON.stringify(save_data));
}

activitySetContentUpDown = function(){
    $('.activity_content_up').on('click',function(){
        var hhh = $(this).parents('.activity_content_box').html();
        var qqq = $(this).parents('.activity_content_box').index();
        if($('.activity_content_box').length > 1){
            if(qqq > 0){
                var aaa = $('.activity_content_box').eq(qqq-1).html();
                $('.activity_content_box').eq(qqq-1).html(hhh);
                $(this).parents('.activity_content_box').html(aaa);

                if($('input[name=pai_activepics]').val() != ''){
                    var pai_activepics = JSON.parse($('input[name=pai_activepics]').val());
                    var bbb = pai_activepics[qqq];
                    var ccc = pai_activepics[qqq-1];
                    pai_activepics[qqq] = ccc;
                    pai_activepics[qqq-1] = bbb;
                    $('input[name=pai_activepics]').val(JSON.stringify(pai_activepics));
                }
                activitySetContentUpDown();
            }
        }
    })
    $('.activity_content_down').on('click',function(){
        var hhh = $(this).parents('.activity_content_box').html();
        var qqq = $(this).parents('.activity_content_box').index();

        if(qqq+1 != $('.activity_content_box').length){
            var aaa = $('.activity_content_box').eq(qqq+1).html();
            $('.activity_content_box').eq(qqq+1).html(hhh);
            $(this).parents('.activity_content_box').html(aaa);

            if($('input[name=pai_activepics]').val() != ''){
                var pai_activepics = JSON.parse($('input[name=pai_activepics]').val());
                var bbb = pai_activepics[qqq];
                var ccc = pai_activepics[qqq+1];
                pai_activepics[qqq] = ccc;
                pai_activepics[qqq+1] = bbb;
                $('input[name=pai_activepics]').val(JSON.stringify(pai_activepics));
            }
            activitySetContentUpDown();
        }
    })
    $('.activity_content_delete').on('click',function(){
        var qqq = $(this).parents('.activity_content_box').index();
        $(this).parents('.activity_content_box').remove();
        if($('input[name=pai_activepics]').val() != ''){
            var pai_activepics = JSON.parse($('input[name=pai_activepics]').val());
            var array = [];
            for(var i in pai_activepics){
                if(i != qqq){
                    array.push(pai_activepics[i])
                }
            }
            $('input[name=pai_activepics]').val(JSON.stringify(array));
        }
    })
}

advanceSetContentUpDown = function(){
    $('.content_up').on('click',function(){
        var hhh = $(this).parents('.content_box').html();
        var qqq = $(this).parents('.content_box').index();
        if($('.content_box').length > 1){
            if(qqq > 0){
                var aaa = $('.content_box').eq(qqq-1).html();
                $('.content_box').eq(qqq-1).html(hhh);
                $(this).parents('.content_box').html(aaa);

                if($('input[name=pai_advancedescribe]').val() != ''){
                    var pai_advancedescribe = JSON.parse($('input[name=pai_advancedescribe]').val());
                    var bbb = pai_advancedescribe[qqq];
                    var ccc = pai_advancedescribe[qqq-1];
                    pai_advancedescribe[qqq] = ccc;
                    pai_advancedescribe[qqq-1] = bbb;
                    $('input[name=pai_advancedescribe]').val(JSON.stringify(pai_advancedescribe));
                }
                advanceSetContentUpDown();
            }
        }
    })
    $('.content_down').on('click',function(){
        var hhh = $(this).parents('.content_box').html();
        var qqq = $(this).parents('.content_box').index();

        if(qqq+1 != $('.content_box').length){
            var aaa = $('.content_box').eq(qqq+1).html();
            $('.content_box').eq(qqq+1).html(hhh);
            $(this).parents('.content_box').html(aaa);

            if($('input[name=pai_advancedescribe]').val() != ''){
                var pai_advancedescribe = JSON.parse($('input[name=pai_advancedescribe]').val());
                var bbb = pai_advancedescribe[qqq];
                var ccc = pai_advancedescribe[qqq+1];
                pai_advancedescribe[qqq] = ccc;
                pai_advancedescribe[qqq+1] = bbb;
                $('input[name=pai_advancedescribe]').val(JSON.stringify(pai_advancedescribe));
            }
            advanceSetContentUpDown();
        }
    })
    $('.content_delete').on('click',function(){
        var qqq = $(this).parents('.content_box').index();
        $(this).parents('.content_box').remove();
        if($('input[name=pai_advancedescribe]').val() != ''){
            var pai_advancedescribe = JSON.parse($('input[name=pai_advancedescribe]').val());
            var array = [];
            for(var i in pai_advancedescribe){
                if(i != qqq){
                    array.push(pai_advancedescribe[i])
                }
            }
            $('input[name=pai_advancedescribe]').val(JSON.stringify(array));
        }
    })
}

})