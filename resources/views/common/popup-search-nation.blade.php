<div class="modal-close">
    <button class="btn-close-modal" data-dismiss="modal"></button>
    <label>{{ trans('common.btn_close_modal') }}</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ trans('common.modal.title_search_nation') }}</h4>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="modal-left">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                {{ trans('ship.lbl_title_ship_nation_id') }}
                            </div>
                            <div class="item-value">
                                {{ Form::text('search-nation-id', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_nation_id'),
                                        'id' => 'search-nation-id'
                                    ])
                                }}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{ trans('ship.lbl_title_ship_nation') }}
                            </div>
                            <div class="item-value">
                                {{ Form::text('search-nation-name', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_nation'),
                                        'id' => 'search-nation-name'
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
                                        'id' => 'btn-search-nation',
                                        'data-url' => route('nation.search'),
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
                            <th class="col-nation-id">{{ trans('ship.lbl_title_ship_nation_id') }}</th>
                            <th class="col-nation-name">{{ trans('ship.lbl_title_ship_nation') }}</th>
                            <th class="col-action"></th>
                        </tr>
                    </thead>
                    <tbody class="tbody-popup tbody-scroll" id="nation-data-scroll">
                        @include('common.table-nation-search')
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            {{ Form::button(trans('common.btn_cancel'), ['class' => 'btn btn-blue-light btn-w150', 'data-dismiss' => 'modal']) }}
            {{ Form::button(trans('common.btn_ok'), [
                    'class' => 'btn btn-blue-dark btn-w190',
                    'data-dismiss' => 'modal',
                    'id' => 'btn-ok'
                ])
            }}
        </div>
    </div>
</div>
