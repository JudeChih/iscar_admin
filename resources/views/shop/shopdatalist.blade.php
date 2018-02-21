<?php
$title = "特店列表";
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
<div class="sd_body">
    <div class="sd_box panel-primary">
        <div class="panel-heading">
            <h3>輸入業務代號</h3>
        </div>
        <div class="input_text">
					<h5>特店辨識短碼：</h5>
        </div>
        <input class="form-control" rows="7" name="sd_salescode" data-toggle="tooltip" title="請輸入要綁定的特店代號，英數夾雜7碼">
        <div class="input_text">
					<h5>特店綁定業務：</h5>
        </div>
        <input class="form-control" rows="7" name="sd_salesbind" data-toggle="tooltip" title="請輸入要綁定的業務代號，英數夾雜7碼">
        <div calss="btn_check_box">
            <button type="button" class="btn btn-danger btn_no">取消</button>
            <button type="button" class="btn btn-success btn_yes">確認</button>
        </div>
    </div>
</div>
<div class="metatag_body">
    <div class="metatag_box panel-primary">
        <div class="panel-heading">
            <h3>輸入MetaTag相關資訊</h3>
        </div>
        <div>
					<h5>標題(title)：</h5>
        </div>
        <textarea class="form-control" name="sd_seo_title" data-toggle="tooltip" title="請輸入標題"></textarea>
        <div>
					<h5>關鍵字(keywords)：</h5>
        </div>
        <textarea class="form-control" name="sd_seo_keywords" data-toggle="tooltip" title="請輸入查詢關鍵字，每個關鍵字請都用逗號(,)隔開。"></textarea>
        <div>
					<h5>特店描述(description)：</h5>
        </div>
        <textarea class="form-control" name="sd_seo_description" data-toggle="tooltip" title="請輸入對該特店的描述"></textarea>
        <div class="btn_check_box">
            <button type="button" class="btn btn-danger btn_no">取消</button>
            <button type="button" class="btn btn-success btn_yes">確認</button>
        </div>
    </div>
</div>
@endsection
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/shopdatalist.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<div class="panel-heading col-md-12 col-sm-12 col-xs-12">
	    <h1><?= isset($title) ? $title : '' ?></h1>
	</div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<form action="/shop/shopdata-list" class="search_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="get">
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
		    </div>
		  </form>
	  	<div class="col-md-12 col-sm-12 col-xs-12 btn_m_t btn_box">
				<button type="button" class="btn btn-danger pull-right sdl_flag">刪除</button>
				<button type="button" class="btn btn-info pull-right sdl_detail">詳情</button>
				<button type="button" class="btn btn-warning pull-right sdl_status">停 \ 啟用</button>
				<button type="button" class="btn btn-primary pull-right sdl_salescode">設置業務代號</button>
				<button type="button" class="btn btn-havebind pull-right sdl_havebind">設置認證</button>
				<button type="button" class="btn btn-metatag pull-right sdl_metatag">設置SEO</button>
				<button type="button" class="btn btn-metatag pull-right sdl_payment">設置金流協議狀態</button>
			</div>
		</div>
		<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<div class="sort_check col-md-4 col-sm-4 col-xs-4 p_l_r_dis" data-val="sd_shopname">店家名稱 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="sd_type">類別 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="sd_contact_person">聯絡人 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="sd_zipcode">地區 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="sd_salescode">代號 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="sd_paymentflowagreement">金流協議 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="sd_havebind">認證狀態 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="sd_activestatus">狀態 <i class="dis_none fa" aria-hidden="true"></i></div>
		</div>
		<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		@if(isset($shopdata))
			@if(count($shopdata)!=0)
				@foreach ($shopdata as $data)
					<form action="/shop/shopdatadetail" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
						{!! csrf_field() !!}
						<input type="hidden" name="sd_id" value="{{ $data['sd_id'] }}">
						<input type="hidden" name="sd_activestatus" value="{{ $data['sd_activestatus'] }}">
						<input type="hidden" name="sd_havebind" value="{{ $data['sd_havebind'] }}">
						<input type="hidden" name="sd_salesbind" value="{{ $data['sd_salesbind'] }}">
						<input type="hidden" name="sd_salescode" value="{{ $data['sd_salescode'] }}">
						<input type="hidden" name="sd_paymentflowagreement" value="{{ $data['sd_paymentflowagreement'] }}">
						<div class="col-md-4 col-sm-4 col-xs-4 text_left">{{ $data['sd_shopname'] }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 text_left">
							@if($data['sd_type'] == 1)
								二手車商
							@elseif($data['sd_type'] == 2)
								汽車鍍膜
							@elseif($data['sd_type'] == 3)
								保養維修
							@elseif($data['sd_type'] == 4)
								輪胎避震
							@elseif($data['sd_type'] == 5)
								周邊配備
							@elseif($data['sd_type'] == 99)
								宮廟
							@elseif($data['sd_type'] == 0)
								未分類
							@endif
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data['sd_contact_person'] }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis sd_zipcode_turnText">{{ $data['sd_zipcode'] }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">{{ $data['sd_salescode'] }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
							@if($data['sd_paymentflowagreement'] == 1)
								已簽署
							@elseif($data['sd_paymentflowagreement'] == 2 || $data['sd_paymentflowagreement'] == 0)
								未簽署
							@endif
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
							@if($data['sd_havebind'] == 0)
								未認證
							@elseif($data['sd_havebind'] == 1)
								已認證
							@endif
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
							@if($data['sd_activestatus'] == 0)
								停用中
							@elseif($data['sd_activestatus'] == 1)
								啟用中
							@endif
						</div>
					</form>
		  	@endforeach
		  @else
				<p>查無資料</p>
		  @endif
		@else
			<p>目前暫無特店</p>
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
