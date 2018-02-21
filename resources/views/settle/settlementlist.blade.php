@extends('layouts.layout')

@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/settlementlist.js"></script>
@endsection

@section("content_body")
<div class="panel panel-primary col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
    <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
        <h1>結算記錄列表</h1>
    </div>
    <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
        <div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
            <form action="/settle/settlementlist" class="search_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="get">
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
                @if(isset($searchdata['sort']))
                    <input type="hidden" name="sort" value="{{ $searchdata['sort'] }}">
                @else
                    <input type="hidden" name="sort" value="ssrm_settledate">
                @endif
                @if(isset($searchdata['order']))
                    <input type="hidden" name="order" value="{{ $searchdata['order'] }}">
                @else
                    <input type="hidden" name="order" value="DESC">
                @endif
          </form>
        <div class="col-md-12 col-sm-12 col-xs-12 btn_m_t btn_box">
                <button type="button" class="btn btn-info pull-right sl_detail">詳情</button>
            </div>
        </div>
        <div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
            <div class="sort_check col-md-6 col-sm-6 col-xs-6 p_l_r_dis" data-val="ssrm_settledate">結算日期 <i class="dis_none fa" aria-hidden="true"></i></div>
            <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">未核店家</div>
            <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">已核店家</div>
            <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">有誤店家</div>
        </div>
        <div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
        @if(isset($settledata))
            @if(count($settledata)!=0)
                @foreach ($settledata as $data)
                    <form action="/settle/settlementshoplist" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="ssrm_settledate" value="{{ $data['ssrm_settledate'] }}">
                        <div class="col-md-6 col-sm-6 col-xs-6 text_left">{{ $data['ssrm_settledate'] }}</div>
                        <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data['settlementreview_0'] }}家</div>
                        <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data['settlementreview_1'] }}家</div>
                        <div class="col-md-2 col-sm-2 col-xs-2 p_l_r_dis">{{ $data['settlementreview_2'] }}家</div>
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