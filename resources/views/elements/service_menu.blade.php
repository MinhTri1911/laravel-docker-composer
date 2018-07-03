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
                @auth
                <div class="menu-link">
                    <a href="{{ route('logout') }}" class="btn btn-menu" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>