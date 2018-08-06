@extends('layouts.white')

@section('title',__('tax.title_tax_list'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/tax-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('content')
    <div class="main-content" id="tax-list-master">
        <h1 class="main-heading">{{__('tax.title_tax_list')}}</h1>
        <div class="main-summary col-md-12">

            <!-- Url Search-->
            {{ Form::hidden('url_search', route('billing.search.billing.paper'), ['id' => 'url-search']) }}
            {{ Form::hidden('url_create', route('billing.create.billing.paper'), ['id' => 'url-create']) }}
            {{ Form::hidden('url_delivery', route('billing.delivery.billing.paper'), ['id' => 'url-delivery']) }}
            {{ Form::hidden('url_export_csv', route('billing.export.billing.paper'), ['id' => 'url-export-csv']) }}

            <div class="content-form">
                <div class="form-group">

                    <a href="{{route('company.index')}}" id='btn-back' class='btn btn-blue-light btn-w150' tabindex="102">{{__('tax.btn_back')}}</a>

                    <!--Check permission create tax-->
                    @if (Roles::checkPermission(Constant::ALLOW_BILLING_CREATE, Constant::IS_CHECK_BUTTON))
                        {!! Form::button( __('tax.btn_create'), ["class"=>"btn btn-green-dark btn-w150", 'id' => 'btn-create', 'tabindex' => 103]) !!}
                    @endif
                </div>
            </div>

            <div id='area-tbl-result clear-both'>
                @include('tax.component.table.table-master')
            </div>
        </div>
    </div>

    <!--Popup show reason reject-->
    <div class="modal modal-protector fade" id="modal-reason-reject" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>{{__('billing.lbl_close_popup')}}</label>
        </div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popup-title">
                    <h2>{{__('billing.title_popup_reason_reject')}}</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align: center;">
                        <label id='popup-reason-reject-text' class="label-control"></label>
                    </div>

                    <div class="form-btn">
                        {!! Form::button( __('billing.btn_Ok'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-Ok', 'data-dismiss' => 'modal']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        var message = {
        };
    </script>
    <script type="text/javascript" src="{{ asset('js/tax-general.js') }}"></script>
@endsection