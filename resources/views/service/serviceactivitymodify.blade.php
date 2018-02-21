@extends('layouts/layout')
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/serviceactivitymodify.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-10 col-sm-12 col-md-offset-1 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1>
        	@if($searchdata['modifytype'] == 'modify')
				修改活動項目
			@elseif ($searchdata['modifytype'] == 'create')
				新增活動項目
			@endif
        </h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<button type="button" class="btn btn-primary pai_save pull-right">存檔</button>
			<a href="/service/activity" class="btn btn-info pull-right pai_return">返回</a>
		</div>
		<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			@if($searchdata['modifytype'] == 'create')
				<form action="/service/activity/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal service_form" method="post" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<input type="hidden" name="modifytype" value="{{$searchdata['modifytype']}}">
					<input type="hidden" name="pai_id" value="{{$pai_id}}">
					@if(isset($servicedata))
						<input type="hidden" name="pai_mainpic" value="{{ $servicedata['pai_mainpic'] }}">
						<input type="hidden" name="pa_id" value="{{ $servicedata['pa_id'] }}">
						<input type="hidden" name="pai_gifttype" value="{{ $servicedata['pai_gifttype'] }}">
						<input type="hidden" name="pai_poststatus" value="{{ $servicedata['pai_poststatus'] }}">
						@if(isset($servicedata['pai_advancedescribe']))
							<input type="hidden" name="pai_advancedescribe" value="{{ json_encode($servicedata['pai_advancedescribe']) }}">
						@else
							<input type="hidden" name="pai_advancedescribe" value="">
						@endif
						@if(isset($servicedata['pai_activepics']))
							<input type="hidden" name="pai_activepics" value="{{ json_encode($servicedata['pai_activepics']) }}">
						@else
							<input type="hidden" name="pai_activepics" value="">
						@endif
					@else
						<input type="hidden" name="pai_mainpic" value="">
						<input type="hidden" name="pa_id" value="">
						<input type="hidden" name="pai_gifttype" value="1">
						<input type="hidden" name="pai_poststatus" value="0">
						<input type="hidden" name="pai_advancedescribe" value="">
						<input type="hidden" name="pai_activepics" value="">
					@endif
					<div class="form-group">
						<label for="pai_shortcode" class="col-md-4 col-sm-4 col-xs-4 control-label">綁定活動公告</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_shortcode">
							<select class="form-control">
								@foreach ($announcementdata as $data)
								<option value="{{$data['pa_id']}}">{{$data['pa_title']}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_shortcode" class="col-md-4 col-sm-4 col-xs-4 control-label">前墜序號</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit pai_shortcode" name="pai_shortcode" data-toggle="tooltip" title="序號不能為空，字數限制3字" value="{{ $servicedata['pai_shortcode'] }}">
							@else
								<input type="text" class="form-control check_unit pai_shortcode" name="pai_shortcode" data-toggle="tooltip" title="序號不能為空，字數限制3字" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_mainpic" class="col-md-4 col-sm-4 col-xs-4 control-label">活動封面</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<img alt="{{ $servicedata['pai_mainpic'] }}" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $servicedata['pai_mainpic'] }}" width="50%">
								<button type="button" class="btn_select pai_mainpic" data-toggle="tooltip" title="請設定封面">換圖</button>
							@else
								<button type="button" class="btn_select pai_mainpic" data-toggle="tooltip" title="請設定封面">選圖</button>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_title" class="col-md-4 col-sm-4 col-xs-4 control-label">活動標題</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_title" data-toggle="tooltip" title="標題不能為空" value="{{ $servicedata['pai_title'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_title" data-toggle="tooltip" title="標題不能為空" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_fulldescript" class="col-md-4 col-sm-4 col-xs-4 control-label">活動詳細說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="{{ $servicedata['pai_fulldescript'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_activepics" class="col-md-4 col-sm-4 col-xs-4 control-label">活動圖片</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_activepics">
							<button type="button" class="activity_add_img">添加圖片</button>
							<div class="activity_content_block">
							@if(isset($servicedata))
								@if(isset($servicedata['pai_activepics']))
									@if(is_array($servicedata['pai_activepics']))
										@foreach ($servicedata['pai_activepics'] as $val)
										<div class="activity_content_box">
											<div class="activity_content_btn">
												<i class="fa fa-2x fa-chevron-up activity_content_up" aria-hidden="true"></i>
												<i class="fa fa-2x fa-chevron-down activity_content_down" aria-hidden="true"></i>
											</div>
	                    @if(isset($val['content_img']) && $val['content_img'] != '')
	                        <img alt="{{ $val['content_img'] }}" class="" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $val['content_img'] }}" style="width:50%; ">
	                    @endif
	                    <button type="button" class="activity_content_delete">刪除</button>
		                </div>
		                @endforeach
		              @endif
	           		@endif
							@endif
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_gifttype" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵類別</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_gifttype">
							<div class="radio">
								<label>
								    <input type="radio" name="gift_type" class="gift_type" value="1">
								    抽獎卷
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="gift_type" class="gift_type" value="2">
								    禮卷
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="gift_type" class="gift_type" value="3">
								    購點
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_giftcontent" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵內容</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_giftcontent">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_giftcontent" data-toggle="tooltip" title="獎勵內容不能為空" name="pai_giftcontent" value="{{ $servicedata['pai_giftcontent'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_giftcontent" data-toggle="tooltip" title="獎勵內容不能為空" name="pai_giftcontent" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_giftamount" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵數額</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_giftamount">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_giftamount" data-toggle="tooltip" title="獎勵數額不能為空，請填入數字" name="pai_giftamount" value="{{ $servicedata['pai_giftamount'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_giftamount" data-toggle="tooltip" title="獎勵數額不能為空，請填入數字" name="pai_giftamount" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_startdate" class="col-md-4 col-sm-4 col-xs-4 control-label">開始時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pai_startdate" name="pai_startdate" value="{{ $servicedata['pai_startdate'] }}" data-toggle="tooltip" title="請選擇起始日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pai_startdate" name="pai_startdate" value="" data-toggle="tooltip" title="請選擇起始日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_enddate" class="col-md-4 col-sm-4 col-xs-4 control-label">結束時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pai_enddate" name="pai_enddate" value="{{ $servicedata['pai_enddate'] }}" data-toggle="tooltip" title="請選擇結束日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pai_enddate" name="pai_enddate" value="" data-toggle="tooltip" title="請選擇結束日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_poststatus" class="col-md-4 col-sm-4 col-xs-4 control-label">刊登狀態</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_poststatus">
							<div class="radio">
								<label class="radio-inline">
								    <input type="radio" name="post_status" class="post_status" value="0">
								   	停用
								</label>
								<label class="radio-inline">
								    <input type="radio" name="post_status" class="post_status" value="1">
								    啟用
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_condition" class="col-md-4 col-sm-4 col-xs-4 control-label">活動檢查內容</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_condition">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_condition" data-toggle="tooltip" title="記錄活動檢查條件對應functionname" name="pai_condition" value="{{ $servicedata['pai_condition'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_condition" data-toggle="tooltip" title="記錄活動檢查條件對應functionname" name="pai_condition" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_eventtarget_url" class="col-md-4 col-sm-4 col-xs-4 control-label">活動事件指向URL</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_eventtarget_url">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_eventtarget_url" data-toggle="tooltip" title="活動事件指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pai_eventtarget_url" value="{{ $servicedata['pai_eventtarget_url'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_eventtarget_url" data-toggle="tooltip" title="活動事件指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pai_eventtarget_url" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_advancedescribe" class="col-md-4 col-sm-4 col-xs-4 control-label">公告內容進階圖文說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_advancedescribe">
							<button type="button" class="add_img">添加圖片</button><button type="button" class="add_text">添加文字</button>
							<div class="content_block">
							@if(isset($servicedata))
								@if(isset($servicedata['pai_advancedescribe']))
								@if(is_array($servicedata['pai_advancedescribe']))
									@foreach ($servicedata['pai_advancedescribe'] as $val)
									<div class="content_box">
										<div class="content_btn">
											<i class="fa fa-2x fa-chevron-up content_up" aria-hidden="true"></i>
											<i class="fa fa-2x fa-chevron-down content_down" aria-hidden="true"></i>
										</div>
	                  @if(isset($val['content_text']) && $val['content_text'] != '')
	                  	<div class="context">{!!$val['content_text']!!}</div>
	                  @endif
                    @if(isset($val['content_img']) && $val['content_img'] != '')
                      <img alt="{{ $val['content_img'] }}" class="" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $val['content_img'] }}" style="width:50%; ">
                    @endif
	                  <button type="button" class="content_delete">刪除</button>
	                </div>
	                @endforeach
	              @endif
	              @endif
							@endif
							</div>
						</div>
					</div>
				</form>
			@elseif($searchdata['modifytype'] == 'modify')
				<form action="/service/activity/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal service_form" method="post" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<input type="hidden" name="modifytype" value="{{$searchdata['modifytype']}}">
					<input type="hidden" name="pai_id" value="{{$servicedata['pai_id']}}">
					@if(isset($servicedata))
						<input type="hidden" name="pai_mainpic" value="{{ $servicedata['pai_mainpic'] }}">
						<input type="hidden" name="pa_id" value="{{ $servicedata['pa_id'] }}">
						<input type="hidden" name="pai_gifttype" value="{{ $servicedata['pai_gifttype'] }}">
						<input type="hidden" name="pai_poststatus" value="{{ $servicedata['pai_poststatus'] }}">
						@if(isset($servicedata['pai_advancedescribe']))
							<input type="hidden" name="pai_advancedescribe" value="{{ json_encode($servicedata['pai_advancedescribe']) }}">
						@else
							<input type="hidden" name="pai_advancedescribe" value="">
						@endif
						@if(isset($servicedata['pai_activepics']))
							<input type="hidden" name="pai_activepics" value="{{ json_encode($servicedata['pai_activepics']) }}">
						@else
							<input type="hidden" name="pai_activepics" value="">
						@endif
					@else
						<input type="hidden" name="pai_mainpic" value="">
						<input type="hidden" name="pa_id" value="">
						<input type="hidden" name="pai_gifttype" value="1">
						<input type="hidden" name="pai_poststatus" value="0">
						<input type="hidden" name="pai_advancedescribe" value="">
						<input type="hidden" name="pai_activepics" value="">
					@endif
					<div class="form-group">
						<label for="pai_shortcode" class="col-md-4 col-sm-4 col-xs-4 control-label">綁定活動公告</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_shortcode">
							<select class="form-control">
								@foreach ($announcementdata as $data)
								<option value="{{$data['pa_id']}}">{{$data['pa_title']}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_shortcode" class="col-md-4 col-sm-4 col-xs-4 control-label">前墜序號</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit pai_shortcode" name="pai_shortcode" data-toggle="tooltip" title="序號不能為空，字數限制3字" value="{{ $servicedata['pai_shortcode'] }}">
							@else
								<input type="text" class="form-control check_unit pai_shortcode" name="pai_shortcode" data-toggle="tooltip" title="序號不能為空，字數限制3字" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_mainpic" class="col-md-4 col-sm-4 col-xs-4 control-label">活動封面</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<img alt="{{ $servicedata['pai_mainpic'] }}" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $servicedata['pai_mainpic'] }}" width="50%">
								<button type="button" class="btn_select pai_mainpic" data-toggle="tooltip" title="請設定封面">換圖</button>
							@else
								<button type="button" class="btn_select pai_mainpic" data-toggle="tooltip" title="請設定封面">選圖</button>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_title" class="col-md-4 col-sm-4 col-xs-4 control-label">活動標題</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_title" data-toggle="tooltip" title="標題不能為空" value="{{ $servicedata['pai_title'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_title" data-toggle="tooltip" title="標題不能為空" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_fulldescript" class="col-md-4 col-sm-4 col-xs-4 control-label">活動詳細說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="{{ $servicedata['pai_fulldescript'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_activepics" class="col-md-4 col-sm-4 col-xs-4 control-label">活動圖片</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_activepics">
							<button type="button" class="activity_add_img" data-toggle="tooltip" title="請添加活動圖片">添加圖片</button>
							<div class="activity_content_block">
							@if(isset($servicedata))
								@if(isset($servicedata['pai_activepics']))
								@if(is_array($servicedata['pai_activepics']))
									@foreach ($servicedata['pai_activepics'] as $val)
									<div class="activity_content_box">
										<div class="activity_content_btn">
											<i class="fa fa-2x fa-chevron-up activity_content_up" aria-hidden="true"></i>
											<i class="fa fa-2x fa-chevron-down activity_content_down" aria-hidden="true"></i>
										</div>
	                                    @if(isset($val['content_img']) && $val['content_img'] != '')
	                                        <img alt="{{ $val['content_img'] }}" class="" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $val['content_img'] }}" style="width:50%; ">
	                                    @endif
	                                    <button type="button" class="activity_content_delete">刪除</button>
	                                </div>
	                                @endforeach
	                                @endif
	                            @endif
							@endif
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_gifttype" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵類別</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_gifttype">
							<div class="radio">
								<label>
								    <input type="radio" name="gift_type" class="gift_type" value="1">
								    抽獎卷
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="gift_type" class="gift_type" value="2">
								    禮卷
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="gift_type" class="gift_type" value="3">
								    購點
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_giftcontent" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵內容</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_giftcontent">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_giftcontent" data-toggle="tooltip" title="獎勵內容不能為空" name="pai_giftcontent" value="{{ $servicedata['pai_giftcontent'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_giftcontent" data-toggle="tooltip" title="獎勵內容不能為空" name="pai_giftcontent" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_giftamount" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵數額</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_giftamount">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_giftamount" data-toggle="tooltip" title="獎勵數額不能為空，請填入數字" name="pai_giftamount" value="{{ $servicedata['pai_giftamount'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_giftamount" data-toggle="tooltip" title="獎勵數額不能為空，請填入數字" name="pai_giftamount" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_startdate" class="col-md-4 col-sm-4 col-xs-4 control-label">開始時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pai_startdate" name="pai_startdate" value="{{ $servicedata['pai_startdate'] }}" data-toggle="tooltip" title="請選擇起始日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pai_startdate" name="pai_startdate" value="" data-toggle="tooltip" title="請選擇起始日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_enddate" class="col-md-4 col-sm-4 col-xs-4 control-label">結束時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pai_enddate" name="pai_enddate" value="{{ $servicedata['pai_enddate'] }}" data-toggle="tooltip" title="請選擇結束日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pai_enddate" name="pai_enddate" value="" data-toggle="tooltip" title="請選擇結束日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_poststatus" class="col-md-4 col-sm-4 col-xs-4 control-label">刊登狀態</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_poststatus">
							<div class="radio">
								<label class="radio-inline">
								    <input type="radio" name="post_status" class="post_status" value="0">
								   	停用
								</label>
								<label class="radio-inline">
								    <input type="radio" name="post_status" class="post_status" value="1">
								    啟用
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pai_condition" class="col-md-4 col-sm-4 col-xs-4 control-label">活動檢查內容</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_condition">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_condition" data-toggle="tooltip" title="記錄活動檢查條件對應functionname" name="pai_condition" value="{{ $servicedata['pai_condition'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_condition" data-toggle="tooltip" title="記錄活動檢查條件對應functionname" name="pai_condition" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_eventtarget_url" class="col-md-4 col-sm-4 col-xs-4 control-label">活動事件指向URL</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_eventtarget_url">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pai_eventtarget_url" data-toggle="tooltip" title="活動事件指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pai_eventtarget_url" value="{{ $servicedata['pai_eventtarget_url'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pai_eventtarget_url" data-toggle="tooltip" title="活動事件指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pai_eventtarget_url" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pai_advancedescribe" class="col-md-4 col-sm-4 col-xs-4 control-label">公告內容進階圖文說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pai_advancedescribe">
							<button type="button" class="add_img">添加圖片</button><button type="button" class="add_text">添加文字</button>
							<div class="content_block">
							@if(isset($servicedata))
								@if(isset($servicedata['pai_advancedescribe']))
								@if(is_array($servicedata['pai_advancedescribe']))
									@foreach ($servicedata['pai_advancedescribe'] as $val)
									<div class="content_box">
										<div class="content_btn">
											<i class="fa fa-2x fa-chevron-up content_up" aria-hidden="true"></i>
											<i class="fa fa-2x fa-chevron-down content_down" aria-hidden="true"></i>
										</div>
	                                    @if(isset($val['content_text']) && $val['content_text'] != '')
	                                        <div class="context">{!!$val['content_text']!!}</div>
	                                    @endif
	                                    @if(isset($val['content_img']) && $val['content_img'] != '')
	                                        <img alt="{{ $val['content_img'] }}" class="" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $val['content_img'] }}" style="width:50%; ">
	                                    @endif
	                                    <button type="button" class="content_delete">刪除</button>
	                                </div>
	                                @endforeach
	                                @endif
	                            @endif
							@endif
							</div>
						</div>
					</div>
				</form>
			@endif
		</div>
	</div>
	<div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">

	</div>
</div>
@endsection
@section("content_footer")
@endsection
@section("prompt_body")
	@if(isset($searchdata['error']))
		<div class="prompt_body">
            <div class="prompt_box panel-primary">
                <div class="panel-heading">
                    <h3>提示框</h3>
                </div>
                <h2>{{$searchdata['error']}}</h2>
                <button type="button" class="btn btn-primary btn_yes">確認</button>
            </div>
        </div>
	@endif
@endsection