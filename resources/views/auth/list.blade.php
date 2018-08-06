@extends('layouts.white')

@section('title', __('auth.list_title'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/list-auth.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'auth-list')

@section('content')
    <div class="main-content pd-bt-60">
        <h1 class="main-heading">{{ __('auth.list_title') }}</h1>

        <div class="main-summary">
            {{-- Link search all --}}
            <div class="row">
                <div class="col-md-10 col-md-offset-1 mg-bt-60">
                    {{--<form action="" class="form-inline">--}}
                    {!! Form::open(['route' => 'auth.list', 'method' => 'get', 'novalidate' => 'novalidate', 'class' => 'form-inline']) !!}
                        <div class="form-group col">
                            <label class="label-control">{{ __('auth.id') }}</label>
                            {!! Form::text('id', false, [
                                    'class' => 'form-control',
                                    'placeholder' => __('auth.id_placeholder'),
                                    'tabindex' => 1,
                                ])
                            !!}
                        </div>

                        <div class="form-group">
                            <label class="label-control">{{ __('auth.lbl_login_id') }}</label>
                            {!! Form::text('login_id', false, [
                                    'class' => 'form-control',
                                    'placeholder' => __('auth.lbl_login_id'),
                                    'tabindex' => 2,
                                ])
                            !!}
                        </div>

                        <div class="form-group">
                            <label class="label-control">{{ __('company.header_company_operation_name') }}</label>
                            <div class="custom-select inline-select">
                                {!! Form::select('company_operation',
                                    $companyOperation, false,
                                    [
                                        'class' => 'form-control',
                                        'tabindex' => 3,
                                    ])
                                 !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-blue-light btn-w150 mg-l-30" type="submit" tabindex="4">{{ __('common.btn_search') }}</button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>

            {{-- Edit auth form --}}
            {!! Form::open(['route' => 'auth.update', 'novalidate' => 'novalidate', 'class' => 'form-inline']) !!}

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="block-list-ship">
                        <div class="block-table">
                            {{-- Table head --}}
                            <table class="table table-blue table-result resizable">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('auth.id') }}</th>
                                        <th class="text-center">{{ __('auth.lbl_login_id') }}</th>
                                        <th class="text-center custom-width">{{ __('auth.auth_create_title') }}</th>
                                        <th class="text-center custom-width">{{ __('auth.auth_approve_title') }}</th>
                                        <th class="text-center custom-width">{{ __('auth.auth_reference_title') }}</th>
                                        <th class="text-center custom-width">{{ __('auth.auth_operation_title') }}</th>
                                        <th class="text-center custom-width">{{ __('auth.all_auth') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="table-content">
                                    @include('auth.list-data')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Button --}}
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="pull-left" id="area-paginate">
                        @include('vendor.pagination.default', ['paginator' => $users])
                    </div>

                    <button type="button" id="update-auth" class="btn btn-blue-dark btn-w150 pull-right mg-t-30" tabindex="5">
                        {{ __('common.btn_edit') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }} {{-- End edit form --}}
        </div>
    </div>

    <div class="modal modal-protector modal-normal fade" id="confirm-update" tabindex="-1" role="dialog">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>{{ __('common.btn_close_modal') }}</label>
        </div>
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('auth.list_title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-row">
                        {{ __('auth.confirm_update') }}
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button(__('common.btn_cancel'), ['class' => 'btn btn-blue-light btn-w150', 'data-dismiss' => 'modal']) }}
                    {{ Form::button(__('common.btn_ok'), [
                            'class' => 'btn btn-blue-dark btn-w190',
                            'data-dismiss' => 'modal',
                            'id' => 'btn-ok'
                        ])
                    }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-protector modal-normal fade" id="response-message" tabindex="-1" role="dialog">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>{{ __('common.btn_close_modal') }}</label>
        </div>
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('auth.list_title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-row"></div>
                </div>
                <div class="modal-footer">
                    {{ Form::button(__('common.btn_cancel'), ['class' => 'btn btn-blue-light btn-w150', 'data-dismiss' => 'modal']) }}
                    {{ Form::button(__('common.btn_ok'), [
                            'class' => 'btn btn-blue-dark btn-w190',
                            'data-dismiss' => 'modal',
                            'id' => 'response-btn'
                        ])
                    }}
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

            // remove class when init
            $('.block-table').removeClass('ps--active-y');
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/list-auth.js') }}"></script>
@endsection
