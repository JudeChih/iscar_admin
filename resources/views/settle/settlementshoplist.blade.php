@extends('layouts.layout')
@section("prompt_box")
<div class="ssl_body">
    <div class="ssl_box panel-primary">
        <div class="panel-heading">
            <h3>匯入出款</h3>
        </div>
        <form style="margin-top: 15px;padding: 20px;" action="/settle/inpayment" class="inpayment_form form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="import_file" />
            <input type="hidden" name="ssrm_settlementreview" value="{{ $searchdata['ssrm_settlementreview'] }}">
            <button class="btn btn-primary btn_import">匯入</button>
            <p style="color:red;font-size: 12px;">*只能導入CSV或Excel類型的檔案</p>
        </form>
    </div>
</div>
@endsection
@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/settlementshoplist.js"></script>
@endsection
@section("content_body")
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1>{{ $searchdata['ssrm_settledate'] }}結算日特店列表</h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
        <div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
            <form action="/settle/settlementshoplist" class="search_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
            	{!! csrf_field() !!}
                <!-- 所有的查詢參數都會隱藏放置在這邊 -->
                <input type="hidden" name="ssrm_id" value="">
                <input type="hidden" name="ssrm_settledate" value="{{ $searchdata['ssrm_settledate'] }}">
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
                @if(isset($searchdata['sort']))
                    <input type="hidden" name="sort" value="{{ $searchdata['sort'] }}">
                @else
                    <input type="hidden" name="sort" value="sd_shopname">
                @endif
                @if(isset($searchdata['order']))
                    <input type="hidden" name="order" value="{{ $searchdata['order'] }}">
                @else
                    <input type="hidden" name="order" value="DESC">
                @endif
                @if(isset($searchdata['ssrm_settlementreview']))
                    <input type="hidden" name="ssrm_settlementreview" value="{{ $searchdata['ssrm_settlementreview'] }}">
                @else
                    <input type="hidden" name="ssrm_settlementreview" value="0">
                @endif
               	<div class="col-md-9 col-sm-9 col-xs-8  sd_search">
			    	<div class="input-group">
			    		<div class="input-group-btn">
				        <select class="form-control select_width">
				    		<option value="sd_shopname">特店名稱</option>
				    	</select>
				    	</div>
					  	@if(isset($searchdata['query_name']))
				    		<input type="text" name="query_name" class="form-control" placeholder="查詢名稱" value="{{ $searchdata['query_name'] }}">
						@else
							<input type="text" name="query_name" class="form-control" placeholder="查詢名稱">
						@endif
					</div>
			    </div>
                <div class="col-md-3 col-sm-3 col-xs-4 ssrm_settlementreview">
                    <select class="form-control m_b">
                        <option value="0">未覆核</option>
                        <option value="1">已覆核</option>
                        <option value="2">帳務有誤</option>
                        <option value="3">已覆核(系統)</option>
                    </select>
                </div>
{{-- 			    <div class="col-md-3 col-sm-3 col-xs-4 ssrm_settlementreview">
			    	<select class="form-control m_b">
			    		<option value="-1">全部店家</option>
			    		<option value="0">未覆核</option>
			    		<option value="1">已覆核</option>
			    		<option value="2">帳務有誤</option>
			    	</select>
			    </div>
			    <div class="col-md-2 col-sm-2 col-xs-4 ssrm_settlementpayment">
			    	<select class="form-control m_b">
			    		<option value="-1">全部店家</option>
			    		<option value="0">未出款</option>
			    		<option value="1">已出款</option>
			    	</select>
			    </div> --}}
			    <div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
			    	<button type="button" class="btn btn-default ssl_search m_r">查詢</button>
			    	<button type="button" class="btn btn-default ssl_clear">清除</button>
		    	</div>
          	</form>
        	<div class="col-md-12 col-sm-12 col-xs-12 btn_m_t btn_box">
                <button type="button" class="btn btn-info pull-right ssl_detail">詳情</button>
                @if(isset($searchdata['ssrm_settlementreview']))
                    @if($searchdata['ssrm_settlementreview'] == 0)
                        <button type="button" class="btn btn-warning pull-right ssl_review">覆核</button>
                        <button type="button" class="btn btn-warning pull-right ssl_out_payment">匯出出款紀錄</button>
                        <button type="button" class="btn btn-warning pull-right ssl_in_payment">匯入出款紀錄</button>
                    @elseif($searchdata['ssrm_settlementreview'] == 1)
                        <button type="button" class="btn btn-warning pull-right ssl_out_payment">匯出出款紀錄</button>
                        <button type="button" class="btn btn-warning pull-right ssl_in_payment">匯入出款紀錄</button>
                    @elseif($searchdata['ssrm_settlementreview'] == 2)
                    @endif
                @endif
                <a class="btn btn-primary pull-right ssl_back" href="/settle/settlementlist">返回</a>
            </div>
        </div>
        <div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
            <div class="sort_check col-md-6 col-sm-6 col-xs-6 p_l_r_dis" data-val="sd_shopname">特店名稱 <i class="dis_none fa" aria-hidden="true"></i></div>
            <div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="ssrm_settlementpayamount">應付金額</div>
            <div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="ssrm_settlementreview">覆核狀態</div>
            <div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="ssrm_settlementpayment">付款狀態</div>
        </div>
        <div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
        @if(isset($shopdata))
            @if(count($shopdata)!=0)
                @foreach ($shopdata as $data)
                    <form action="/settle/settlementcontent" class="ssl_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="ssrm_id" value="{{ $data['ssrm_id'] }}">
                        <input type="hidden" name="ssrm_settledate" value="{{ $data['ssrm_settledate'] }}">
                        <input type="hidden" name="sd_id" value="{{ $data['sd_id'] }}">
                        <input type="hidden" name="ssrm_settlementreview" value="{{ $data['ssrm_settlementreview'] }}">
                        <input type="hidden" name="ssrm_settlementpayment" value="{{ $data['ssrm_settlementpayment'] }}">
                        <div class="col-md-5 col-sm-5 col-xs-5 text_left">{{ $data['sd_shopname'] }}</div>
                        <div class="col-md-3 col-sm-3 col-xs-3 p_l_r_dis">{{ $data['ssrm_settlementpayamount'] }}</div>
                        <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">
							@if($data['ssrm_settlementreview'] == 0)
								未覆核
							@elseif($data['ssrm_settlementreview'] == 1)
								已覆核
							@elseif($data['ssrm_settlementreview'] == 2)
								帳務有誤
                            @elseif($data['ssrm_settlementreview'] == 3)
                                已覆核(系統)
							@endif
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">
							@if($data['ssrm_settlementpayment'] == 0)
								未出款
							@elseif($data['ssrm_settlementpayment'] == 1)
								已出款
							@elseif($data['ssrm_settlementpayment'] == 2)
								調帳中
							@endif
                        </div>
                    </form>
            @endforeach
            @else
                <p>查無資料</p>
            @endif
        @else
            <p>目前暫無任何結算日資料</p>
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