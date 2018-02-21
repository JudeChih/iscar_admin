<?php
$title = "商品細節";
?>

@extends('layouts/layout')
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/shopcoupondata.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-10 col-sm-12 col-md-offset-1 col-xs-12 p_l_r_dis">
	<div class="panel-heading col-md-12 col-sm-12 col-xs-12">
	    <h1><?= isset($title) ? $title : '' ?></h1>
	</div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<button type="button" class="btn btn-primary pull-right mdl_save">存檔</button>
			<a href="/member/moduledata" class="btn btn-info pull-right">返回</a>
		</div>
		<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<form action="/member/moduledatamodify" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
				{!! csrf_field() !!}
				<input type="hidden" name="mapr_serno" value="{{ $moduledata['mapr_serno'] }}">
				<div class="form-group">
					<label for="mapr_modulename" class="col-md-4 col-sm-4 col-xs-4 control-label">模組名稱</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" name="mapr_modulename" class="form-control check_unit" value="{{$moduledata['mapr_modulename']}}" data-toggle="tooltip" title="請填入模組名稱">
					</div>
				</div>
				<div class="form-group">
					<label for="mapr_redirect_uri" class="col-md-4 col-sm-4 col-xs-4 control-label">模組回傳頁</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" name="mapr_redirect_uri" class="form-control check_unit" value="{{$moduledata['mapr_redirect_uri']}}" data-toggle="tooltip" title="請填寫回傳頁路徑">
					</div>
				</div>
				<div class="form-group">
					<label for="mapr_functiontype" class="col-md-4 col-sm-4 col-xs-4 control-label">模組類型</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="hidden" name="mapr_functiontype" class="form-control" value="{{$moduledata['mapr_functiontype']}}" data-toggle="tooltip">
						<select class="form-control" data-toggle="tooltip" id='mapr_functiontype' title="模組類型">
			    		<option value="1">前台</option>
			    		<option value="2">後台</option>
		    	</select>
					</div>
				</div>
				<div class="form-group">
					<label for="mapr_contactname" class="col-md-4 col-sm-4 col-xs-4 control-label">聯絡人名稱</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" name="mapr_contactname" class="form-control" value="{{$moduledata['mapr_contactname']}}" data-toggle="tooltip" title="請填入聯絡人名稱">
					</div>
				</div>
				<div class="form-group">
					<label for="mapr_contactmail" class="col-md-4 col-sm-4 col-xs-4 control-label">聯絡人信箱</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" name="mapr_contactmail" class="form-control" value="{{$moduledata['mapr_contactmail']}}" data-toggle="tooltip" title="請填入聯絡人信箱">
					</div>
				</div>
				<div class="form-group">
					<label for="mapr_contactmobile" class="col-md-4 col-sm-4 col-xs-4 control-label">聯絡人電話</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" name="mapr_contactmobile" class="form-control" value="{{$moduledata['mapr_contactmobile']}}" data-toggle="tooltip" title="請填入聯絡人電話">
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
		<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">

		</div>
	</div>
</div>
@endsection