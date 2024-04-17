<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin/dashboard', []) }}" class="brand-link">
        <img src="{{asset('admin-assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Bit Mascot</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @auth
            <div class="image">
                @if (Auth::user()->getFirstMedia('user-profile'))
                <img src="{{Auth::user()->getFirstMedia('user-profile')->getUrl()}}" class="img-circle elevation-2"
                    alt="User Image">
                @else
                <img src="{{asset('upload/img/avatar/default-avatar.png')}}" class="img-circle elevation-2"
                    alt="User Image">
                @endif
                @endauth


            </div>
            <div class="info">
                @if (Auth::check())
                <a href="{{ url('profile') }}" class="d-block">{{Auth::user()->full_name}}</a>
                @endif

            </div>
        </div>
        <!-- Sidebar user panel (optional) -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MENU</li>
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard', []) }}" class="nav-link @if (Request::is("admin/dashboard")) active
                        @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @role('super-admin|admin')
                <li class="nav-item">
                    <a href="{{ url('/admin/users', []) }}" class="nav-link @if (Request::is("admin/users")) active
                        @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User List
                        </p>
                    </a>
                </li>
                @endrole

                <li class="nav-item has-treeview
                @if (Request::is("admin/profile") || Request::is("admin/profile/*")) menu-open @endif ">
                <a href=" #" class="nav-link
                    @if (Request::is("admin/profile") || Request::is("admin/profile/*")) active @endif">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Account Settings
                        <i class="fas fa-angle-left right"></i>

                    </p>
                    </a>
                    @if (Auth::check())
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('profile') }}" class="nav-link @if (Request::is("admin/profile"))
                                active @endif">
                                <i class="far fa-id-badge nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>



                    </ul>
                    @endif

                </li>

                {{-- SETTINGS --}}
                {{-- Access Control --}}
                @role('super-admin|admin')
                <li class="nav-header">MANAGEMENT</li>
                <li class="nav-item has-treeview
                @if (Request::is("admin/access-control/*")) menu-open @endif ">
                <a href=" #" class="nav-link
                    @if (Request::is("admin/access-control/*")) active @endif">
                    <i class="nav-icon fas fa-shield-alt"></i>
                    <p>
                        Access Control
                        <i class="fas fa-angle-left right"></i>

                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/access-control/users', []) }}" class="nav-link @if (Request::is("admin/access-control/users")) active @endif">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
