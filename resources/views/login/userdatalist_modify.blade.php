<?php
if($modifytype == 'userListCreate'){
	$title = '新增使用者資料';
}else if($modifytype == 'userListEdit'){
	$title = '使用者資料異動';
}
?>

@extends('layouts/layout')
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/userdatalist_modify.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-10 col-sm-12 col-md-offset-1 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1><?= isset($title) ? $title : '' ?></h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
		@if($modifytype == 'userListCreate')
		<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<button type="button" class="btn btn-primary usd_save pull-right">存檔</button>
		</div>
		<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<form action="/login/user-list-create" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
				{!! csrf_field() !!}
				<input type="hidden" name="modifytype" value="{{$modifytype}}">
				<div class="form-group">
					<label for="usd_account" class="col-md-4 col-sm-4 col-xs-4 control-label">登入帳號</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control check_unit" name="usd_account" data-toggle="tooltip" title="帳號不能為空">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_name" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者名稱</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control check_unit" name="usd_name" data-toggle="tooltip" title="名稱不能為空">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_pwd" class="col-md-4 col-sm-4 col-xs-4 control-label">登入密碼</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control check_unit" name="usd_pwd" data-toggle="tooltip" title="密碼不能為空">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_pwd_confirm" class="col-md-4 col-sm-4 col-xs-4 control-label">確認密碼</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control check_unit" id="usd_pwd_confirm" data-toggle="tooltip" title="請再次確認密碼">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_status" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者狀態</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<div class="col-md-4 col-sm-4 col-xs-4">
						  <label style="padding-top: 8px;margin-bottom: 0;">
						    <input type="radio" value="0" name="usd_status" checked>
						    停用
						  </label>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4">
						  <label style="padding-top: 8px;margin-bottom: 0;">
						    <input type="radio" value="1" name="usd_status">
						    正常
						  </label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="usd_admin" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者權限</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<div class="col-md-4 col-sm-4 col-xs-4">
						  <label style="padding-top: 8px;margin-bottom: 0;">
						    <input type="radio" value="0" name="usd_admin" checked>
						    一般使用者
						  </label>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4">
							<label style="padding-top: 8px;margin-bottom: 0;">
						    <input type="radio" value="1" name="usd_admin">
						    管理者
						  </label>
						</div>
					</div>
				</div>
			</form>
		</div>





		@elseif($modifytype == 'userListEdit')
		<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<button type="button" class="btn btn-primary usd_save pull-right">存檔</button>
			<a href="/login/user-list" class="btn btn-info pull-right">返回</a>
		</div>
		<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			<form action="/login/user-list-modify" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
				{!! csrf_field() !!}
				<input type="hidden" name="modifytype" value="{{$modifytype}}">
				<input type="hidden" name="serno" value="{{$userdata->usd_serno}}">
				<div class="form-group">
					<label for="usd_account" class="col-md-4 col-sm-4 col-xs-4 control-label">登入帳號</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control" value="{{ $userdata->usd_account }}" readonly="true">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_name" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者名稱</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control check_unit" name="usd_name" data-toggle="tooltip" title="名稱不能為空" value="{{ $userdata->usd_name }}">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_pwd" class="col-md-4 col-sm-4 col-xs-4 control-label">登入密碼</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control check_unit" name="usd_pwd" data-toggle="tooltip" title="密碼不能為空" value="{{ $userdata->usd_pwd }}">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_pwd_confirm" class="col-md-4 col-sm-4 col-xs-4 control-label">確認密碼</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" class="form-control check_unit" id="usd_pwd_confirm" data-toggle="tooltip" title="請再次確認密碼">
					</div>
				</div>
				<div class="form-group">
					<label for="usd_status" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者狀態</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						@if($userdata->usd_status == 0)
							<div class="col-md-4 col-sm-4 col-xs-4">
							  <label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="0" name="usd_status" checked>
							    停用
							  </label>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
							  <label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="1" name="usd_status">
							    正常
							  </label>
							</div>
						@elseif($userdata->usd_status == 1)
							<div class="col-md-4 col-sm-4 col-xs-4">
							  <label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="0" name="usd_status">
							    停用
							  </label>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
							  <label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="1" name="usd_status" checked>
							    正常
							  </label>
							</div>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label for="usd_admin" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者權限</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						@if($userdata->usd_admin == 1)
							<div class="col-md-4 col-sm-4 col-xs-4">
							  <label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="0" name="usd_admin">
							    一般使用者
							  </label>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="1" name="usd_admin" checked>
							    管理者
							  </label>
							</div>
						@elseif($userdata->usd_admin == 0)
							<div class="col-md-4 col-sm-4 col-xs-4">
							  <label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="0" name="usd_admin" checked>
							    一般使用者
							  </label>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<label style="padding-top: 8px;margin-bottom: 0;">
							    <input type="radio" value="1" name="usd_admin">
							    管理者
							  </label>
							</div>
						@endif
					</div>
				</div>
			</form>
		</div>
		@endif
	</div>
    <div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
    </div>
@endsection