<?php
$title = "商品列表";
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
<script type="text/javascript" src="/js/view/shopcouponlist.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<div class="panel-heading col-md-12 col-sm-12 col-xs-12">
	    <h1><?= isset($title) ? $title : '' ?></h1>
	</div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<form action="/shop/shopcoupondata-list" class="search_form col-md-9 col-sm-9 col-xs-12 p_l_r_dis" method="get">
				<!-- 所有的查詢參數都會隱藏放置在這邊 -->
				@if(isset($searchdata['total_page']))
					<input type="hidden" name="total_page" value="{{ $searchdata['total_page'] }}">
				@else
					<input type="hidden" name="total_page" value="0">
				@endif
				@if(isset($searchdata['skip_page']))
					<input type="hidden" name="skip_page" value="{{ $searchdata['skip_page'] }}">
				@else
					<input type="hidden" name="skip_page" value="0">
				@endif
				@if(isset($searchdata['scm_category']))
					<input type="hidden" name="scm_category" value="{{ $searchdata['scm_category'] }}">
				@else
					<input type="hidden" name="scm_category" value="-1">
				@endif
				@if(isset($searchdata['search_type']))
					<input type="hidden" name="search_type" value="{{ $searchdata['search_type'] }}">
				@else
					<input type="hidden" name="search_type" value="sd_shopname">
				@endif
				@if(isset($searchdata['scm_poststatus']))
					<input type="hidden" name="scm_poststatus" value="{{ $searchdata['scm_poststatus'] }}">
				@else
					<input type="hidden" name="scm_poststatus" value="1">
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
		    <div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis scm_search">
		    	<div class="input-group">
		    		<div class="input-group-btn">
				        <select class="form-control select_width">
				    		<option value="sd_shopname">店家名稱</option>
				    		<option value="scm_title">商品標題</option>
				    	</select>
			    	</div>
				  @if(isset($searchdata['query_name']))
			    	<input type="text" name="query_name" class="form-control" placeholder="查詢名稱" value="{{ $searchdata['query_name'] }}">
					@else
						<input type="text" name="query_name" class="form-control" placeholder="查詢名稱">
					@endif
				</div>
		    </div>
		    <div class="col-md-2 col-sm-2 col-xs-2 p_l_dis scm_category">
		    	<select class="form-control">
		    		{{-- <option value="-1">全部類別</option>
		    		<option value="0">汽車美容</option>
		    		<option value="1">汽車維修</option>
		    		<option value="2">汽車百貨</option>
		    		<option value="3">汽車零件</option> --}}
		    	</select>
		    </div>
		    <div class="col-md-2 col-sm-2 col-xs-2 p_l_dis scm_poststatus">
		    	<select class="form-control">
		    		<option value="1">啟用中</option>
		    		<option value="0">停用中</option>
		    	</select>
		    </div>
		    <div class="col-md-8 col-sm-8 col-xs-8 p_l_r_dis">
		    	<button type="button" class="btn btn-default scl_search pull-right">查詢</button>
		    	<a href="/shop/shopcoupondata-list" class="btn btn-default sdl_clear pull-right">清除</a>
		    </div>
		  	</form>
		  	<div class="col-md-3 col-sm-3 col-xs-12 p_l_r_dis btn_m_t">
				<button type="button" class="btn btn-warning pull-right scm_status">停 / 啟用</button>
{{-- 				<button type="button" class="btn btn-danger pull-right scm_isflag">刪除</button> --}}
				<button type="button" class="btn btn-info pull-right scm_detail">詳情</button>
			</div>
		</div>
		<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="sd_shopname">店家名稱 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="scm_title">商品標題 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="scm_category">商品類別 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="scm_poststatus">刊登狀態 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="scm_startdate">開始時間 <i class="dis_none fa" aria-hidden="true"></i></div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="scm_enddate">結束時間 <i class="dis_none fa" aria-hidden="true"></i></div>
		</div>
		<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		@if(isset($shopdata))
			@if(count($shopdata)!=0)
				@foreach ($shopdata as $data)
					<form action="/shop/shopcoupondetail" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
						{!! csrf_field() !!}
						<input type="hidden" name="sd_id" value="{{ $data['sd_id'] }}">
						<input type="hidden" name="scm_id" value="{{ $data['scm_id'] }}">
						<input type="hidden" name="scm_poststatus" value="{{ $data['scm_poststatus'] }}">
						<div class="col-md-3 col-sm-3 col-xs-3 p_l_r_dis mdl_replace">{{ $data['sd_shopname'] }}</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis mdl_replace">{{ $data['scm_title'] }}</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis mdl_replace">
							@if($data['scm_category'] == 0)
								汽車美容
							@elseif($data['scm_category'] == 1)
								汽車維修
							@elseif($data['scm_category'] == 2)
								汽車百貨
							@elseif($data['scm_category'] == 3)
								汽車零件
							@endif
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis mdl_replace">
							@if($data['scm_poststatus'] == 0)
								停用中
							@elseif($data['scm_poststatus'] == 1)
								啟用中
							@endif
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis mdl_replace">{{ $data['scm_startdate'] }}</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis mdl_replace">{{ $data['scm_enddate'] }}</div>
					</form>
		  	@endforeach
		  @else
				<p>查無資料</p>
		  @endif
		@else
			<p>目前暫無商品</p>
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
{{-- <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>商品列表 <small>Sessions</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                    </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="dashboard-widget-content">

                <ul class="list-unstyled timeline widget">
                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title">
                                    <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                </h2>
                                <div class="byline">
                                    <span>13 hours ago</span> by <a>Jane Smith</a>
                                </div>
                                <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title">
                                    <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                </h2>
                                <div class="byline">
                                    <span>13 hours ago</span> by <a>Jane Smith</a>
                                </div>
                                <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title">
                                    <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                </h2>
                                <div class="byline">
                                    <span>13 hours ago</span> by <a>Jane Smith</a>
                                </div>
                                <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title">
                                    <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                </h2>
                                <div class="byline">
                                    <span>13 hours ago</span> by <a>Jane Smith</a>
                                </div>
                                <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}
@endsection
