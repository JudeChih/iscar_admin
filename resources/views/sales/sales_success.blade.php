<?php
	$title = "綁定成功";
?>
@extends('login/__login_index')
@section('content')

@if(isset($message))
  <div class="prompt_body">
    <div class="prompt_box panel-primary">
        <div class="panel-heading">
        <h3>提示框</h3>
      </div>
      <h2>{{$message}}</h2>
      <a href="http://tw.iscarmg.com/" class="btn btn-primary btn_yes">確認</a>
    </div>
  </div>
@endif

@endsection