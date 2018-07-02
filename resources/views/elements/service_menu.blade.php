<section class="menu">
    <div class="wrap-menu">
        <div class="container-fluid container-menu-fixed">
            <div class="menu-row">
                @php
                    $prefixRouteTop = request()->route()->getPrefix();
                    $prefixRouteTop = str_replace('management', '', $prefixRouteTop);
                @endphp
               
                <div class="menu-link">
                    <a href="{{ route('user.list') }}" class="btn btn-menu @if($prefixRouteTop == '/service'||$prefixRouteTop == '/policy') active @endif">
                       Quản lý tàu
                    </a>
                </div>
                 <div class="menu-link">
                    <a href="{{ route('user.preview-pdf') }}" class="btn btn-menu @if($prefixRouteTop == '') active @endif">
                       Template PDF
                    </a>
                </div>
                <div class="menu-link">
                    <a href="{{ url('/') }}" class="btn btn-menu @if($prefixRouteTop == '') active @endif">
                       Trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>