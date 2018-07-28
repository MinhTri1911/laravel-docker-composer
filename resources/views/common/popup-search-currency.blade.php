<div class="modal-close">
    <button class="btn-close-modal" data-dismiss="modal"></button>
    <label>{{ trans('common.btn_close_modal') }}</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ trans('common.modal.title_search_currency') }}</h4>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <!-- begin alert errors -->
                <div class="alert alert-danger">
                    <div class="block-error">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        <label class="control-label" id="lblErrorSearchCurrency"></label>
                    </div>
                </div>
                <!-- end alert errors -->

                <div class="modal-left">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                {{ trans('company.lbl_title_currency_id') }}
                            </div>
                            <div class="item-value">
                                {{ Form::text('search-currency-id', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_nation_id'),
                                        'id' => 'search-currency-id'
                                    ])
                                }}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{ trans('company.lbl_title_currency_code') }}
                            </div>
                            <div class="item-value">
                                {{ Form::text('search-currency-code', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_nation'),
                                        'id' => 'search-currency-code'
                                    ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-right">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="block-handle align-center" style="margin-top: 65px;">
                                {{ Form::button(trans('common.btn_search'), [
                                        'class' => 'btn btn-blue-light btn-w150',
                                        'id' => 'btn-search-currency',
                                        'data-url' => route('currency.search'),
                                    ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="area-append-data">
                <table class="table table-blue table-service table-popup table-fixed">
                    <thead>
                        <tr>
                            <th class="col-currency-id">{{ trans('company.lbl_title_currency_id') }}</th>
                            <th class="col-currency-code">{{ trans('company.lbl_title_currency_code') }}</th>
                            <th class="col-action"></th>
                        </tr>
                    </thead>
                    <tbody class="tbody-popup tbody-scroll" id="currency-data-scroll">
                        @include('common.table-currency-search')
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            {{ Form::button(trans('common.btn_cancel'), ['class' => 'btn btn-blue-light btn-w150', 'data-dismiss' => 'modal']) }}
            {{ Form::button(trans('common.btn_ok'), [
                    'class' => 'btn btn-blue-dark btn-w190',
                    'data-dismiss' => 'modal',
                    'id' => 'btn-currency-ok'
                ])
            }}
        </div>
    </div>
</div>
