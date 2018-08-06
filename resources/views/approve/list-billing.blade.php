<h4 class="rs-title">{{__('approve.header_billing')}}</h4>
<div class="content-block table-block">
    <div class="extra-block">
        <div class="pull-left lbl-page-text">{{__('approve.lbl_page_text', ['total' => $datas->total()])}}</div>
        <div class="limit-block pull-right">
            <span class="lbl_limit">{{__('ship-contract.detail.lbl_limit')}}</span>
            <div class="custom-select" style="min-width:100px">
                {{ Form::select('limit_page', \App\Common\Constant::ARY_PAGINATION_PER_PAGE, request()->filled('limit')?request()->get('limit'):null, ['class' => count($datas) > 0?'form-control limit-page':'form-control', 'tabindex' => 5]) }}
            </div>
        </div>
    </div>
    <table class="table table-blue table-contract">
        <thead>
            <tr>
                <th class="custom-checkbox">
                    @if(count($datas) > 0)
                    <input class="hidden" id="chk_ct_full" name="n" type="checkbox">
                    <label for="chk_ct_full"></label>
                    @endif
                </th>
                <th>{{__('approve.lbl_billing_id')}}</th>
                <th>{{__('approve.lbl_billing_company')}}</th>
                <th>{{__('approve.lbl_billing_date_create')}}</th>
                <th>{{__('approve.lbl_billing_date_plan')}}</th>
                <th>{{__('approve.lbl_billing_money')}}</th>
                <th>{{__('approve.lbl_billing_date')}}</th>
                <th>{{__('approve.lbl_billing_creator')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if(count($datas) > 0)
                @foreach($datas as $billing)
                    <tr id="item-approve-{{$billing->billing_id}}">
                        <td class="custom-checkbox">
                            <input class="hidden" id="chk_c_{{$billing->billing_id}}" name="chk_contract" type="checkbox">
                            <label for="chk_c_{{$billing->billing_id}}"></label>
                        </td>
                        <td>{{$billing->billing_id}}</td>
                        <td>{{$billing->billing_company_name}}</td>
                        <td>{{!is_null($billing->billing_claim_date)?\Carbon\Carbon::parse($billing->billing_claim_date)->format('Y/m/d'):''}}</td>
                        <td>{{!is_null($billing->billing_payment_due_date)?\Carbon\Carbon::parse($billing->billing_payment_due_date)->format('Y/m/d'):''}}</td>
                        <td>{{Str::convertMoneyComma($billing->billing_total_amount_billing)}}</td>
                        <td>{{!is_null($billing->billing_created_at)?\Carbon\Carbon::parse($billing->billing_created_at)->format('Y/m/d H:i:s'):''}}</td>
                        <td>{{$billing->billing_user_name}}</td>
                        <td><a class="btn btn-blue-dark btn-custom-sm" target="_blank" href="{{$billing->billing_pdf_original_link}}">{{__('approve.btn_detail')}}</a></td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="9">{{__('approve.lbl_no_record')}}</td>
            </tr>
            @endif
        </tbody>
    </table>
    @if(count($datas) > 0)
        @if(!request()->has('setting_status') || 
                (request()->has('setting_status') && request()->get('setting_status') != \App\Common\Constant::STATUS_REJECT_APPROVE))
            <div class="block-handle align-right">
                <div class="btn btn-red btn-w150 btn-reject" data-type="2">{{__('approve.btn_reject')}}</div>
                <div class="btn btn-blue-dark btn-w150 btn-approve" data-type="2">{{__('approve.btn_approve')}}</div>
            </div>
        @endif
    @endif
    <div class="block-paginate block-handle align-center">
        <div class="fl-page">
            {{$datas->appends($_GET)->render()}}
        </div>
    </div>
</div>
