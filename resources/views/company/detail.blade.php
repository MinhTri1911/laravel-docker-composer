@extends('layouts.white')

@section('title', trans('company.head_detail_company'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/company-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'detail-company')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">
            {{ trans('company.head_detail_company') }}
        </h1>

        <div class="main-summary">
            <div class="col-md-12">
                <!--begin show detail company infomation-->
                <div class="col-md-4 block-detail">
                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_id') }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->id }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_name_jp') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->name_jp }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_name_en') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->name_en }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_nation') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $nation ? $nation->name_jp: '' }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_postal_code') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->postal_code }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_address') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->head_office_address }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_represent_person') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->represent_person }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_fund') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->fund }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_currency') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $currency ? $currency->code : '' }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_employee_number') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->employees_number }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_year_research') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->year_research }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_billing_id') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label id="lbl-billing-method-id">{{ $billingMethod ? $billingMethod->name_jp : '' }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_month_billing') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->month_billing }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_payment_deadline_no') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->payment_deadline_no }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_site') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->billing_day_no }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_currency_code') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->currency_code }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_name') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $companyOperation ? $companyOperation->name: '' }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_company_url') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label><a href="{{ $company->url }}">{{ $company->url }}</a></label>
                        </div>
                    </div>
                </div>
                <!--end show detail company infomation-->

                <!--begin show infomation operation contact person 1-->
                <div class="col-md-4 block-detail">
                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_contact_1') }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_name') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_person_name_1 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_position') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_position_1 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_department') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_department_1 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_postal_code') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_postal_code_1 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_address') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_address_1 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_phone') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_phone_1 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_fax') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_fax_1 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_email') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_email_1 }}</label>
                        </div>
                    </div>
                </div>
                <!--end show infomation operation contact person 1-->

                <!--begin show infomation operation contact person 2-->
                <div class="col-md-4 block-detail">
                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_contact_2') }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_name') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_person_name_2 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_position') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_position_2 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_department') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_department_2 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_postal_code') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_postal_code_2 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_address') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_address_2 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_phone') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_phone_2 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_fax') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_fax_2 }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label-title">
                            <label>{{ trans('company.lbl_title_ope_email') . ' :' }}</label>
                        </div>
                        <div class="label-content">
                            <label>{{ $company->ope_email_2 }}</label>
                        </div>
                    </div>
                </div>
                <!--end show infomation operation contact person 2-->

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="col-md-12 block-detail">
                                <div class="row">
                                    <div class="label-title-button">
                                        <label>{{ trans('company.lbl_title_setting_billing_method') }}</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            {{ Form::button(trans('company.btn_setting_billing_method'), [
                                                    'class' => 'btn btn-green-dark btn-w150',
                                                    'id' => 'btn-setting-billing',
                                                    'data-url' => route('billing.method.show', ['billing-method' => $billingMethod ? $billingMethod->id : 0]),
                                                ])
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-12 block-detail">
                                <div class="row">
                                    <div class="label-title-button">
                                        <label>{{ trans('company.lbl_title_add_service_for_all_ship') }}</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6 block">
                                            {{ Form::button(trans('company.btn_create'), [
                                                    'class' => 'btn btn-green-dark btn-w150',
                                                    'id' => 'btn-add-service-for-all-ship',
                                                    'data-url' => route('company.service.create'),
                                                ])
                                            }}
                                        </div>
                                        <div class="col-md-6 block">
                                            {{ Form::button(trans('company.btn_delete'), [
                                                    'class' => 'btn btn-green-dark btn-w150',
                                                    'id' => 'btn-show-popup-delete-service-in-all-ship',
                                                    'data-url' => route('company.service.index'),
                                                ])
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="col-md-12 block-detail">
                                <div class="row">
                                    <div class="label-title-button">
                                        <label>{{ trans('company.lbl_title_create_ship_contract') }}</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <a href="{{ route('ship.createShipContract', ['company-id' => $company->id]) }}" class="btn btn-green-dark btn-w150">
                                                {{ trans('company.btn_create') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-12 block-detail">
                                <div class="row">
                                    <div class="label-title-button">
                                        <label>{{ trans('company.lbl_title_delete_contract_of_company') }}</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            {{ Form::button(trans('company.btn_delete'), [
                                                    'class' => 'btn btn-green-dark btn-w150',
                                                    'id' => 'btn-show-popup-delete-all-service',
                                                ])
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="block-detail block-center">
                            <a href="{{ route('company.index') }}" class="btn btn-blue-light btn-w150">
                                {{ trans('company.btn_back_to_list_company') }}
                            </a>

                            {{ Form::button(trans('company.btn_delete_company'), [
                                    'class' => 'btn btn-red btn-w150',
                                    'id' => 'btn-show-popup-confirm-delete-company',
                                ])
                            }}

                            <a href="{{ route('company.edit', ['id' => $company->id]) }}" class="btn btn-green-dark btn-w150">
                                {{ trans('company.btn_edit_company') }}
                            </a>
                            <a href="{{ route('ship.index', ['company-id' => $company->id]) }}" class="btn btn-green-dark btn-w150">
                                {{ trans('company.btn_go_to_list_ship') }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- begin modal -->
    <div class="modal modal-protector fade" id="modal-protector" tabindex="-1" role="dialog" style="display: none;"></div>
    <!-- end modal -->

    <!-- begin modal stack -->
    <div id="delete-service-in-all-ship"
        class="modal hide fade modal-protector"
        tabindex="-1" data-focus-on="input:first"
        data-backdrop="static"
        data-keyboard="false">
    </div>

    <div id="popup-confirm-delete-service"
        class="modal hide fade modal-stack"
        tabindex="-1"
        data-focus-on="input:first"
        data-backdrop="static"
        data-keyboard="false">
    </div>
    <!-- end modal stack -->

    <!-- begin popup confirm delete all contract -->
    <div class="modal modal-protector confirm" id="popup-delete-all-service">
        <div class="modal-close">
            <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
            <label>閉じる</label>
        </div>
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="popup-title">
                    <h2>{{ trans('company.lbl_confirm_delete_contract') }}</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-setting-billing-content">
                        <h2 class="block-center">{{ trans('company.lbl_confirm_delete_contract') }}</h2>
                    </div>
                    <div class="modal-bottom">
                        {{ Form::button(trans('company.btn_cancel_delete'), [
                                'class' => 'center-block btn btn-gray-dark btn-w150 btn-csv',
                                'data-dismiss' => 'modal'
                            ])
                        }}
                        {{ Form::button(trans('company.btn_delete'), [
                                'id' => 'btn-delete-all-service',
                                'class' => 'center-block btn btn-blue-dark btn-w150',
                                'data-url' => route('company.service.deleteAll'),
                            ])
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end popup confirm delete all contract -->

    <!-- Begin delete company -->
    <div class="modal modal-protector fade" id="modal-confirm" tabindex="-1" role="dialog">
        <div class="modal-close">
            <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
            <label>閉じる</label>
        </div>
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Popup confrim xóa công ty</h4>
                </div>
                <div class="modal-body">
                    <text id="modalMessage">msg confim del company with all infomation</text>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{ trans('company.btn_cancel_delete') }}</button>
                    <button type="button" class="btn btn-blue-dark btn-w190" id="modalBtnOK">OKE</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-protector fade" id="modal-done" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitleDone">{{__('ship-contract.detail.lbl_popup_del_contract')}}</h4>
                </div>
                <div class="modal-body">
                    <text id="modalMessageDone">{{__('ship-contract.detail.lbl_popup_del_contract_msg')}}</text>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('company.index') }}" class="btn btn-blue-light btn-w150">
                        OKE
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-protector fade" id="modal-auth" tabindex="-1" role="dialog">
        <div class="modal-close">
            <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
            <label>閉じる</label>
        </div>
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitleAuth">{{__('ship-contract.detail.pop_auth_delete_ship')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="setting-content">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <div class="block-error">
                                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                                        <label class="control-label lbl-error-message"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <text id="modalMessageAuth">{{__('ship-contract.detail.lbl_input_pw')}}</text>
                        {{ Form::password('pw-user', ['class' => 'form-control', 'id' => 'pw-user']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('ship-contract.detail.btn_cancel')}}</button>
                    <button type="button" class="btn btn-blue-dark btn-w190" id="modalBtnOKAuth" data-url="{{ route('company.delete') }}">
                        {{__('ship-contract.detail.btn_ok')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End delete company -->


    {{-- Form hidden get company id --}}
    {{ Form::hidden('company-id', $company->id, ['id' => 'company-id']) }}
@endsection

@section('javascript')
    <script>
        window.Laravel = {!! json_encode([
            'urlUpdateBillingMethod' => route('billing.method.update'),
            'urlAddService' => route('company.service.store'),
            'urlDeleteServiceInAllShip' => route('company.service.delete'),
        ]) !!};
    </script>
    <script type="text/javascript" src="{{ asset('js/company-general.js') }}"></script>
@endsection
