@if(property_exists($ship, 'spots') && !is_null($ship->spots) && $ship->spots->count() > 0)
    <h4>{{__('ship-contract.detail.lbl_ship_spot')}}</h4>
    <div class="content-block table-block spot-block">
        <div class="extra-block">{{__('ship-contract.detail.lbl_no_ship_spot', ['number' => $ship->spots->total()])}}</div>
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
                @foreach($ship->spots as $spot)
                <tr>
                    <td style="word-wrap: break-word;">{{$spot->spot_id}}</td>
                    <td style="word-wrap: break-word;">{{$spot->spot_name}}</td>
                    <td style="word-wrap: break-word;">{{$spot->spot_month_usage}}</td>
                    <td>{{$spot->spot_amount_charge}}</td>
                    <td style="">
                        <span class="approve-spot-{{$spot->spot_id}}">
                            @if($spot->spot_approved_flag == 1)
                                {{\App\Common\Constant::APPROVED_O[1]}}
                            @elseif($spot->spot_approved_flag == 2)
                                {{\App\Common\Constant::APPROVED_O[2]}}
                            @else
                            <text class="view-reason" data-type="spot" data-id="{{$spot->spot_id}}">
                                {{\App\Common\Constant::APPROVED_O[3]}}
                            </text>
                            @endif
                        </span>
                    </td>
                    <td style="">{{$spot->spot_created_at}}</td>
                    <td style="">{{$spot->spot_updated_at}}</td>
                    <td>
                        @if(!empty($spot->spot_month_usage) && date('Y-m', strtotime($spot->spot_month_usage)) == date('Y-m'))
                            <a href="{{route('spot.edit', $spot->spot_id)}}" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_edit')}}</a>
                            <button class="btn btn-red btn-custom-sm delete-spot" data-ship="{{$ship->detail_ship->ship_id}}" data-spot="{{$spot->spot_id}}">{{__('ship-contract.detail.btn_delete')}}</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="fl-block">
            <div class="fl-page fl-left">
                {{$ship->spots->links()}}
            </div>
            <div class="fl-page fl-right">
                <div class="block-handle align-right">
                    <a href="#" class="btn btn-blue-light btn-w150">{{__('ship-contract.detail.btn_back')}}</a>
                    <a href="/spot/create" class="btn btn-green-dark btn-w150 pull-right">{{__('ship-contract.detail.btn_create')}}</a>
                </div>
            </div>
        </div>
    </div>
    {{-- End List Spot --}}
    @endif