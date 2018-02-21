<?php
$title = "特店細節";
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
<script type="text/javascript" src="/js/view/shopdata.js"></script>
@endsection
@section("content_body")
<form action="/shop/shopdata" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
	<input type="hidden" name="sd_id" value="{{ $shopdata['sd_id'] }}">
	<input type="hidden" name="sd_activestatus" value="{{ $shopdata['sd_activestatus'] }}">
</form>
<div class="">
    <div class="page-title">
        <div class="title_left">
        	@if(isset($shopdata['sd_shopname']) && $shopdata['sd_shopname'] != '')
            	<h1>{{ $shopdata['sd_shopname'] }}</h1>
            @endif
        </div>
        <div class="title_right">
            <button type="button" class="btn btn-warning pull-right sd_status m_l">停 / 啟用</button>
			<button type="button" class="btn btn-danger pull-right sd_flag m_l">刪除</button>
			<a href="/shop/shopdata-list" class="btn btn-info pull-right m_l">返回</a>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>店面圖片</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            	@if($shopdata['sd_shopphotopath'] != '')
            		<img src="{{ config('global.pic_domainpath') }}iscar_app/shopdata/{{ $shopdata['sd_shopphotopath'] }}" style="width:100%; border-radius: 5px;">
				@else
					<img src="/images/imgDefault.png" style="width:100%; border-radius: 5px;">
            	@endif
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
	        <div class="x_panel">
	            <div class="x_title">
	              	<h2>店家資訊</h2>
	              	<ul class="nav navbar-right panel_toolbox">
	                	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                	</li>
	                	<li><a class="close-link"><i class="fa fa-close"></i></a>
	                	</li>
	              	</ul>
	              	<div class="clearfix"></div>
	            </div>
	            <div class="x_content">
	            	@if(!is_null($shopdata['sd_shoptel']) && $shopdata['sd_shoptel']!='')
	            		<p>電話：{{ $shopdata['sd_shoptel'] }}</p>
	            	@else
	            		<p>電話：店家暫無設定</p>
	            	@endif
	            	@if(!is_null($shopdata['sd_weeklystart']) && !is_null($shopdata['sd_weeklyend']) && $shopdata['sd_weeklystart'] != '' && $shopdata['sd_weeklyend'] != '')
	            		<p>營業日期：星期{{ $shopdata['sd_weeklystart'] }} ~ 星期{{ $shopdata['sd_weeklyend'] }}</p>
	            	@else
	            		<p>營業日期：店家暫無設定</p>
	            	@endif
	            	@if(!is_null($shopdata['sd_dailystart']) && !is_null($shopdata['sd_dailyend']) && $shopdata['sd_dailystart'] != '' && $shopdata['sd_dailyend'] != '')
	            		<p>營業時間：{{ $shopdata['sd_dailystart'] }} ~ {{ $shopdata['sd_dailyend'] }}</p>
	            	@else
						<p>營業時間：店家暫無設定</p>
	            	@endif
	            	@if(!is_null($shopdata['sd_shopaddress']) && $shopdata['sd_shopaddress'] != '')
	            		<p>地址：{{ $shopdata['sd_shopaddress'] }}</p>
	            	@else
	            		<p>地址：店家暫無設定</p>
	            	@endif
	            </div>
	        </div>
	    </div>
        @if($shopdata['sd_introtext'] != '')
	        <div class="col-md-6 col-sm-6 col-xs-12">
	          <div class="x_panel">
	            <div class="x_title">
	              <h2>服務內容</h2>
	              <ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                </li>
	                <li><a class="close-link"><i class="fa fa-close"></i></a>
	                </li>
	              </ul>
	              <div class="clearfix"></div>
	            </div>
	            <div class="x_content">
	            	<p>{{ $shopdata['sd_introtext'] }}</p>
	            </div>
	          </div>
	        </div>
	    @endif
        @if($shopdata['sd_advancedata'] != '')
	        <div class="col-md-6 col-sm-6 col-xs-12">
	          <div class="x_panel">
	            <div class="x_title">
	              <h2>更多資訊</h2>
	              <ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                </li>
	                <li><a class="close-link"><i class="fa fa-close"></i></a>
	                </li>
	              </ul>
	              <div class="clearfix"></div>
	            </div>
	            <div class="x_content">
	            	<p>{{ $shopdata['sd_advancedata'] }}</p>
	            </div>
	          </div>
	        </div>
	    @endif

		@if(count($shopcoupon) >0)
	        <div class="col-md-6 col-sm-6 col-xs-12">
	          	<div class="x_panel">
	            	<div class="x_title">
	              		<h2>商品列表</h2>
	              		<ul class="nav navbar-right panel_toolbox">
	                		<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                		</li>
	                		<li><a class="close-link"><i class="fa fa-close"></i></a>
	                		</li>
	              		</ul>
	              		<div class="clearfix"></div>
	            	</div>
	            	<div class="x_content">
	              		<ul class="list-unstyled msg_list">
	              		@foreach ($shopcoupon as $val)
		                	<li>
		                  		<a>
				                    <span class="message">
				                      {{ $val['scm_title'] }}
				                    </span>
				                  </a>
		                	</li>
	                	@endforeach
	              		</ul>
	            	</div>
	          	</div>
	        </div>
	    @endif
    </div>
</div>
@endsection