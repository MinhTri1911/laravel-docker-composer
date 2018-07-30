@extends('layouts.white')

@section('title', trans('company.head_list_company'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/company-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'list-common-company')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('company.head_list_company') }}</h1>

        <div class="main-summary">
            <!--begin form search-->
            <div class="col-md-12 block-search input-search">
                <div class="block-left">
                    <div class="lbl-text">
                        <label class="label-control" for="group-type">{{ trans('company.lbl_group_type') }}</label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('group-type', [
                                0 => trans('company.select_group_company'),
                                1 => trans('company.select_group_system'),
                            ], null,
                            ['class' => 'form-control', 'tabindex' => 1, 'id' => 'group-type'])
                        }}
                    </div>
                </div>

                <div class="block-right">
                    <div class="lbl-text">
                        <label class="label-control" for="show-type">{{ trans('company.lbl_show_type') }}</label>
                    </div>
                    @php
                        $showType = [
                            Constant::SHOW_ACTIVE => trans('company.lbl_not_show'),
                            Constant::SHOW_NOT_ACTIVE => trans('company.lbl_show'),
                        ];
                    @endphp
                    <div class="form-input custom-select">
                        {{ Form::select('show-type', $showType, Constant::SHOW_ACTIVE, [
                                'class' => 'form-control',
                                'tabindex' => 2,
                                'id' => 'show-type'
                            ])
                        }}
                    </div>

                    <div class="lbl-text">
                        <label class="label-control" for="paginate-record">{{ trans('company.lbl_paginate_record') }}</label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('paginate-record', config('pagination.paginate_value'), config('pagination.default'),
                            ['class' => 'form-control', 'tabindex' => 3, 'id' => 'load-result'])
                        }}
                    </div>

                    {{ Form::button(trans('company.btn_search_company'), [
                            'class' => 'btn btn-blue-dark btn-w150',
                            'tabindex' => 4,
                            'name' => 'search-company',
                            'id' => 'btn-search-company',
                            'data-url' => route('company.search'),
                        ])
                    }}
                    {{ Form::hidden('value-after-search', '{"group": "0", "load": "10", "showType": "0"}', ['id' => 'value-after-search']) }}
                    {{ Form::hidden('sort-value', '{
                            "filter-company": "0",
                            "filter-service": "0",
                            "filter-nation": "0",
                            "filter-address": "0",
                            "filter-company-operation": "0"
                        }', [
                            'id' => 'sort-value',
                            'data-url' => $url,
                            'data-current-sort' => 'filter-company',
                        ])
                    }}
                </div>
            </div>
            <!--end form search-->

            <!--begin table show result-->
            <div class="row"></div>

            <div class="col-md-12">
                <p id="total-result">
                    {{ trans('company.lbl_total_result', ['total' => count(collect($companies->items())->groupBy('id'))]) }}
                </p>

                <div class="block-table">
                    @include('company.component.list.table-group-company')
                </div>
            </div>
            <!--end table show result-->

            <div class="row"></div>

            <div class="col-md-12 block-button">
                <a class="btn btn-green-dark btn-w150" href="{{ route('company.create') }}" tabindex="8">
                    {{ trans('company.go_to_create_company') }}
                </a>
                <a class="btn btn-green-dark btn-w150"
                    data-url="{{ route('billing.history.billing') }}"
                    href="javascript:void(0)"
                    id="history-billing"
                    tabindex="7">
                    {{ trans('company.go_to_history_billing') }}
                </a>
                <a class="btn btn-green-dark btn-w150" href="{{ route('billing.index') }}" tabindex="6">
                    {{ trans('company.go_to_create_billing_paper') }}
                </a>
                <a href="{{ route('ship.index') }}" class="btn btn-green-dark btn-w150" tabindex="5">{{ trans('company.go_to_list_ship') }}</a>
            </div>

            <div class="row"></div>

            <div class="col-md-12" id="area-paginate">
                @include('company.component.paginate.default', ['paginator' => $companies])
            </div>
        </div>
    </div>
    <div class="modal modal-protector fade" id="modal-protector" tabindex="-1" role="dialog" style="display: none;"></div>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/company-general-list-company.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            const table = document.querySelector('.block-table');
            const psWidth = new PerfectScrollbar(table, function () {
                table.style.width = '100%'
            });

            // Remove class when init
            $('.block-table').removeClass('ps--active-y');
        });
    </script>
@endsection
