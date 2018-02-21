<?php
$title = "商品細節";
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
<script type="text/javascript" src="/js/view/shopcoupon.js"></script>
@endsection
@section("content_body")
<form action="/shop/shopcoupon" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
	<input type="hidden" name="scm_id" value="{{ $shopcoupon['scm_id'] }}">
	<input type="hidden" name="sd_id" value="{{ $shopcoupon['sd_id'] }}">
	<input type="hidden" name="scm_poststatus" value="{{ $shopcoupon['scm_poststatus'] }}">
</form>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h1>{{ $shopcoupon['scm_title'] }}</h1>
        </div>
        <div class="title_right">
            <button type="button" class="btn btn-warning pull-right sc_status m_l">停 / 啟用</button>
						<a href="/shop/shopcoupondata-list" class="btn btn-info pull-right m_l">返回</a>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>商品封面</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            	@if($shopcoupon['scm_mainpic'] != '')
            		<img src="{{ config('global.pic_domainpath') }}iscar_app/shopdata/{{ $shopcoupon['scm_mainpic'] }}" style="width:100%; border-radius: 5px;">
							@else
								<img src="/images/imgDefault.png" style="width:100%; border-radius: 5px;">
	            @endif
	          </div>
	        </div>
	      </div>
	      <div class="col-md-6 col-sm-6 col-xs-12">
	        <div class="x_panel">
	            <div class="x_title">
	              	<h2>商品資訊</h2>
	              	<ul class="nav navbar-right panel_toolbox">
	                	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                	</li>
	                	<li><a class="close-link"><i class="fa fa-close"></i></a>
	                	</li>
	              	</ul>
	              	<div class="clearfix"></div>
	            </div>
	            <div class="x_content">
	            	<p>活動時間：{{ $shopcoupon['scm_startdate'] }} ~ {{ $shopcoupon['scm_enddate'] }}</p>
	            	<p>費用：{{ $shopcoupon['scm_price'] }}</p>
	            	<p>活動說明：{{ $shopcoupon['scm_fulldescript'] }}</p>
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
	            	@if(!is_null($shopcoupon['sd_shoptel']) && $shopcoupon['sd_shoptel']!='')
	            		<p>電話：{{ $shopcoupon['sd_shoptel'] }}</p>
	            	@else
	            		<p>電話：店家暫無設定</p>
	            	@endif
	            	@if(!is_null($shopcoupon['sd_weeklystart']) && !is_null($shopcoupon['sd_weeklyend']) && $shopcoupon['sd_weeklystart'] != '' && $shopcoupon['sd_weeklyend'] != '')
	            		<p>營業日期：星期{{ $shopcoupon['sd_weeklystart'] }} ~ 星期{{ $shopcoupon['sd_weeklyend'] }}</p>
	            	@else
	            		<p>營業日期：店家暫無設定</p>
	            	@endif
	            	@if(!is_null($shopcoupon['sd_dailystart']) && !is_null($shopcoupon['sd_dailyend']) && $shopcoupon['sd_dailystart'] != '' && $shopcoupon['sd_dailyend'] != '')
	            		<p>營業時間：{{ $shopcoupon['sd_dailystart'] }} ~ {{ $shopcoupon['sd_dailyend'] }}</p>
	            	@else
									<p>營業時間：店家暫無設定</p>
	            	@endif
	            	@if(!is_null($shopcoupon['sd_shopaddress']) && $shopcoupon['sd_shopaddress'] != '')
	            		<p>地址：{{ $shopcoupon['sd_shopaddress'] }}</p>
	            	@else
	            		<p>地址：店家暫無設定</p>
	            	@endif
	            </div>
	        </div>
	    	</div>
        @if($shopcoupon['sd_introtext'] != '')
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
	            	<p>{{ $shopcoupon['sd_introtext'] }}</p>
	            </div>
	          </div>
	        </div>
	    @endif
        @if($shopcoupon['sd_advancedata'] != '')
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
	            	<p>{{ $shopcoupon['sd_advancedata'] }}</p>
	            </div>
	          </div>
	        </div>
	    @endif
				@if(count($shopcoupon['scm_advancedescribe'])>0)
					<div class="col-md-12 col-sm-12 col-xs-12">
	          <div class="x_panel">
	            <div class="x_title">
	              <h2>商品圖片集</h2>
	              <ul class="nav navbar-right panel_toolbox">
	                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                </li>
	                <li><a class="close-link"><i class="fa fa-close"></i></a>
	                </li>
	              </ul>
	              <div class="clearfix"></div>
	            </div>
	            <div class="x_content">
								@foreach ($shopcoupon['scm_advancedescribe'] as $val)
									@if($val['content_text'] != '')
										<p>{{$val['content_text']}}</p>
									@endif
		            	@if($val['content_img'] != '')
		            		<img src="{{ config('global.pic_domainpath') }}iscar_app/shopdata/{{ $val['content_img'] }}" style="width:100%; border-radius: 5px;">
			            @endif
			          @endforeach
		          </div>
		        </div>
		      </div>
				@endif
    </div>
</div>
@endsection