<?php
$title = "活動公告列表";
?>
@extends('layouts/layout')
@section("prompt_box")
<div class="sdmr_body">
    <div class="sdmr_box panel-primary">
        <div class="panel-heading">
            <h3>異動原因</h3>
        </div>
        <textarea class="form-control" rows="5" name="sdmr_modifyreason" data-toggle="tooltip" title="請說明這次的異動原因"></textarea>
        <div>
            <button type="button" class="btn btn-danger btn_no">取消</button>
            <button type="button" class="btn btn-success btn_yes">確認</button>
        </div>
    </div>
</div>
@endsection
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/serviceannouncement.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<div class="panel-heading col-md-12 col-sm-12 col-xs-12">
	    <h1><?= isset($title) ? $title : '' ?></h1>
	</div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<form action="/service/activity" class="search_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="get">
				<!-- 所有的查詢參數都會隱藏放置在這邊 -->
				@if(isset($searchdata['total_page']))
					<input type="hidden" name="total_page" value="{{ $searchdata['total_page'] }}">
				@else
					<input type="hidden" name="total_page" value="">
				@endif
				@if(isset($searchdata['skip_page']))
					<input type="hidden" name="skip_page" value="{{ $searchdata['skip_page'] }}">
				@else
					<input type="hidden" name="skip_page" value="0">
				@endif
				{{-- @if(isset($searchdata['total_page']))
					<input type="hidden" name="total_page" value="{{ $searchdata['total_page'] }}">
				@else
					<input type="hidden" name="total_page" value="">
				@endif
				@if(isset($searchdata['skip_page']))
					<input type="hidden" name="skip_page" value="{{ $searchdata['skip_page'] }}">
				@else
					<input type="hidden" name="skip_page" value="0">
				@endif
				@if(isset($searchdata['sd_type']))
					<input type="hidden" name="sd_type" value="{{ $searchdata['sd_type'] }}">
				@else
					<input type="hidden" name="sd_type" value="-1">
				@endif
				@if(isset($searchdata['search_type']))
					<input type="hidden" name="search_type" value="{{ $searchdata['search_type'] }}">
				@else
					<input type="hidden" name="search_type" value="sd_shopname">
				@endif
				@if(isset($searchdata['sd_zipcode']))
					<input type="hidden" name="sd_zipcode" value="{{ $searchdata['sd_zipcode'] }}">
				@else
					<input type="hidden" name="sd_zipcode" value="0">
				@endif
				@if(isset($searchdata['sd_havebind']))
					<input type="hidden" name="sd_havebind" value="{{ $searchdata['sd_havebind'] }}">
				@else
					<input type="hidden" name="sd_havebind" value="-1">
				@endif
				@if(isset($searchdata['sd_activestatus']))
					<input type="hidden" name="sd_activestatus" value="{{ $searchdata['sd_activestatus'] }}">
				@else
					<input type="hidden" name="sd_activestatus" value="1">
				@endif
				@if(isset($searchdata['sort']))
					<input type="hidden" name="sort" value="{{ $searchdata['sort'] }}">
				@else
					<input type="hidden" name="sort" value="sd_shopname">
				@endif
				@if(isset($searchdata['order']))
					<input type="hidden" name="order" value="{{ $searchdata['order'] }}">
				@else
					<input type="hidden" name="order" value="DESC">
				@endif
		    <div class="col-md-12 col-sm-12 col-xs-12  sd_search">
		    	<div class="input-group">
		    		<div class="input-group-btn">
			        <select class="form-control select_width">
				    		<option value="sd_shopname">店家名稱</option>
				    		<option value="sd_contact_person">聯絡人</option>
				    	</select>
			    	</div>
				  @if(isset($searchdata['query_name']))
			    	<input type="text" name="query_name" class="form-control" placeholder="查詢名稱" value="{{ $searchdata['query_name'] }}">
					@else
						<input type="text" name="query_name" class="form-control" placeholder="查詢名稱">
					@endif
					</div>
		    </div>
		    <div class="col-md-3 col-sm-3 col-xs-4 sd_type">
		    	<select class="form-control m_b">

		    	</select>
		    </div>
		    <div class="col-md-3 col-sm-3 col-xs-4 sd_havebind">
		    	<select class="form-control m_b">
		    		<option value="-1">全部店家</option>
		    		<option value="1">已認證</option>
		    		<option value="0">未認證</option>
		    	</select>
		    </div>
		    <div class="col-md-2 col-sm-2 col-xs-4 sd_activestatus">
		    	<select class="form-control m_b">
		    		<option value="1">啟用中</option>
		    		<option value="0">停用中</option>
		    	</select>
		    </div>
		    <div class="col-md-2 col-sm-2 col-xs-6 sd_countries">
		    	<select class="form-control m_b">

		    	</select>
		    </div>
		    <div class="col-md-2 col-sm-2 col-xs-6 sd_region">
		    	<select class="form-control m_b">

		    	</select>
		    </div>
		    <div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		    	<button type="button" class="btn btn-default sdl_search m_r">查詢</button>
		    	<a href="/shop/shopdata-list" class="btn btn-default sdl_clear">清除</a>
		    </div> --}}
		  </form>
	  	<div class="col-md-12 col-sm-12 col-xs-12 btn_m_t btn_box">
				<button type="button" class="btn btn-danger pull-right pa_flag">刪除</button>
				<button type="button" class="btn btn-warning pull-right pa_modify">修改</button>
				<a type="button" href="/service/announcement/create" class='btn btn-success pull-right'>新增</a>
{{-- 				<button type="button" class="btn btn-info pull-right sdl_detail">詳情</button>
				<button type="button" class="btn btn-warning pull-right sdl_status">設置狀態</button>
				<button type="button" class="btn btn-primary pull-right sdl_salescode">設置代號</button>
				<button type="button" class="btn btn-havebind pull-right sdl_havebind">設置認證</button>
				<button type="button" class="btn btn-metatag pull-right sdl_metatag">設置SEO</button> --}}
			</div>
		</div>
		<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="pa_fulldescript">標題 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-4 col-sm-4 col-xs-4 p_l_r_dis" data-val="pa_id">詳細說明 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="pa_title">獎勵類別 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="pa_shortcode">開始時間 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="pa_mainpic">結束時間 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="pa_startdate">刊登狀態 <i class="dis_none fa" aria-hidden="true"></i></div>
		</div>
		<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		@if(isset($servicedata))
			@if(count($servicedata)!=0)
				@foreach ($servicedata as $data)
					<form action="/service/announcement" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
						{!! csrf_field() !!}
						<input type="hidden" name="pa_id" value="{{ $data['pa_id'] }}">
						{{-- <input type="hidden" name="sd_id" value="{{ $data['sd_id'] }}">
						<input type="hidden" name="sd_activestatus" value="{{ $data['sd_activestatus'] }}">
						<input type="hidden" name="sd_havebind" value="{{ $data['sd_havebind'] }}"> --}}
						<div class="col-md-2 col-sm-2 col-xs-2 text_left">{{ $data['pa_title'] }}</div>
						<div class="col-md-4 col-sm-4 col-xs-4 text_left">{{ $data['pa_fulldescript'] }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
							@if($data['pa_announcementtype'] == 1)
								純公告
							@elseif($data['pa_announcementtype'] == 2)
								活動事件
							@elseif($data['pa_announcementtype'] == 3)
								抽獎事件
							@endif
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data['pa_startdate'] }}</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data['pa_enddate'] }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
							@if($data['pa_poststatus'] == 0)
								停用中
							@elseif($data['pa_poststatus'] == 1)
								啟用中
							@endif
						</div>
					</form>
		  	@endforeach
		  @else
				<p>查無資料</p>
		  @endif
		@else
			<p>目前暫無活動公告</p>
		@endif
		</div>
	</div>
	<div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
		<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<nav aria-label="Page navigation">
	        <ul class="pagination" id="pagination"></ul>
	    </nav>
		</div>
	</div>
</div>
@endsection
