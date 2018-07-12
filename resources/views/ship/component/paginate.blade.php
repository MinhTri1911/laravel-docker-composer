@if (isset($pagination) && $pagination->lastPage() > 1)
    <nav class="text-center">
        <ul class="pagination">
        @php
            $interval = 2;
            $total = $pagination->lastPage();
            $current = $pagination->currentPage();

            if ($total <= 5) {
                $from = 1;
                $to = $total;
            } else {
                $from = $pagination->currentPage() - $interval;
                $to = $pagination->currentPage() + $interval;

                if ($from < 1) {
                    $to = $to + abs($from) + 1;
                    $from = 1;
                } elseif ($to > $pagination->lastPage()) {
                    $from = $from - abs($total - $to);
                    $to = $total;
                }
            }
        @endphp

        {{-- Previous page --}}
        @if ($current > 1)
            <li class="previous-20">
                <a id="paginate-prev" data-url="{{ $url . ($current - 1) . '&company-id=' .$companyId }}" >
                    <span>{{ trans('company.btn_prev') }}</span>
                </a>
            </li>
            @if ($total > 5 && $current > $interval + 1)
                <li class="first-page">
                    <a id="paginate-first-page" data-url="{{ $url . 1 .'&company-id=' .$companyId }}">
                        <span>1</span>
                    </a>
                </li>
                <li class="disable">
                    <a>
                        <span>...</span>
                    </a>
                </li>
            @endif
        @endif

        {{-- List paginate --}}
        @for ($i = $from; $i <= $to; $i++)
            @php
                $isCurrentPage = $current == $i;
            @endphp
            <li class="{{ $isCurrentPage ? 'active' : '' }}">
                @if ($isCurrentPage)
                    <a id="current-page" data-page="{{ $current }}">{{ $i }}</a>
                @else
                    <a id="paginate-{{ $i }}" data-url="{{ $url . $i .'&company-id=' .$companyId }}">{{$i}}</a>
                @endif
            </li>
        @endfor

        {{-- Next page --}}
        @if ($current < $total)
            @if ($total > 5 && $current < $total - $interval )
                <li class="disable">
                    <a>
                        <span>...</span>
                    </a>
                </li>
                <li class="last-page">
                    <a id="paginate-{{ $total }}" data-url="{{ $url . $total .'&company-id=' .$companyId }}">
                        <span>{{ $total }}</span>
                    </a>
                </li>
            @endif
            <li class="next-20">
                <a id="paignate-last-page" data-url="{{ $url . ($current + 1) .'&company-id=' .$companyId }}">
                    <span>{{ trans('company.btn_next') }}</span>
                </a>
            </li>
        @endif
        </ul>
    </nav>
@endif
