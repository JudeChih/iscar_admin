@extends('layouts.layout')

@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/index.js"></script>
@endsection

@section("content_body")
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 widget_tally_box">
    <div class="x_panel ui-ribbon-container">
        <div class="ui-ribbon-wrapper">
            <div class="ui-ribbon">
              Iscar PM
            </div>
        </div>
        <div class="x_title">
            <h2>業務管理</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            {{-- <div style="text-align: center; margin-bottom: 17px">
              
            </div> --}}

            <h3 class="name_title"><a href="/sales/sales-management">業務列表</a></h3>
            <h3 class="name_title"><a href="/sales/sales-binding">綁定業務</a></h3>
            {{-- <p>Short Description</p>

            <div class="divider"></div>

            <p>If you've decided to go in  --}}{{-- development mode and tweak all of this a bit, there are few things you should do.</p> --}}
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 widget_tally_box">
    <div class="x_panel ui-ribbon-container">
        <div class="ui-ribbon-wrapper">
            <div class="ui-ribbon">
              Iscar PM
            </div>
        </div>
        <div class="x_title">
            <h2>特店管理</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            {{-- <div style="text-align: center; margin-bottom: 17px">
              
            </div> --}}

            <h3 class="name_title"><a href="/shop/shoptype">特店統計表</a></h3>
            <h3 class="name_title"><a href="/shop/shopdata-list">特店列表</a></h3>
            <h3 class="name_title"><a href="/shop/shopcoupondata-list">商品列表</a></h3>
            <h3 class="name_title"><a href="/batch/batch-import">批量新增特店</a></h3>
            {{-- <p>Short Description</p>

            <div class="divider"></div>

            <p>If you've decided to go in  --}}{{-- development mode and tweak all of this a bit, there are few things you should do.</p> --}}
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 widget_tally_box">
    <div class="x_panel ui-ribbon-container">
        <div class="ui-ribbon-wrapper">
            <div class="ui-ribbon">
              Iscar Service
            </div>
        </div>
        <div class="x_title">
            <h2>系統服務管理</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            {{-- <div style="text-align: center; margin-bottom: 17px">
              
            </div> --}}

            <h3 class="name_title"><a href="/service/announcement">活動公告列表</a></h3>
            <h3 class="name_title"><a href="/service/activity">活動項目列表</a></h3>
            {{-- <p>Short Description</p>

            <div class="divider"></div>

            <p>If you've decided to go in  --}}{{-- development mode and tweak all of this a bit, there are few things you should do.</p> --}}
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 widget_tally_box">
    <div class="x_panel ui-ribbon-container">
        <div class="ui-ribbon-wrapper">
            <div class="ui-ribbon">
              Iscar PM
            </div>
        </div>
        <div class="x_title">
            <h2>帳務結算管理</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            {{-- <div style="text-align: center; margin-bottom: 17px">
              
            </div> --}}

            <h3 class="name_title"><a href="/settle/settlementlist">帳務結算紀錄</a></h3>
            {{-- <p>Short Description</p>

            <div class="divider"></div>

            <p>If you've decided to go in  --}}{{-- development mode and tweak all of this a bit, there are few things you should do.</p> --}}
        </div>
    </div>
</div>
@if(!empty(Session::get('admin')))
    @if(Session::get('admin') == 1)
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 widget_tally_box">
            <div class="x_panel ui-ribbon-container">
                <div class="ui-ribbon-wrapper">
                    <div class="ui-ribbon">
                      Iscar Admin
                    </div>
                </div>
                <div class="x_title">
                    <h2>後台管理</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    {{-- <div style="text-align: center; margin-bottom: 17px">
                      
                    </div> --}}

                    <h3 class="name_title"><a href="/login/user-list">使用者列表</a></h3>
                    <h3 class="name_title"><a href="/login/user-list-create">新增使用者</a></h3>
                    {{-- <p>Short Description</p>

                    <div class="divider"></div>

                    <p>If you've decided to go in  --}}{{-- development mode and tweak all of this a bit, there are few things you should do.</p> --}}
                </div>
            </div>
        </div>
    @endif
@endif
@endsection