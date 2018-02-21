<?php
	$title = "業務綁定";
?>

@extends('layouts/layout')
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/salesbinding.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1><?= isset($title) ? $title : '' ?></h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<form action="/sales/sales-binding" class="search_form col-md-8 col-sm-8 col-xs-12 p_l_r_dis" method="get">
		{{-- 		@if(isset($sort))
					<input type="hidden" name="sort" value="{{ $sort }}">
				@else
					<input type="hidden" name="sort" value="11">
				@endif --}}
		    <div class="col-md-8 col-sm-8 col-xs-8 p_l_r_dis">
		    	<div class="col-md-3 col-sm-3 col-xs-3 p_l_r_dis sb_label_setting">
		    		<label><span>*</span>手機號碼：</label>
		    	</div>
		    	<div class="col-md-9 col-sm-9 col-xs-9 p_l_r_dis">
				    @if(isset($query_mobile))
				    	<input type="text" name="regiestmobile" class="form-control check_unit" placeholder="輸入會員手機號碼" value="{{ $query_mobile }}" data-toggle="tooltip" title="請輸入手機號碼">
						@else
							<input type="text" name="regiestmobile" class="form-control check_unit" placeholder="輸入會員手機號碼" data-toggle="tooltip" title="請輸入手機號碼">
						@endif
					</div>
		    </div>
		    <div class="col-md-8 col-sm-8 col-xs-8 p_l_r_dis">
		    	<div class="col-md-3 col-sm-3 col-xs-3 p_l_r_dis sb_label_setting">
		    		<label><span>*</span>電子信箱：</label>
		    	</div>
		    	<div class="col-md-9 col-sm-9 col-xs-9 p_l_r_dis">
				    @if(isset($query_contactmail))
				    	<input type="text" name="contactmail" class="form-control check_unit" placeholder="輸入會員信箱" value="{{ $query_contactmail }}" data-toggle="tooltip" title="請輸入電子信箱">
						@else
							<input type="text" name="contactmail" class="form-control check_unit" placeholder="輸入會員信箱" data-toggle="tooltip" title="請輸入電子信箱">
						@endif
					</div>
		    </div>
		    <div class="col-md-4 col-sm-4 col-xs-4 p_l_r_dis">
		    	<button type="button" class="btn btn-default sb_search">查詢</button>
		    </div>
		  </form>
		  <div class="col-md-4 col-sm-4 col-xs-12 p_l_r_dis">
		{{--   	<a href="/sales/sales-management" class="btn btn-warning pull-right">返回</a> --}}
			</div>
		</div>
		<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis">名稱</div>
			<div class="sort_check col-md-4 col-sm-4 col-xs-4 p_l_r_dis">會員帳號</div>
			<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis">電子郵件</div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis">手機</div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis">動作</div>
		</div>
		<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		@if(isset($salesdata))
			@if(count($salesdata)!=0)
				{{-- @foreach ($salesdata as $data) --}}
					<form action="/sales/sales-binding" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
						{!! csrf_field() !!}
						{{-- <input type="hidden" name="host_guid" value="{{ $data->host_guid }}"> --}}
						<input type="hidden" name="cname" value="{{ $salesdata['md_cname'] }}">
						<input type="hidden" name="regiestmobile" value="{{ $salesdata['md_regiestmobile'] }}">
						<input type="hidden" name="contactmail" value="{{ $salesdata['md_contactmail'] }}">
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $salesdata['md_cname'] }}</div>
						<div class="col-md-4 col-sm-4 col-xs-4 text_left">
							{{ $salesdata['md_account'] }}
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 text_left">
							{{ $salesdata['md_contactmail'] }}
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 text_left">
							{{ $salesdata['md_regiestmobile'] }}
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1">
							<button type="button" class="btn btn-xs btn-warning sb_change">綁定</button>
						</div>
					</form>
		  	{{-- @endforeach --}}
		  @else
				<p>查無資料</p>
		  @endif
		@else
				<p>請用查詢功能</p>
		@endif
		</div>
	</div>
    <div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
    	<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">

		</div>
	</div>
</div>
@endsection
@section("content_footer")

@endsection