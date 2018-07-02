@extends('layouts.white')

@section('title',__('approve.title_approve'))

@section('style')
    <link rel="stylesheet" href="{{asset("/css/approve.css")}}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'approve')

@section('content')
<div class="main-content">
    <h1 class="main-heading">{{__('approve.header_approve')}}</h1>
    <div class="main-summary approve-list">
        <div class="search-block">
            <div class="content-block table-block">
                <div class="item-row date-group">
                    <div class="item-label">
                        {{__('approve.lbl_date_create')}}
                    </div>
                    <div class="item-value">
                        <div class="group-datepicker">
                            {!! Form::text('Txt', null, ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                        <span class="split-a">~</span>
                        <div class="group-datepicker">
                            {!! Form::text('Txt', null, ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('approve.lbl_creator')}}
                    </div>
                    <div class="item-value">
                        {!! Form::text('Txt', null, ['class' => 'form-control', 'placeholder' =>  ""]) !!}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('approve.lbl_type')}}
                    </div>
                    <div class="item-value form-inline">
                        <div class="form-group">
                            <div class="custom-select">
                             {!! Form::select('setting_status', ["契約", "スポット費用", "請求書"], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group form-group-right">
                            <div class="item-label">
                                {{__('approve.lbl_status')}}
                            </div>
                            <div class="item-value">
                                <div class="custom-select">
                                     {!! Form::select('setting_status', [2 => "承認待ち", 3 => "拒絶"], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-handle align-center">
                <div class="btn btn-orange btn-w150">{{__('approve.btn_search')}}</div>
            </div>
        </div>
        {{-- List contract --}}
        <div class="result-app-block contract-block">
            <h4 class="rs-title">{{__('approve.header_contract')}}</h4>     
            <div class="content-block table-block">
                <div class="block-handle align-right">
                    <div class="btn btn-red btn-w150 btn-reject">{{__('approve.btn_approve')}}</div>
                    <div class="btn btn-blue-dark btn-w150 btn-approve">{{__('approve.btn_reject')}}</div>
                </div>
                <table class="table table-blue table-contract">
                    <thead>
                        <tr>
                            <th class="custom-checkbox">
                                <input class="hidden" id="hh" name="n" type="checkbox">
                                <label for="hh"></label>
                            </th>
                            <th>{{__('approve.lbl_contract_id')}}</th>
                            <th>{{__('approve.lbl_contract_ship')}}</th>
                            <th>{{__('approve.lbl_contract_service')}}</th>
                            <th>{{__('approve.lbl_contract_status')}}</th>
                            <th>{{__('approve.lbl_contract_ope')}}</th>
                            <th>{{__('approve.lbl_contract_date')}}</th>
                            <th>{{__('approve.lbl_contract_creator')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="custom-checkbox">
                                <input class="hidden" id="hh" name="n" type="checkbox">
                                <label for="hh"></label>
                            </td>
                            <td>1</td>
                            <td>Tàu A</td>
                            <td>Service A</td>
                            <td>Tình trạng</td>
                            <td>Thao tác</td>
                            <td>Ngày tạo</td>
                            <td>Người tạo</td>
                            <td><div class="btn btn-blue-dark btn-custom-sm btn-detail" data-href="#" data-item="1">{{__('approve.btn_detail')}}</div></td>
                        </tr>
                        <tr>
                            <td class="custom-checkbox">
                                <input class="hidden" id="hh" name="n" type="checkbox">
                                <label for="hh"></label>
                            </td>
                            <td>1</td>
                            <td>Tàu A</td>
                            <td>Service A</td>
                            <td>Tình trạng</td>
                            <td>Thao tác</td>
                            <td>Ngày tạo</td>
                            <td>Người tạo</td>
                            <td><div class="btn btn-blue-dark btn-custom-sm btn-detail" data-href="#" data-item="1">{{__('approve.btn_detail')}}</div></td>
                        </tr>
                        <tr>
                            <td class="custom-checkbox">
                                <input class="hidden" id="hh" name="n" type="checkbox">
                                <label for="hh"></label>
                            </td>
                            <td>1</td>
                            <td>Tàu A</td>
                            <td>Service A</td>
                            <td>Tình trạng</td>
                            <td>Thao tác</td>
                            <td>Ngày tạo</td>
                            <td>Người tạo</td>
                            <td><div class="btn btn-blue-dark btn-custom-sm btn-detail" data-href="#" data-item="1">{{__('approve.btn_detail')}}</div></td>
                        </tr>
                    </tbody>
                </table>
                <div class="block-paginate">
                    <div class="fl-page fl-left">
                        {{__('approve.lbl_page_text', ['min' => '1', 'max' => 10, 'total' => 100])}}
                    </div>
                    <div class="fl-page fl-right">
                        <ul class="pagination">
                            <li class="active">
                                <a>1</a>
                            </li>
                            <li class="">
                                <a href="#page=2">2</a>
                            </li>
                            <li class="">
                                <a href="#page=3">3</a>
                            </li>
                            <li class="">
                                <a href="#page=4">4</a>
                            </li>
                            <li class="">
                                <a href="#page=5">5</a>
                            </li>
                            <li class="disable">
                                <a>
                                    <span>...</span>
                                </a>
                            </li>
                            <li class="last-page">
                                <a href="#page=119">
                                    <span>119</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- End List contract --}}
    </div>
</div>
{{-- Popup --}}
<div class="modal fade modal-service" id="modal-service">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('approve.header_pop_contract_detail')}}</h4>
            </div>
            <div class="modal-body">
                @include('approve.detail-contract')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('approve.btn_cancel')}}</button>
                <button type="button" class="btn btn-blue-dark btn-w150 btn-approve">{{__('approve.btn_approve')}}</button>
                <button type="button" class="btn btn-red btn-w150 btn-reject">{{__('approve.btn_reject')}}</button>
            </div>
        </div>
    </div>
</div>
{{-- End Popup --}}
{{-- Popup --}}
<div class="modal fade modal-confirm" id="modal-confirm">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('approve.header_pop_approve')}}</h4>
            </div>
            <div class="modal-body">
                {{__('approve.msg_pop_approve_contract')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('approve.btn_cancel')}}</button>
                <button type="button" class="btn btn-blue-dark btn-w150 btn-ok">{{__('approve.btn_ok')}}</button>
            </div>
        </div>
    </div>
</div>
{{-- End Popup --}}
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/approve.js') }}"></script>
@endsection