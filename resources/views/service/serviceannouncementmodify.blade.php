@extends('layouts/layout')
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/serviceannouncementmodify.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-10 col-sm-12 col-md-offset-1 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1>
        	@if($searchdata['modifytype'] == 'modify')
				修改活動公告
			@elseif ($searchdata['modifytype'] == 'create')
				新增活動公告
			@endif
        </h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<button type="button" class="btn btn-primary pa_save pull-right">存檔</button>
			<a href="/service/announcement" class="btn btn-info pull-right pa_return">返回</a>
		</div>
		<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			@if($searchdata['modifytype'] == 'create')
				<form action="/service/announcement/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal service_form" method="post" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<input type="hidden" name="modifytype" value="{{$searchdata['modifytype']}}">
					<input type="hidden" name="pa_id" value="{{$pa_id}}">
					@if(isset($servicedata))
						<input type="hidden" name="pa_mainpic" value="{{ $servicedata['pa_mainpic'] }}">
						<input type="hidden" name="pa_announcementtype" value="{{ $servicedata['pa_announcementtype'] }}">
						<input type="hidden" name="pa_poststatus" value="{{ $servicedata['pa_poststatus'] }}">
						<input type="hidden" name="pa_nextpage" value="{{ $servicedata['pa_nextpage'] }}">
						@if(isset($servicedata['pa_advancedescribe']))
							<input type="hidden" name="pa_advancedescribe" value="{{ json_encode($servicedata['pa_advancedescribe']) }}">
						@else
							<input type="hidden" name="pa_advancedescribe" value="">
						@endif
					@else
						<input type="hidden" name="pa_mainpic" value="">
						<input type="hidden" name="pa_announcementtype" value="1">
						<input type="hidden" name="pa_poststatus" value="0">
						<input type="hidden" name="pa_nextpage" value="1">
						<input type="hidden" name="pa_advancedescribe" value="">
					@endif
					<div class="form-group">
						<label for="pa_shortcode" class="col-md-4 col-sm-4 col-xs-4 control-label">公告代號</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit pa_shortcode" name="pa_shortcode" data-toggle="tooltip" title="代號不能為空，字數限制3字，只能英文" rows="3" value="{{ $servicedata['pa_shortcode'] }}">
							@else
								<input type="text" class="form-control check_unit pa_shortcode" name="pa_shortcode" data-toggle="tooltip" title="代號不能為空，字數限制3字，只能英文" rows="3" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_mainpic" class="col-md-4 col-sm-4 col-xs-4 control-label">公告封面</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_mainpic">
							@if(isset($servicedata))
								@if($servicedata['pa_mainpic'] != '')
									<img alt="{{ $servicedata['pa_mainpic'] }}" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $servicedata['pa_mainpic'] }}" width="50%">
									<button type="button" class="mainpic_change change" data-toggle="tooltip" title="請設定封面">換圖</button>
								@else
									<button type="button" class="btn_select" data-toggle="tooltip" title="請設定封面">選圖</button>
								@endif
							@else
								<button type="button" class="btn_select" data-toggle="tooltip" title="請設定封面">選圖</button>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_title" class="col-md-4 col-sm-4 col-xs-4 control-label">公告標題</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_title" data-toggle="tooltip" title="標題不能為空" value="{{ $servicedata['pa_title'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_title" data-toggle="tooltip" title="標題不能為空" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_fulldescript" class="col-md-4 col-sm-4 col-xs-4 control-label">公告詳細說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="{{ $servicedata['pa_fulldescript'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_announcementtype" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵類別</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_announcementtype">
							<div class="radio">
								<label>
								    <input type="radio" name="announcement_type" class="announcement_type" value="1">
								    純公告
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="announcement_type" class="announcement_type" value="2">
								    活動事件
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="announcement_type" class="announcement_type" value="3">
								    抽獎事件
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pa_startdate" class="col-md-4 col-sm-4 col-xs-4 control-label">開始時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pa_startdate" name="pa_startdate" value="{{ $servicedata['pa_startdate'] }}" data-toggle="tooltip" title="請選擇起始日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pa_startdate" name="pa_startdate" value="" data-toggle="tooltip" title="請選擇起始日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_enddate" class="col-md-4 col-sm-4 col-xs-4 control-label">結束時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pa_enddate" name="pa_enddate" value="{{ $servicedata['pa_enddate'] }}" data-toggle="tooltip" title="請選擇結束日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pa_enddate" name="pa_enddate" value="" data-toggle="tooltip" title="請選擇結束日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_poststatus" class="col-md-4 col-sm-4 col-xs-4 control-label">刊登狀態</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_poststatus">
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
						<label for="pa_nextpage" class="col-md-4 col-sm-4 col-xs-4 control-label">導頁需求</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_nextpage">
							<div class="radio">
								<label class="radio-inline">
								    <input type="radio" name="next_page" class="next_page" value="1">
								   	無跳頁
								</label>
								<label class="radio-inline">
								    <input type="radio" name="next_page" class="next_page" value="2">
								    要跳頁
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pa_buttonname" class="col-md-4 col-sm-4 col-xs-4 control-label">導頁按鈕名稱</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_buttonname">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_buttonname" data-toggle="tooltip" title="按鈕名稱不能為空，字數限制10個字" name="pa_buttonname" value="{{ $servicedata['pa_buttonname'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_buttonname" data-toggle="tooltip" title="按鈕名稱不能為空，字數限制10個字" name="pa_buttonname" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_point_url" class="col-md-4 col-sm-4 col-xs-4 control-label">公告指向URL</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_point_url">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_point_url" data-toggle="tooltip" title="公告指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pa_point_url" value="{{ $servicedata['pa_point_url'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_point_url" data-toggle="tooltip" title="公告指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pa_point_url" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_advancedescribe" class="col-md-4 col-sm-4 col-xs-4 control-label">公告內容進階圖文說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_advancedescribe">
							<button type="button" class="add_img">添加圖片</button><button type="button" class="add_text">添加文字</button>
							<div class="content_block">
							@if(isset($servicedata))
								@if(isset($servicedata['pa_advancedescribe']))
								@if(is_array($servicedata['pa_advancedescribe']))
									@foreach ($servicedata['pa_advancedescribe'] as $val)
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
				<form action="/service/announcement/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal service_form" method="post" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<input type="hidden" name="modifytype" value="{{$searchdata['modifytype']}}">
					<input type="hidden" name="pa_id" value="{{$servicedata['pa_id']}}">
					@if(isset($servicedata))
						<input type="hidden" name="pa_mainpic" value="{{ $servicedata['pa_mainpic'] }}">
						<input type="hidden" name="pa_announcementtype" value="{{ $servicedata['pa_announcementtype'] }}">
						<input type="hidden" name="pa_poststatus" value="{{ $servicedata['pa_poststatus'] }}">
						<input type="hidden" name="pa_nextpage" value="{{ $servicedata['pa_nextpage'] }}">
						@if(isset($servicedata['pa_advancedescribe']))
							<input type="hidden" name="pa_advancedescribe" value="{{ json_encode($servicedata['pa_advancedescribe']) }}">
						@else
							<input type="hidden" name="pa_advancedescribe" value="">
						@endif
					@else
						<input type="hidden" name="pa_mainpic" value="">
						<input type="hidden" name="pa_announcementtype" value="1">
						<input type="hidden" name="pa_poststatus" value="0">
						<input type="hidden" name="pa_nextpage" value="1">
						<input type="hidden" name="pa_advancedescribe" value="">
					@endif
					<div class="form-group">
						<label for="pa_shortcode" class="col-md-4 col-sm-4 col-xs-4 control-label">公告代號</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit pa_shortcode" name="pa_shortcode" data-toggle="tooltip" title="代號不能為空，字數限制3字，只能英文" rows="3" value="{{ $servicedata['pa_shortcode'] }}">
							@else
								<input type="text" class="form-control check_unit pa_shortcode" name="pa_shortcode" data-toggle="tooltip" title="代號不能為空，字數限制3字，只能英文" rows="3" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_mainpic" class="col-md-4 col-sm-4 col-xs-4 control-label">公告封面</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<img alt="{{ $servicedata['pa_mainpic'] }}" src="{{config('global.pic_domainpath')}}iscar_app/shopdata/{{ $servicedata['pa_mainpic'] }}" width="50%">
								<button type="button" class="btn_select pa_mainpic" data-toggle="tooltip" title="請設定封面">換圖</button>
							@else
								<button type="button" class="btn_select pa_mainpic" data-toggle="tooltip" title="請設定封面">選圖</button>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_title" class="col-md-4 col-sm-4 col-xs-4 control-label">公告標題</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_title" data-toggle="tooltip" title="標題不能為空" value="{{ $servicedata['pa_title'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_title" data-toggle="tooltip" title="標題不能為空" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_fulldescript" class="col-md-4 col-sm-4 col-xs-4 control-label">公告詳細說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="{{ $servicedata['pa_fulldescript'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_fulldescript" data-toggle="tooltip" title="標題不能為空，字數限制500字" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_announcementtype" class="col-md-4 col-sm-4 col-xs-4 control-label">獎勵類別</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_announcementtype">
							<div class="radio">
								<label>
								    <input type="radio" name="announcement_type" class="announcement_type" value="1">
								    純公告
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="announcement_type" class="announcement_type" value="2">
								    活動事件
								</label>
							</div>
							<div class="radio">
								<label>
								    <input type="radio" name="announcement_type" class="announcement_type" value="3">
								    抽獎事件
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pa_startdate" class="col-md-4 col-sm-4 col-xs-4 control-label">開始時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pa_startdate" name="pa_startdate" value="{{ $servicedata['pa_startdate'] }}" data-toggle="tooltip" title="請選擇起始日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pa_startdate" name="pa_startdate" value="" data-toggle="tooltip" title="請選擇起始日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_enddate" class="col-md-4 col-sm-4 col-xs-4 control-label">結束時間</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" id="pa_enddate" name="pa_enddate" value="{{ $servicedata['pa_enddate'] }}" data-toggle="tooltip" title="請選擇結束日" readonly>
							@else
								<input type="text" class="form-control check_unit" id="pa_enddate" name="pa_enddate" value="" data-toggle="tooltip" title="請選擇結束日" readonly>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_poststatus" class="col-md-4 col-sm-4 col-xs-4 control-label">刊登狀態</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_poststatus">
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
						<label for="pa_nextpage" class="col-md-4 col-sm-4 col-xs-4 control-label">導頁需求</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_nextpage">
							<div class="radio">
								<label class="radio-inline">
								    <input type="radio" name="next_page" class="next_page" value="1">
								   	無跳頁
								</label>
								<label class="radio-inline">
								    <input type="radio" name="next_page" class="next_page" value="2">
								    要跳頁
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="pa_buttonname" class="col-md-4 col-sm-4 col-xs-4 control-label">導頁按鈕名稱</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_buttonname">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_buttonname" data-toggle="tooltip" title="按鈕名稱不能為空，字數限制10個字" name="pa_buttonname" value="{{ $servicedata['pa_buttonname'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_buttonname" data-toggle="tooltip" title="按鈕名稱不能為空，字數限制10個字" name="pa_buttonname" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_point_url" class="col-md-4 col-sm-4 col-xs-4 control-label">公告指向URL</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_point_url">
							@if(isset($servicedata))
								<input type="text" class="form-control check_unit" name="pa_point_url" data-toggle="tooltip" title="公告指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pa_point_url" value="{{ $servicedata['pa_point_url'] }}">
							@else
								<input type="text" class="form-control check_unit" name="pa_point_url" data-toggle="tooltip" title="公告指向URL不能為空，記錄用戶應前往那一頁完成公告需求,以便提供用戶跳轉" name="pa_point_url" value="">
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="pa_advancedescribe" class="col-md-4 col-sm-4 col-xs-4 control-label">公告內容進階圖文說明</label>
						<div class="col-md-6 col-sm-6 col-xs-8 pa_advancedescribe">
							<button type="button" class="add_img">添加圖片</button><button type="button" class="add_text">添加文字</button>
							<div class="content_block">
							@if(isset($servicedata))
								@if(isset($servicedata['pa_advancedescribe']))
									@if(is_array($servicedata['pa_advancedescribe']))
										@foreach ($servicedata['pa_advancedescribe'] as $val)
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