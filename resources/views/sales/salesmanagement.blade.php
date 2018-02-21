<?php
$title = "業務管理";
?>

@extends('layouts/layout')
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/salesmanagemant.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1><?= isset($title) ? $title : '' ?></h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		  <div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis btn_m_t">
			</div>
		</div>
		<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis">名稱</div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis">狀態</div>
			<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis">會員帳號</div>
			<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis">電子郵件</div>
			<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis">手機</div>
			<div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis">動作</div>
		</div>
		<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		@if(isset($salesdata))
			@if(count($salesdata)!=0)
				@foreach ($salesdata as $data)
					<form action="/salesdata/changeStatus" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
						{!! csrf_field() !!}
						<input type="hidden" name="sls_serno" value="{{ $data->sls_serno }}">
						<input type="hidden" name="md_cname" value="{{ $data->md_cname }}">
						@if($data->sls_status == 1)
							<input type="hidden" name="sls_status" value="2">
						@elseif($data->sls_status == 2)
							<input type="hidden" name="sls_status" value="1">
						@endif
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data->md_cname }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
							@if($data->sls_status == 0)
								待驗證
							@elseif($data->sls_status == 1)
								啟用
							@elseif($data->sls_status == 2)
								停用
							@endif
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 p_l_r_dis">{{ $data->md_account }}</div>
						<div class="col-md-3 col-sm-3 col-xs-3 p_l_r_dis">{{ $data->md_contactmail }}</div>
						<div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data->md_mobile }}</div>
						<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
							@if($data->sls_status == 0)
							@elseif($data->sls_status == 1)
								<button type="button" class="btn btn-xs btn-danger sm_change">停用</button>
							@elseif($data->sls_status == 2)
								<button type="button" class="btn btn-xs btn-success sm_change">啟用</button>
							@endif
						</div>
					</form>
		  	@endforeach
		  @else
				<p>查無資料</p>
		  @endif
		@else
			<p>請綁定業務</p>
		@endif
		</div>
	</div>
    <div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
	    <div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		@if(isset($salesdata))
			{{ $salesdata }}
		@endif
		</div>
	</div>
</div>
@endsection