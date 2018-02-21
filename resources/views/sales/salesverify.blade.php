<?php
	$title = "業務驗證";
?>
@extends('login/__login_index')
@section("content_tip")
<script type="text/javascript" src="/js/view/salesverify.js"></script>
@if(isset($message))
	<div class="prompt_body_success">
    <div class="prompt_box_success panel-primary">
  		<div class="panel-heading">
      	<h3>提示框</h3>
      </div>
      <h2></h2>
      <div>
      	<button type="button" class="btn btn-danger btn_no">取消</button>
      	<button type="button" class="btn btn-success btn_yes">確認</button>
      </div>
    </div>
  </div>
@endif
@endsection
@section('content')
	<div class="container login_page">
		<form class="form_signin" action="/sales/sales-verify" method="post">
			{!! csrf_field() !!}
			<input type="hidden" name="hash" value="{{ $hash }}">
			<h1 class="form_signin_heading">業務驗證</h1>
			<label for="mobile" class="sr-only">UserMobile</label>
			<input type="text" id="mobile" class="form-control" name="mobile" placeholder="手機號碼" required="" autofocus="">
			<label for="contactmail" class="sr-only">UserContactmail</label>
			<input type="text" id="contactmail" class="form-control" name="contactmail" placeholder="電子信箱" required="" autofocus="">
			<button class="btn btn-block btn_login" type="submit">確定</button>
		</form>
	</div>
@if($errors->any())
  <div class="prompt_body">
    <div class="prompt_box panel-primary">
  		<div class="panel-heading">
      	<h3>提示框</h3>
      </div>
      <h2>{{$errors->first()}}</h2>
      <button type="button" class="btn btn-primary btn_yes">確認</button>
    </div>
  </div>
@endif
@endsection