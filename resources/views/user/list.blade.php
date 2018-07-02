@extends('layouts.white')

@section('title',__('users-general.head_list_user'))

@section('style')
    <link rel="stylesheet" href="{{asset("/css/user-general.css")}}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'list-common-user')

@section('content')
    <div class="main-content" id="user-general">
        <h1 class="main-heading">Text goes here</h1>

        <div class="main-summary user-list">
            <div class="alert alert-danger">
                <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        住所1を入力してください。
                    </label>
                </div>
                <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        電話番号を入力してください。
                    </label>
                </div>
                <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        秘密の質問を入力してください。
                    </label>
                </div>
            </div>
            <div class="alert alert-warning">
                <div class="block-warning">
                    <label class="control-label lbl-format-email">
                        This is text heading
                   </label>
                </div>
            </div>
            <div class="alert alert-success">
                 <div class="block-success">
                       <i class="fa fa-check" aria-hidden="true"></i>
                       <label>OK. Done save user</label>
                  </div>
            </div>
            <div class="alert alert-info">
                 <div class="block-info">
                       <i class="fa fa-check" aria-hidden="true"></i>
                       <label>OK. Done save user</label>
                  </div>
            </div>
            <div class="alert alert-danger">
                 <div class="block-error">
                       <i class="fa fa-remove" aria-hidden="true"></i>
                       <label>OK. Done save user</label>
                  </div>
            </div>

            <div class="list-form">
                {!!
                    Form::open([
                        'method' => 'GET'
                    ])
                !!}
                <div class="form-group has-error">
                    <div class="left-side">
                        <label class="label-control label-error">Label Error</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('user_id', null, ['class' => 'form-control' ] ) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="item item-fix">
                        <span class="item-multi-value">
                            <ul class="nav">
                                <li>
                                    <div class="custom-checkbox">
                                        <input class="hidden" id="mail_test_result_module" name="mail_test_result_module" type="checkbox">
                                        <label for="mail_test_result_module">テスト完了時にメール送信を行う。</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-checkbox">
                                        <input class="hidden disabled" id="re_config_mail_module" checked="checked" name="re_config_mail_module" type="checkbox">
                                        <label for="re_config_mail_module">一般ユーザーにメールアドレス変更を許可する。</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-checkbox">
                                        <input class="hidden" id="general_user_permission_module" checked="checked" name="general_user_permission_module" type="checkbox">
                                        <label for="general_user_permission_module">一般ユーザー入会機能を利用する。</label>
                                    </div>
                                </li>
                            </ul>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="item item-fix">
                        <span class="item-multi-value">
                            <ul class="nav">
                                <li>
                                    <div class="custom-radio">
                                        <input class="hidden" id="mail_test_result_module1" name="mail_test_result_modules" type="radio">
                                        <label for="mail_test_result_module1">テスト完了時にメール送信を行う。</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-radio">
                                        <input class="hidden disabled" id="re_config_mail_module2" checked="checked" name="mail_test_result_modules" type="radio">
                                        <label for="re_config_mail_module2">一般ユーザーにメールアドレス変更を許可する。</label>
                                    </div>
                                </li>
                            </ul>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">gddhg</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('login_id', null, ['class' => 'form-control' ] ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">abdcd</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('user_name', null, ['class' => 'form-control' ] ) !!}
                    </div>
                </div>

                <div class="form-group student-block" >
                    <div class="left-side">
                        <label class="label-control label-table">Group User</label>
                    </div>
                    <div class="right-side">
                        <table class="table table-blue table-dropdown">
                            <thead>
                            <tr>
                                <th>Group cha</th>
                                <th>Group con</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Group cha 1</td>
                                    <td>
                                        <div class="item">
                                            <div class="custom-select-table">
                                                {!!
                                                    Form::select('group[]', [1 => "Group Con 1", "Group Con 2"], null, ['class' => 'table-select group-id', 'placeholder' => "Chọn 1 group"])
                                                !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">Trạng thái</label>
                    </div>
                    <div class="right-side">
                        <div class="custom-select">
                             {!! Form::select('setting_status', [1 => "Đang hoạt động", "Tạm ngưng"], null, ['class' => 'form-control', "placeholder" => "Chọn một"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">
                            <span class="label-control">Show nodal</span>
                        </label>
                    </div>
                    <div class="right-side">
                        <button class="btn btn-blue-dark btn-custom-sm btn-custom-top-m7" id="select-protector-btn" type="button">Show modal</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">
                            <span class="label-control">Show nodal</span>
                        </label>
                    </div>
                    <div class="right-side">
                        <div class="custom-multiple">
                            <div class="custom-items">
                                <div class="custom-item"><input type="checkbox" name="checkbox[]" checked="checked"><span>Check 1</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]"><span>Check 2</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]" checked="checked"><span>Check 3</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]"><span>Check 4</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]"><span>Check 5</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]"><span>Check 6</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]"><span>Check 7</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]"><span>Check 8</span></div>
                                <div class="custom-item"><input type="checkbox" name="checkbox[]"><span>Check 9</span></div>
                                <div class="custom-item"><input type="checkbox" checked="checked" name="checkbox[]"><span title="">Check ytutyutytyity tyi tyi tyityityititityi</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="group-profile">
                <h4>Service Profile Item</h4>
                {{-- Single Select --}}
                <div class="form-group ">
                    <label class="item-field label-error">
                        <span>管理ユーザー名</span>
                        <span class="span-required pull-right">必須</span>
                    </label>
                    <label class="item-value">
                        <input class="form-control" id="admin_username" maxlength="32" placeholder="32文字以内" name="admin_username" type="text" value="">
                    </label>
                </div>

                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">User</label>
                    </div>
                    <div class="right-side">
                        <div class="birthday-block clearfix">
                           <div class="custom-select w-100 pull-left">
                               {!! Form::selectRange("year", 1990, date('Y'), date('Y'), ['class' => 'w-100 pull-left year single', 'placeholder' => "Year", 'id' => "year"]) !!}
                           </div>
                           <span class="pull-left">Year</span>

                           <div class="custom-select w-100 pull-left monthday">
                               {!! Form::selectRange("year", 1, 12, date('m'), ['class' => 'w-100 pull-left month single', 'placeholder' => "Month", 'id' => "month"]) !!}
                           </div>
                           <span class="pull-left">Month</span>

                           <div class="custom-select w-100 pull-left monthday">
                               {!! Form::selectRange("day", 1, 31, date('d'), ['class' => 'w-100 pull-left day single', 'placeholder' => "Day", 'id' => "day"]) !!}
                           </div>
                           <span class="pull-left">Day</span>
                       </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">User</label>
                    </div>
                    <div class="right-side">
                        <div class="group-datepicker">
                            {!! Form::text('Txt', null, ['class' => 'form-control custom-datepicker', 'placeholder' => "Datetime...", 'id' => 'datetime']) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                        <div class="group-timepicker">
                            <input class="form-control custom-timepicker hasWickedpicker" placeholder="11:53" name="time_finish_to" type="text" onkeypress="return false;" aria-showingpicker="true" tabindex="-1">
                            <span class="icon-picker"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-search">
                {!! Form::submit( "Search", ["class"=>"btn btn-blue-light btn-w150"]) !!}
                {!! Form::submit( "Search", ["class"=>"btn btn-orange btn-w150"]) !!}
                {!! Form::button( "Search", ["class"=>"btn btn-blue-dark btn-w150"]) !!}
                {!! Form::button( "Search", ["class"=>"btn btn-red btn-w150"]) !!}
                {!! Form::button( "Search", ["class"=>"btn btn-gray btn-w150"]) !!}
                {!! Form::button( "Search", ["class"=>"btn btn-green-dark btn-w150"]) !!}
                {!! Form::button( "Search", ["class"=>"btn btn-green-dark btn-custom-sm"]) !!}
                {!! Form::button( "Search", ["class"=>"btn btn-green-dark btn-custom-lg"]) !!}
            </div>
            <div class="search-result">
                <h2>Kết quả tìm kiếm</h2>
                <div class="load-content-list-user">
                    <div class="form-group">
                        <span style="font-size:15px;color: #3d4e79"> Kết quả: 1232 records 1-30件表示</span>
                    </div>
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">Sắp xếp</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select('sort_item', [12,34,4], null, ['class' => 'form-control', 'id' => 'sort_item']) !!}
                            </div>
                        </div>
                    </div>
                    <p> <button class="center-block btn btn-orange btn-w150 btn-csv" name="download_csv" value="1">Button thường</button></p>
                    <p><a href="#" class="center-block btn btn-orange btn-w150 btn-csv csv-disable link-disabled-csv" disabled='true'>Button Disable</a></p>
                    <div class="content-result-list-user">
                        <nav class="text-center" aria-label="...">
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
                        </nav>

                        <table class="table table-blue table-list-user">
                            <thead>
                                <tr>
                                    <th style="width: 13%;">ID</th>
                                    <th style="width: 13%;">Tên công ty</th>
                                    <th style="width: 14%;">Ngày tham gia</th>
                                    <th style="width: 14%;">Ngày đại diện</th>
                                    <th style="width: 8%;">Tàu riêng</th>
                                    <th style="width: 10%;">Hóa đơn</th>
                                    <th style="width: 13%;">Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="word-wrap: break-word;">1</td>
                                    <td style="word-wrap: break-word;">Cmaxs</td>
                                    <td style="">cmaxs</td>
                                    <td style="">lorem ispum</td>
                                    <td>keep camlp</td>
                                    <td><span class="span-danger">Reated</span></td>
                                    <td>
                                        <a href="#" class="btn btn-blue-dark btn-custom-sm">Xóa</a>
                                        <a href="#" class="btn btn-blue-dark btn-custom-sm btn-lock">Chi tiết</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav class="text-center" aria-label="...">
                            <ul class="pagination">
                              <li class="page-item disabled">
                                <span class="page-link">Previous</span>
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
                        </nav>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal modal-search-protector fade" id="modal-search-protector" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="POST" action="https://mufmgr.schl.jp/users/general/individual/search/protector" accept-charset="UTF-8" class="form-content" id="form-search-protector"><input name="_token" type="hidden" value="y1aFjVR9wv07HbNQiX9MGDpbMRHO5HUQNl1eVSkr">
            <div class="modal-body">
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">ユーザーID</label>
                    </div>
                    <div class="right-side">
                        <input type="text" class="form-control" name="modal_user_id" placeholder="半角英数字">
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">ログインID</label>
                    </div>
                    <div class="right-side">
                        <input class="form-control" placeholder="半角英数字" name="modal_login_id" type="text">
                    </div>
                </div>

                <div class="group-profile" style="margin-bottom: 21px;">
                    <h4>プロフィール</h4>
                        <div class="form-group">
                            <div class="left-side">
                                <label class="label-control">メールアドレス</label>
                            </div>
                            <div class="right-side">
                                <input class="form-control" maxlength="255" id="modal_user_attribute_key_num.F" name="name_Fmodal" type="text">
                            </div>
                        </div>

                </div>
                <div class="btn-search" style="margin-bottom: 25px;">
                    <button class="btn btn-orange btn-w150" id="search-protector-btn-modal" type="button">検索</button>
                </div>
                <div id="msgNoRecord" style="display:none;">
                    <h3>検索結果が0件でした。</h3>
                </div>
                <div class="search-result" id="result-search-protector">
                </div>
            </div></form>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript" src="{{ asset('js/users-general-list-user.js') }}"></script>
<script>
    $(document).on("click","#select-protector-btn",function(){$("#modal-search-protector").modal("show")});
</script>
@endsection
