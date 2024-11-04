<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('dashboard')}}">
                    <span class="brand-logo"><img></span>
                    <h2 class="brand-text">Product</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-item"><a class="d-flex align-items-center" href="{{route('dashboard')}}"><i
                        data-feather="home"></i><span class="menu-title text-truncate"
                        data-i18n="Dashboards">Dashboards</span></a>
            </li>
            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span
                        class="menu-title text-truncate" data-i18n="Page Layouts">Roles Management</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{route('roles.index')}}"><i
                                data-feather="circle"></i><span class="menu-item" data-i18n="Collapsed Menu">Manage
                                Role</span></a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span
                        class="menu-title text-truncate" data-i18n="Page Layouts">User Management</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{route('users.index')}}"><i
                                data-feather="circle"></i><span class="menu-item" data-i18n="Collapsed Menu">Manage
                                Admin</span></a>
                    </li>
                </ul>
            </li> --}}

            <li class="{{ in_array(request()->route()->getName(), ['products.index', 'products.create', 'products.edit']) ? 'active' : '' }} nav-item"><a class="d-flex align-items-center" href="{{route('products.index')}}"><i
                data-feather="layers"></i><span class="menu-title text-truncate"
                data-i18n="Dashboards">Products</span></a>
            </li>

            <li class="{{ in_array(request()->route()->getName(), ['batch.index', 'batch.create', 'batch.show']) ? 'active' : '' }}
                nav-item"><a class="d-flex align-items-center" href="{{route('batch.index')}}"><i
                data-feather="folder"></i><span class="menu-title text-truncate"
                data-i18n="Dashboards">Batch</span></a>
            </li>
            <li class="{{ request()->routeIs('products.verified') ? 'active' : '' }} nav-item"><a class="d-flex align-items-center" href="{{route('products.verified')}}"><i
                data-feather="layers"></i><span class="menu-title text-truncate"
                data-i18n="Dashboards">Verified Products</span></a>
            </li>
        </ul>
    </div>
</div>
