@extends('layouts.white')

@section('title', trans('ship.head_title_list_ship'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/ship-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'list-ship')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('ship.head_title_list_ship') }}</h1>

        <div class="main-summary">
            <div class="row">
                <div class="col-md-12">
                    <div class="block-list-ship">
                        <a class="none-focus-outline" href="{{ route('ship.index') }}" tabindex="1">
                            {{ trans('ship.link_search_all') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 block-list-ship">
                        <label>{{ trans('ship.lbl_total_result', ['total' => 300]) }}</label>

                        <div class="block-right">
                            <div class="col-md-4">
                                <label>
                                    {{ trans('ship.lbl_load_result') }}
                                </label>
                            </div>
                            <div class="load-result custom-select">
                                {{ Form::select('slb-load-result', [1 => 10, 2 => 20, 3 => 50], 1, [
                                        'class' => 'form-control',
                                        'tabindex' => 2,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="block-list-ship">
                        <div class="block-table">
                            <table class="table table-blue table-result">
                                <thead>
                                    <tr>
                                        <th class="col-ship-name">
                                            <div class="th-line-one">
                                                {{ trans('ship.lbl_title_ship_name') }}
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="th-line-two">
                                                {{ Form::text('ship-name-filter', null, ['class' => 'form-control', 'tabindex' => 3]) }}
                                            </div>
                                        </th>
                                        <th class="col-company-name">
                                            <div class="th-line-one">
                                                {{ trans('ship.lbl_title_company_name') }}
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="th-line-two">
                                                {{ Form::text('company-name-filter', null, ['class' => 'form-control', 'tabindex' => 4]) }}
                                            </div>
                                        </th>
                                        <th class="col-classification">
                                            <div class="th-line-one">
                                                {{ trans('ship.lbl_title_classification') }}
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="th-line-two">
                                                {{ Form::text('ship-classification', null, ['class' => 'form-control', 'tabindex' => 5]) }}
                                            </div>
                                        </th>
                                        <th class="col-ship-type">
                                            <div class="th-line-one">
                                                {{ trans('ship.lbl_title_ship_type') }}
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="th-line-two">
                                                {{ Form::text('ship-type-filter', null, ['class' => 'form-control', 'tabindex' => 6]) }}
                                            </div>
                                        </th>
                                        <th class="col-imo-number">
                                            <div class="th-line-one">
                                                {{ trans('ship.lbl_title_imo_number') }}
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="th-line-two">
                                                {{ Form::text('imo-number-filer', null, ['class' => 'form-control', 'tabindex' => 7]) }}
                                            </div>
                                        </th>
                                        <th class="col-ship-nation">
                                            <div class="th-line-one">
                                                {{ trans('ship.lbl_title_ship_nation') }}
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="th-line-two">
                                                {{ Form::text('ship-nation-filter', null, ['class' => 'form-control', 'tabindex' => 8]) }}
                                            </div>
                                        </th>
                                        <th class="col-service">
                                            <div class="th-line-one">
                                                {{ trans('ship.lbl_title_service_name') }}
                                            </div>
                                            <div class="th-line-two">
                                                {{ Form::text('service-name-filter', null, ['class' => 'form-control', 'tabindex' => 9]) }}
                                            </div>
                                        </th>
                                        <th class="col-action">
                                            {{ Form::button(trans('ship.btn_filter'), ['class' => 'btn btn-blue-dark btn-custom-sm', 'tabindex' => 10]) }}
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            <div class="table-content">
                                <table class="table table-blue table-result">
                                    <tbody class="tbody-scroll-1">
                                        @for ($i = 1; $i <= 20; $i ++)
                                            <tr>
                                                <td class="col-ship-name" rowspan="2">Ship Name</td>
                                                <td class="col-company-name" rowspan="2">Company</td>
                                                <td class="col-classification" rowspan="2">Classification</td>
                                                <td class="col-ship-type" rowspan="2">Type</td>
                                                <td class="col-imo-number" rowspan="2">IMO</td>
                                                <td class="col-ship-nation" rowspan="2">JAPAN</td>
                                                <td class="col-service">CMAXS-SPICS</td>
                                                <td class="col-action" rowspan="2">
                                                    <a href="{{ route('ship.contract.detail', ['id' => $i]) }}" class="btn btn-blue-dark btn-custom-sm">
                                                        {{ trans('ship.btn_detail') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-service">CMAXS-ABLOG</td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="block-list-ship-bottom">
                        <div class="block-button block-button-right">
                            <a href="{{ route('ship.create') }}" class="btn btn-blue-dark btn-w150" tabindex="12">
                                {{ trans('ship.btn_create_ship') }}
                            </a>
                            <!-- {{ Form::button(trans('ship.btn_create_ship'), ['class' => 'btn btn-blue-dark btn-w150', 'tabindex' => 12]) }} -->
                            {{ Form::button(trans('ship.btn_back'), ['class' => 'btn btn-gray btn-w150', 'tabindex' => 11]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <nav class="text-center" aria-label="...">
                        <ul class="pagination">
                            <li class="page-item disabled">
                            <span class="page-link">{{ trans('ship.btn_prev') }}</span>
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
                                <a class="page-link" href="#">{{ trans('ship.btn_next') }}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            const table = document.querySelector('.block-table');
            const psWidth = new PerfectScrollbar(table, function () {
                table.style.width = '100%'
            });

            const content = document.querySelector('.table-content');
            const psHeight = new PerfectScrollbar(content, function () {
                content.style.height = '300px'
            });

            // remove class when init
            $('.block-table').removeClass('ps--active-y');
        });
    </script>
@endsection
