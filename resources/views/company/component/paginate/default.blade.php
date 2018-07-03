@if (isset($paginator) && $paginator->lastPage() > 1)
    <nav class="text-center">
        <ul class="pagination">
            @php
                $interval = 2;
                $total = $paginator->lastPage();
                $current = $paginator->currentPage();

                if($total <= 5) {
                    $from = 1;
                    $to = $total;
                } else {
                    $from = $paginator->currentPage() - $interval;
                    $to = $paginator->currentPage() + $interval;

                    if ($from < 1) {
                        $to = $to + abs($from) + 1;
                        $from = 1;
                    } elseif ($to > $paginator->lastPage()) {
                        $from = $from - abs($total - $to);
                        $to = $total;
                    }
                }
            @endphp

            <!-- first/previous -->
            @if($current > 1)
                <li class="previous-20">
                    <a id="paginate-prev" data-url="{{ $url . ($current - 1) }}" >
                        <span>{{ trans('company.btn_prev') }}</span>
                    </a>
                </li>
                @if($total > 5 && $current > $interval + 1)
                    <li class="first-page">
                        <a id="paginate-first-page" data-url="{{ $url . 1 }}">
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

            <!-- links -->
            @for($i = $from; $i <= $to; $i++)
                @php
                    $isCurrentPage = $current == $i;
                @endphp
                <li class="{{ $isCurrentPage ? 'active' : '' }}">
                    @if ($isCurrentPage)
                        <a>{{ $i }}</a>
                    @else
                        <a id="paginate-{{ $i }}" data-url="{{ $url . $i }}">{{$i}}</a>
                    @endif
                </li>
            @endfor

            <!-- next/last -->

            @if($current < $total)
                @if($total > 5 && $current < $total - $interval )
                    <li class="disable">
                        <a>
                            <span>...</span>
                        </a>
                    </li>
                    <li class="last-page">
                        <a id="paginate-{{ $total }}" data-url="{{ $url . $total }}">
                            <span>{{ $total }}</span>
                        </a>
                    </li>
                @endif
                    <li class="next-20">
                        <a id="paignate-last-page" data-url="{{ $url . ($current + 1) }}">
                            <span>{{ trans('company.btn_next') }}</span>
                        </a>
                    </li>
            @endif
        </ul>
    </nav>
@endif
