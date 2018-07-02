@extends('layouts.white')

@section('title', __('ship-contract.detail.title_ship_contract'))

@section('style')
    <link rel="stylesheet" href="{{asset("/css/ship-contract.css")}}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'ship-contract-page')

@section('content')
<div class="main-content" id="ship-contract">
    <h1 class="main-heading">{{__('ship-contract.detail.header_ship_contract')}}</h1>
    <div class="main-summary detail-ship">
        {{-- Start of ship block --}}
        <div class="ship-info-block">
            <h4> {{__('ship-contract.detail.header_ship_info')}}</h4>
            <div class="content-block table-block">
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_id')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_name')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_company')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_imo')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_mmsi')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_nation')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_level')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_code')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_type')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_wide')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_long')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_mon')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_quan')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_weight')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_teu')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_note')}}
                    </div>
                    <div class="item-value">
                        asfasf
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_url1')}}
                    </div>
                    <div class="item-value">
                        <a href="#">https://mail.google.com/mail/u/0/</a>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_url2')}}
                    </div>
                    <div class="item-value">
                        <a href="#">https://mail.google.com/mail/u/0/</a>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_url3')}}
                    </div>
                    <div class="item-value">
                        <a href="#">https://mail.google.com/mail/u/0/</a>
                    </div>
                </div>
            </div>
            <div class="block-handle align-center">
                <a href="#" class="btn btn-blue-dark btn-w150">{{__('ship-contract.detail.btn_edit_ship')}}</a>
            </div>
        </div>
        {{-- End of ship block --}}
        {{-- List contract --}}
        <div class="contract-block">
            <h4>{{__('ship-contract.detail.lbl_ship_contract')}}</h4>
            <div class="content-block table-block">
                <div class="extra-block">{{__('ship-contract.detail.lbl_no_ship_contract', ['number' => 100])}}</div>
                <table class="table table-blue table-ship">
                    <thead>
                        <tr>
                            <th style="" class="custom-checkbox">
                                <input class="hidden" id="hh" name="n" type="checkbox">
                                <label for="hh"></label>
                            </th>
                            <th>{{__('ship-contract.detail.lbl_contract_id')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_version')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_service')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_start')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_end')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_status')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_approve')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_date_create')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_date_update')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="custom-checkbox">
                                <input class="hidden" id="hh1" name="n" type="checkbox">
                                <label for="hh1"></label>
                            </td>
                            <td style="word-wrap: break-word;">ID</td>
                            <td style="word-wrap: break-word;">1.1</td>
                            <td style="word-wrap: break-word;">System1</td>
                            <td style="">2018-02-13</td>
                            <td style="">2018-02-14</td>
                            <td>作成日</td>
                            <td>approve</td>
                            <td style="">2018-02-13 11:20:31</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td>
                                <button class="btn btn-orange btn-custom-sm" data-toggle="modal" data-target="#modal-del-confirm">{{__('ship-contract.detail.btn_contract_restore')}}</button>
                                <a href="#" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_contract_edit')}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="custom-checkbox">
                                <input class="hidden" id="hh1" name="n" type="checkbox">
                                <label for="hh1"></label>
                            </td>
                            <td style="word-wrap: break-word;">ID</td>
                            <td style="word-wrap: break-word;">1.1</td>
                            <td style="word-wrap: break-word;">System1</td>
                            <td style="">2018-02-13</td>
                            <td style="">2018-02-14</td>
                            <td>作成日</td>
                            <td>approve</td>
                            <td style="">2018-02-13 11:20:31</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td>
                                <button class="btn btn-orange btn-custom-sm" data-toggle="modal" data-target="#modal-del-confirm">{{__('ship-contract.detail.btn_contract_restore')}}</button>
                                <a href="#" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_contract_edit')}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="custom-checkbox">
                                <input class="hidden" id="hh1" name="n" type="checkbox">
                                <label for="hh1"></label>
                            </td>
                            <td style="word-wrap: break-word;">ID</td>
                            <td style="word-wrap: break-word;">1.1</td>
                            <td style="word-wrap: break-word;">System1</td>
                            <td style="">2018-02-13</td>
                            <td style="">2018-02-14</td>
                            <td>作成日</td>
                            <td>approve</td>
                            <td style="">2018-02-13 11:20:31</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td>
                                <button class="btn btn-orange btn-custom-sm" data-toggle="modal" data-target="#modal-del-confirm">{{__('ship-contract.detail.btn_contract_restore')}}</button>
                                <a href="#" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_edit')}}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="block-handle align-right">
                    <div href="#" class="btn btn-blue-dark btn-w190 pull-left">{{__('ship-contract.detail.btn_create')}}</div>
                    <div href="#" class="btn btn-gray-dark btn-w190 pull-left" data-toggle="modal" data-target="#modal-del-confirm">{{__('ship-contract.detail.btn_disable')}}</div>
                    <button href="#" class="btn btn-red btn-w150 pull-left" data-toggle="modal" data-target="#modal-del-confirm" id="del-contract">{{__('ship-contract.detail.btn_delete')}}</button>
                </div>
            </div>
        </div>
        {{-- End List contract --}}
        {{-- List Spot --}}
        <div class="spot-block">
            <h4>{{__('ship-contract.detail.lbl_ship_spot')}}</h4>
            <div class="content-block table-block spot-block">
                <div class="extra-block">{{__('ship-contract.detail.lbl_no_ship_spot', ['number' => 100])}}</div>
                <table class="table table-blue table-ship">
                    <thead>
                        <tr>
                            <th style="width: 7%;">{{__('ship-contract.detail.lbl_spot_id')}}</th>
                            <th style="width: 13%;">{{__('ship-contract.detail.lbl_spot_name')}}</th>
                            <th style="width: 15%;">{{__('ship-contract.detail.lbl_spot_setting')}}</th>
                            <th style="width: 11%;">{{__('ship-contract.detail.lbl_spot_cost')}}</th>
                            <th style="width: 6%;">{{__('ship-contract.detail.lbl_spot_approve')}}</th>
                            <th style="width: 14%;">{{__('ship-contract.detail.lbl_spot_date_create')}}</th>
                            <th style="width: 20%;">{{__('ship-contract.detail.lbl_spot_date_update')}}</th>
                            <th style="width: 20%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="word-wrap: break-word;">ID</td>
                            <td style="word-wrap: break-word;">Tên SPOT</td>
                            <td style="word-wrap: break-word;">Thời gian setting</td>
                            <td>100.000</td>
                            <td style="">approve</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td>
                                <a href="#" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_edit')}}</a>
                                <button class="btn btn-red btn-custom-sm" data-toggle="modal" data-target="#modal-del-confirm">{{__('ship-contract.detail.btn_delete')}}</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="word-wrap: break-word;">ID</td>
                            <td style="word-wrap: break-word;">Tên SPOT</td>
                            <td style="word-wrap: break-word;">Thời gian setting</td>
                            <td>100.000</td>
                            <td style="">approve</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td>
                                <a href="#" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_edit')}}</a>
                                <button class="btn btn-red btn-custom-sm" data-toggle="modal" data-target="#modal-del-confirm">{{__('ship-contract.detail.btn_delete')}}</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="word-wrap: break-word;">ID</td>
                            <td style="word-wrap: break-word;">Tên SPOT</td>
                            <td style="word-wrap: break-word;">Thời gian setting</td>
                            <td>100.000</td>
                            <td style="">approve</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td style="">2018-02-14 17:19:47</td>
                            <td>
                                <a href="#" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_edit')}}</a>
                                <button class="btn btn-red btn-custom-sm" data-toggle="modal" data-target="#modal-del-confirm">{{__('ship-contract.detail.btn_delete')}}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="fl-block">
                    <div class="fl-page fl-left">
                        <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link">Previous</a>
                              </li>
                              <li class="page-item"><a class="page-link" href="#">1</a></li>
                              <li class="page-item active">
                                <span class="page-link">
                                  2
                                  <span class="sr-only">(current)</span>
                                </span>
                              </li>
                              <li class="page-item"><a class="page-link" href="#">3</a></li>
                              <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                              </li>
                            </ul>
                    </div>
                    <div class="fl-page fl-right">
                        <div class="block-handle align-right">
                            <a href="#" class="btn btn-blue-light btn-w150">{{__('ship-contract.detail.btn_back')}}</a>
                            <div  class="btn btn-green-dark btn-w150 pull-right">{{__('ship-contract.detail.btn_create')}}</div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        {{-- End List Spot --}}
        
    </div>
</div>
<div class="modal fade" id="modal-del-confirm" tabindex="-1" role="dialog">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <h4 class="modal-title" id="myModalLabel">{{__('ship-contract.detail.lbl_popup_del_contract')}}</h4>
            </div>
            <div class="modal-body">
               {{__('ship-contract.detail.lbl_popup_del_contract_msg')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('ship-contract.detail.btn_cancel')}}</button>
                <button type="button" class="btn btn-blue-dark btn-w190">{{__('ship-contract.detail.btn_ok')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript" src="{{ asset('js/users-general-list-user.js') }}"></script>
<script>
//    $(document).on("click","#del-contract",function(){$("#modal-del-contract").modal("show")});
</script>
@endsection