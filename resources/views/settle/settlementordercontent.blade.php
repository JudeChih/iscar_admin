@extends('layouts.layout')

@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/settlementordercontent.js"></script>
@endsection

@section("content_body")
<form class="back_form" action="/settle/settlementcontent" method="post" style="display: none;">
	{!! csrf_field() !!}
	<input type="hidden" name="ssrm_settledate" value="{{ $searchdata['ssrm_settledate'] }}">
	<input type="hidden" name="sd_id" value="{{ $searchdata['sd_id'] }}">
</form>
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1>消費記錄列表</h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
        <div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
            <form action="/settle/settlementordercontent" class="search_form col-md-9 col-sm-9 col-xs-9 p_l_r_dis" method="get">
                {!! csrf_field() !!}
                <!-- 所有的查詢參數都會隱藏放置在這邊 -->
                @if(isset($searchdata['total_page']))
                    <input type="hidden" name="total_page" value="{{ $searchdata['total_page'] }}">
                @else
                    <input type="hidden" name="total_page" value="">
                @endif
                @if(isset($searchdata['skip_page']))
                    <input type="hidden" name="skip_page" value="{{ $searchdata['skip_page'] }}">
                @else
                    <input type="hidden" name="skip_page" value="0">
                @endif
                @if(isset($searchdata['sd_id']))
					<input type="hidden" name="sd_id" value="{{ $searchdata['sd_id'] }}">
                @else
					<input type="hidden" name="sd_id" value="">
                @endif
                @if(isset($searchdata['ssrm_settledate']))
					<input type="hidden" name="ssrm_settledate" value="{{ $searchdata['ssrm_settledate'] }}">
                @else
					<input type="hidden" name="ssrm_settledate" value="">
                @endif
                @if(isset($searchdata['sort']))
                    <input type="hidden" name="sort" value="{{ $searchdata['sort'] }}">
                @else
                    <input type="hidden" name="sort" value="scg_id">
                @endif
                @if(isset($searchdata['order']))
                    <input type="hidden" name="order" value="{{ $searchdata['order'] }}">
                @else
                    <input type="hidden" name="order" value="DESC">
                @endif
                @if(isset($searchdata['ssrd_billingtype']))
                    <input type="hidden" name="ssrd_billingtype" value="{{ $searchdata['ssrd_billingtype'] }}">
                @else
                    <input type="hidden" name="ssrd_billingtype" value="0">
                @endif
                <div class="col-md-12 col-sm-12 col-xs-12 ssrd_billingtype">
			    	<select class="form-control m_b">
			    		<option value="0">全部店家</option>
			    		<option value="1">一般結帳</option>
			    		<option value="2">禮點折抵</option>
			    		<option value="3">特點兌換</option>
			    	</select>
			    </div>
          	</form>
        	<div class="col-md-3 col-sm-3 col-xs-3 btn_m_t btn_box">
        		<button type="button" class="btn btn-primary pull-right soc_back">返回</button>
            </div>
        </div>
        <div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
            <div class="sort_check col-md-4 col-sm-4 col-xs-4 p_l_r_dis" data-val="scg_id">訂單編號 <i class="dis_none fa" aria-hidden="true"></i></div>
            <div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="ssrd_billingtype">結帳方式 <i class="dis_none fa" aria-hidden="true"></i></div>
            <div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="scg_paid_time">交易時間 <i class="dis_none fa" aria-hidden="true"></i></div>
            <div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="ssrm_spconsume">消費特點 <i class="dis_none fa" aria-hidden="true"></i></div>
            <div class="sort_check col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="ssrm_totalgpexchangetomoney">禮點折抵 <i class="dis_none fa" aria-hidden="true"></i></div>
            <div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">服務費</div>
            <div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="ssrm_amountafterdiscount">總計 <i class="dis_none fa" aria-hidden="true"></i></div>
        </div>
        <div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
        @if(isset($orderdata))
            @if(count($orderdata)!=0)
                @foreach ($orderdata as $data)
                    <form action="/settle/settlementordercontent" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="ssrm_settledate" value="{{ $data['ssrm_settledate'] }}">
                        <div class="col-md-4 col-sm-4 col-xs-4 text_left"><span class="">{{ $data['scg_id'] }}</span></div>
                        <div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">
                        	@if($data['ssrd_billingtype'] == 1)
								一般結帳
                        	@elseif($data['ssrd_billingtype'] == 2)
								禮點折抵
                        	@elseif($data['ssrd_billingtype'] == 3)
								特點兌換
                        	@endif
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data['scg_paid_time'] }}</div>
                        <div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis"><span class="change_num">{{ $data['ssrm_spconsume'] }}</span>點</div>
                        <div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis"><span class="change_num">{{ $data['ssrm_totalgpexchangetomoney'] }}</span>元</div>
                        <div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis"><span class="change_num">{{ $data['ssrm_totaliscarplatformfee']+$data['ssrm_totalpaymentflowfee'] }}</span>元</div>
                        <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis"><span class="change_num">{{ $data['ssrm_amountafterdiscount'] }}</span>元</div>
                    </form>
            @endforeach
            @else
                <p>查無資料</p>
            @endif
        @else
            <p>查無任何訂單資料</p>
        @endif
        </div>
    </div>
    <div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
        	<nav aria-label="Page navigation">
	            <ul class="pagination" id="pagination"></ul>
	        </nav>
        </div>
    </div>
</div>
@endsection