@extends('layouts.layout')

@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/settlementcontent.js"></script>
@endsection

@section("content_body")
<form class="back_form" action="/settle/settlementshoplist" method="post" style="display: none;">
	{!! csrf_field() !!}
	<input type="hidden" name="ssrm_settledate" value="{{ $settledata_m['ssrm_settledate'] }}">
</form>
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1>{{ $settledata_m['sd_shopname'] }}</h1><span>本期銷售一覽</span>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
        <div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
        	<div class="col-md-12 col-sm-12 col-xs-12 btn_m_t btn_box">
                <button type="button" class="btn btn-info pull-right sc_detail">明細</button>
                <button type="button" class="btn btn-primary pull-right sc_back">返回</button>
            </div>
            <form action="/settle/settlementordercontent" class="form-horizontal sc_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
            	{!! csrf_field() !!}
                <!-- 所有的查詢參數都會隱藏放置在這邊 -->
                <input type="hidden" name="ssrm_settledate" value="{{ $settledata_m['ssrm_settledate'] }}">
                <input type="hidden" name="sd_id" value="{{ $settledata_m['sd_id'] }}">
               	<div class="col-md-12 col-sm-12 col-xs-12">
               		<blockquote>
					  <p>日期時間</p>
					  {{-- <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer> --}}
					</blockquote>
               		<div class="form-group">
					    <label class="col-sm-2 control-label">結算週期啟始日</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$settledata_m['ssrm_billingcycle_start']}}</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">結算週期結束日</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$settledata_m['ssrm_billingcycle_end']}}</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">預計支付日</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$settledata_m['ssrm_billpaymentday']}}</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">實際支付日</label>
					    <div class="col-sm-10">
					      <p class="form-control-static">{{$settledata_m['ssrm_actualbillpaymentday']}}</p>
					    </div>
					</div>
			    	{{-- <div>結算週期啟始日:{{$settledata_m['ssrm_billingcycle_start']}}</div> --}}
			    	{{-- <div>結算週期結束日:{{$settledata_m['ssrm_billingcycle_end']}}</div> --}}
			    	{{-- <div>預計支付日:{{$settledata_m['ssrm_billpaymentday']}}</div> --}}
			    	{{-- <div>實際支付日:{{$settledata_m['ssrm_actualbillpaymentday']}}</div> --}}
			    	<blockquote>
					  <p>交易筆數</p>
					  {{-- <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer> --}}
					</blockquote>
			    	<div class="form-group">
					    <label class="col-sm-2 control-label">總計交易筆數</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_totaltransatctioncount']}}</span>筆</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">一般交易筆數</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_salewithoutdiscount']}}</span>筆</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">禮點折抵筆數</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_salewithgp']}}</span>筆</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">特點交易筆數</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_salebypp']}}</span>筆</p>
					    </div>
					</div>
			    	{{-- <div>總計交易筆數:{{$settledata_m['ssrm_totaltransatctioncount']}}</div>
			    	<div>一般交易筆數:{{$settledata_m['ssrm_salewithoutdiscount']}}</div>
			    	<div>禮點折抵筆數:{{$settledata_m['ssrm_salewithgp']}}</div>
			    	<div>特點交易筆數:{{$settledata_m['ssrm_salebypp']}}</div> --}}
			    	<blockquote>
					  <p>交易金額</p>
					  {{-- <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer> --}}
					</blockquote>
			    	<div class="form-group">
					    <label class="col-sm-2 control-label">未折扣的交易總額</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_saleamountnodiscount']}}</span>元</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">總計特點消費數額</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_totalppconsume']}}</span>元</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">折扣後總計金額</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_amountafterdiscount']}}</span>元</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">總計禮點使用數額</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_totalgpconsume']}}</span>元</p>
					    </div>
					</div>
			    	{{-- <div>未折扣的交易總額:{{$settledata_m['ssrm_saleamountnodiscount']}}</div>
			    	<div>總計特點消費數額:{{$settledata_m['ssrm_totalppconsume']}}</div>
			    	<div>折扣後總計金額:{{$settledata_m['ssrm_amountafterdiscount']}}</div>
			    	<div>總計禮點使用數額:{{$settledata_m['ssrm_totalgpconsume']}}</div> --}}
			    	<div class="form-group">
					    <label class="col-sm-2 control-label">總計禮點折抵金額</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_totalgpexchangetomoney']}}</span>元</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">本期iscar平台手續費</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_totaliscarplatformfee']}}</span>元</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">本期金流平台手續費</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_totalpaymentflowfee']}}</span>元</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">本期iscar結算應付金額</label>
					    <div class="col-sm-10">
					      <p class="form-control-static"><span class="change_num">{{$settledata_m['ssrm_settlementpayamount']}}</span>元</p>
					    </div>
					</div>
			    	{{-- <div>總計禮點折抵金額:{{$settledata_m['ssrm_totalgpexchangetomoney']}}</div>
			    	<div>本期iscar平台手續費:{{$settledata_m['ssrm_totaliscarplatformfee']}}</div>
			    	<div>本期金流平台手續費:{{$settledata_m['ssrm_totalpaymentflowfee']}}</div>
			    	<div>本期iscar結算應付金額:{{$settledata_m['ssrm_settlementpayamount']}}</div> --}}
			    	<blockquote>
					  <p>店家狀態</p>
					  {{-- <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer> --}}
					</blockquote>
			    	<div class="form-group">
					    <label class="col-sm-2 control-label">店家覆核狀態</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static">
						      	@if($settledata_m['ssrm_settlementreview'] == 0)
									未覆核
								@elseif($settledata_m['ssrm_settlementreview'] == 1)
									已覆核
								@elseif($settledata_m['ssrm_settlementreview'] == 2)
									帳務有誤
								@elseif($settledata_m['ssrm_settlementreview'] == 3)
									已覆核(系統)
								@endif
					      	</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-2 control-label">平台付款狀態</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static">
						      	@if($settledata_m['ssrm_settlementpayment'] == 0)
									未出款
						      	@elseif($settledata_m['ssrm_settlementpayment'] == 1)
									已出款
						      	@elseif($settledata_m['ssrm_settlementpayment'] == 2)
									調帳中，暫不出款
						      	@endif
					  		</p>
					    </div>
					</div>
			    	{{-- <div>店家覆核狀態:{{$settledata_m['ssrm_settlementreview']}}</div>
			    	<div>平台付款狀態:{{$settledata_m['ssrm_settlementpayment']}}</div> --}}
			    </div>
          	</form>
        </div>
    </div>
</div>
@endsection