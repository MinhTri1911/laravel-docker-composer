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
                    <a id="paginate-prev" data-url="{{ ($type == 0) ? $paginator->url($current - 1) : $url . ($current - 1) }}" >
                        <span>前の{{ $paginator->perPage() }}件</span>
                    </a>
                </li>
                @if($total > 5 && $current > $interval + 1)
                    <li class="first-page">
                        <a id="paginate-1" data-url="{{ ($type == 0) ? $paginator->url(1) : $url . 1 }}">
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
                        <a id="paginate-{{ $i }}" data-url="{{ ($type == 0) ? $paginator->url($i) : $url . $i }}">{{$i}}</a>
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
                        <a id="paginate-{{ $total }}" data-url="{{ ($type == 0) ? $paginator->url($total) : $url . $total }}">
                            <span>{{ $total }}</span>
                        </a>
                    </li>
                @endif
                    <li class="next-20">
                        <a id="paignate-{{ $current + 1 }}" data-url="{{ ($type == 0) ? $paginator->url($current + 1) : $url . ($current + 1) }}">
                            <span>次の{{ $paginator->perPage() }}件</span>
                        </a>
                    </li>
            @endif
        </ul>
    </nav>
@endif
