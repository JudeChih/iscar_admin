<?php
	$title = "批量新增特店";
?>

@extends('layouts/layout')
@section("put_script")
<!-- 崁入各頁面的JS -->
<script src="{{ URL::asset('js/view/batchimport.js') }}"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-10 col-sm-12 col-md-offset-1 col-xs-12 p_l_r_dis">
  <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
      <h1><?= isset($title) ? $title : '' ?></h1>
  </div>
  <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
	@if ($message = Session::get('success'))
		<div class="alert alert-success" role="alert">
			{{ Session::get('success') }}
		</div>
	@endif

	@if ($message = Session::get('error'))
		<div class="alert alert-danger" role="alert">
			{{ Session::get('error') }}
		</div>
	@endif
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h3>批量新增:</h3>
			<form style="margin-top: 15px;padding: 20px;" action="/batch/import-excel" class="form-horizontal" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="file" name="import_file" />

				<button class="btn btn-primary btn_import">Import</button>
				<p style="color:red;font-size: 12px;">*只能導入CSV或Excel類型的檔案</p>

			</form>
			<br/>


			<h3>下載範例:</h3>
			<div style="margin-top: 15px;padding: 20px;">
				<a href="{{ url('/batch/export-excel/xlsx') }}"><button class="btn btn-success">Excel xlsx</button></a>
				<p style="color:red;font-size: 12px;">*下載範例，直接依序填寫在相對應的欄位下方</p>
			</div>
		</div>
	</div>
	<div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
		<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">

		</div>
	</div>
</div>
@endsection
