@extends('layouts.layout')

@section("put_script")
<!-- 崁入各頁面的JS -->
<script type="text/javascript" src="/js/view/shoptype.js"></script>
@endsection

@section("content_body")
@if(isset($shoptype))
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>特店各項統計表</h1>
    </div>
    @foreach ($shoptype as $key => $data)
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 set_canvas">
            <div class="x_panel tile fixed_height_320 overflow_hidden">
                <div class="x_title">
                    <h2>{{$data[0]}}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="" style="width:100%">
                        <tr>
                            <td style="width:37%;">
                                <canvas id="{{$key}}" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                            </td>
                            <td>
                                <table class="tile_info">
                                    <tr>
                                        <td>
                                            <p class="st_bind" data-val="{{$data[1]}}"><i class="fa fa-square red"></i>已綁定 {{$data[1]}} 家</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="st_unbind" data-val="{{$data[2]}}"><i class="fa fa-square green"></i>未綁定 {{$data[2]}} 家</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@else
<p>暫無任何特店的資料</p>
@endif
@endsection