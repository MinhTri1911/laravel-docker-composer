@if (isset($paginator) && $paginator->lastPage() > 1)
    <nav class="text-center">
        <ul class="pagination">
            <?php 
                $total = $paginator->lastPage();
                $current = $paginator->currentPage();
                
                // Get min max
                $min = (((int)($current/10))*10) + 1;
                $max = $min + 9;
                
                if ($max > $total) {
                    $max = $total;
                }
            ?>
            
            <!-- first/previous -->
            @if($current > 10)
                <li class="previous-20">
                    <a href="{{ $paginator->url($min - 10) }}">
                        <span>前の{{$min - 1}}件</span>
                    </a>
                </li>
            @endif
            
            <!-- links -->
            @for($page = $min; $page <= $max; $page++)
                <?php 
                $isCurrentPage = $current == $page;
                ?>
                <li class="{{ $isCurrentPage ? 'active' : '' }}">
                    <a  {{ !$isCurrentPage ? 'href=' . $paginator->url($page) : '' }}>
                        {{ $page }}
                    </a>
                </li>
            @endfor
            
            <!-- next/last -->
            
            @if($total > $max)
                <li class="next-20">
                    <a href="{{ $paginator->url($min + 10) }}">
                        <span>次{{$total - $max}}件へ</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif