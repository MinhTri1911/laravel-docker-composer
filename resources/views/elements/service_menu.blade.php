<section class="menu">
    <div class="wrap-menu">
        <div class="container-fluid container-menu-fixed">
            <div class="menu-row">

                <div class="menu-link">
                    <a href="{{ url('/') }}" class="btn btn-menu @if(\Request::is('/') || \Request::is('company')) active @endif">
                        {{ trans('company.head_list_company') }}
                    </a>
                </div>
                <div class="menu-link">
                    <a href="{{ route('ship.index') }}" class="btn btn-menu @if(\Request::is('ship'))) active @endif">
                        {{ trans('ship.head_title_list_ship') }}
                    </a>
                </div>
                <div class="menu-link">
                    <a href="{{ route('approve.list') }}" class="btn btn-menu  @if(\Request::is('approve'))) active @endif">
                        {{ trans('approve.header_approve') }}
                    </a>
                </div>
                @if (auth()->user()->auth_admin == true)
                <div class="menu-link">
                    <a href="{{ route('auth.list') }}" class="btn btn-menu  @if(\Request::is('auth'))) active @endif">
                        {{ trans('auth.list_title') }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>