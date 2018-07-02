<ul class="nav">
    @php
    	$prefixRoute = request()->route()->getPrefix();
        $prefixRoute = str_replace('management', '', $prefixRoute);
        $activeRouteSidebar = \Request::route()->getName();
    @endphp

    @if($prefixRoute == "/service" || $prefixRoute == "/policy")
    	@includeIf('elements.menu.service', ['active' => $activeRouteSidebar])

    @elseif($prefixRoute == "/admin")
    	@includeIf('elements.menu.admin-user', ['active' => $activeRouteSidebar])

    @elseif($prefixRoute == "/user")
    	@includeIf('elements.menu.common-user', ['active' => $activeRouteSidebar, 'prefixRoute' => $prefixRoute])

    @elseif($prefixRoute == "/report-content" )
    	@includeIf('elements.menu.report-content', ['active' => $activeRouteSidebar])

    @elseif($prefixRoute == "/company")
        @includeIf('elements.menu.common-user', ['active' => $activeRouteSidebar, 'prefixRoute' => $prefixRoute])

    @elseif($prefixRoute == "/ship")
    	@includeIf('elements.menu.common-user', ['active' => $activeRouteSidebar, 'prefixRoute' => $prefixRoute])

    @endif
</ul>
