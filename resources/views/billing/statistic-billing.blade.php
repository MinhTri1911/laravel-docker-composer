@extends('layouts.white')

@section('title',__('billing.title_statistic_billing'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/statistic-billing.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('content')
    <div class="main-content" id="statistic-billing">
        <h1 class="main-heading">{{__('billing.title_statistic_billing')}}</h1>
        <div class="main-summary billing-paper col-md-12">
            <div class="titlle-form-search">
                <!--<h2>{{ __('billing.head_search') }}</h2>-->
            </div>

            <!--Begin form search-->
            {!!Form::open(['method' => 'GET'])!!}
                <div class="content-form">
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_object_statistic')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select('slt_object_statistic', $model['objectStatistic'], null, ['class' => 'form-control', 'id' => 'slt-object-statistic']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group rdo-year">
                        <div class="left-side">
                            <div class="custom-radio">
                                <input class="hidden" id="rdo_year" name="rdo_year" checked="checked" type="radio" value="0">
                                <label for="rdo_year">{{__('billing.lbl_statistic_year')}}：</label>
                            </div>
                        </div>
                        <div class="right-side">
                           <div class="custom-select">
                                {!! Form::select('slt_year', $model['year'], 2018, ['class' => 'form-control', 'id' => 'slt-year']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="left-side">
                            <div class="custom-radio">
                                <input class="hidden" id="rdo_many_year" name="rdo_year" type="radio" value="1">
                                <label for="rdo_many_year">{{__('billing.lbl_statistic_many_year')}}：</label>
                            </div>
                        </div>
                        <div class="right-side">
                           <div class="custom-select">
                                {!! Form::select('slt_start_year', $model['year'], null, ['class' => 'form-control', 'id' => 'slt-start-year']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group between">～</div>
                    <div class="form-group end">
                        <div class="custom-select">
                           {!! Form::select('slt_end_year', $model['year'], null, ['class' => 'form-control', 'id' => 'slt-end-year']) !!}
                       </div>
                    </div>

                    <div class="form-btn-statistic">
                        {!! Form::button( __('billing.btn_statistic'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-statistic']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
            
            <!--Description year-->
            <div class="block-description-year clear-both">
                <div class="form-group">
                    <label class="label-control">2018年:</label>
                    <label class="label-control">2.025.652（円）</label>
                </div>
                <div class="form-group">
                    <div class="item-content">
                        <label class="label-control">{{__('billing.lbl_half_before_year')}}:</label>
                        <label class="label-control">2.025.652（円）</label>
                    </div>
                    <div class="item-content">
                        <label class="label-control">{{__('billing.lbl_half_after_year')}}:</label>
                        <label class="label-control">2.025.652（円）</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="item-content">
                        <label class="label-control">{{__('billing.lbl_quarter_1')}}:</label>
                        <label class="label-control">2.025.652（円）</label>
                    </div>
                    <div class="item-content">
                        <label class="label-control">{{__('billing.lbl_quarter_2')}}:</label>
                        <label class="label-control">2.025.652（円）</label>
                    </div>
                    <div class="item-content">
                        <label class="label-control">{{__('billing.lbl_quarter_3')}}:</label>
                        <label class="label-control">2.025.652（円）</label>
                    </div>
                    <div class="item-content">
                        <label class="label-control">{{__('billing.lbl_quarter_4')}}:</label>
                        <label class="label-control">2.025.652（円）</label>
                    </div>
                </div>
            </div>

            <!--Area table-->
            <div class="area-table">
                <!-- Title table -->
                <div class="block-title-tbl clear-both">
                    <div class="left-side" style="padding-left: 10px;">
                        <label class="label-control">{{__('billing.lbl_detail')}}</label>
                    </div>
                    <div class="right-side">
                        <div class="form-group">
                            {!! Form::button( __('billing.btn_print'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-print']) !!}
                            {!! Form::button( __('billing.btn_output_csv'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-output-csv']) !!}
                        </div>
                    </div>
                </div>

                <!--Table statistic billing-->
                <div id="block-tbl-statistic" class="clear-both">
                    <table class="table table-blue table-statistic">
                        <thead>
                            <tr>
                                <th class="tbl-row-service">{{__('billing.tbl_statistic_header.service_name')}}<i class="fa fa-sort"></i></th>
                                @for($i = 1; $i<13; $i++ )
                                    <th class="tbl-row-month">{{$i . __('billing.tbl_statistic_header.month')}}<i class="fa fa-sort"></i></th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @for($j = 0; $j<25; $j++ ) 
                                <tr>
                                    <td class="tbl-row-service">PMS-AAA</td>
                                    @for($i = 1; $i<13; $i++ )
                                        <td class="tbl-row-month">2.025.652</td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 clear-both">
                    <nav class="text-center" aria-label="...">
                        <ul class="pagination">
                            <li class="page-item disabled">
                              <span class="page-link">Previous</span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">
                                    1
                                    <span class="sr-only">(current)</span>
                                </span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!--Area chart-->
            <div class="area-chart">
                <!--Title chart-->
                <div class="form-group">
                    <label class="label-control">{{__('billing.lbl_title_chart')}}</label>
                </div>
                <div class="chart-statistic">
                    <canvas id="chart-billing" width="600" height="400"></canvas>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/statistic-billing.js') }}"></script>
@endsection