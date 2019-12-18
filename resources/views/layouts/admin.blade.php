<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Titan') }}</title>

    <!-- Scripts -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script src="{{ mix('js/admin.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">

</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-robot"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Titan <sup>{{ config('titan.version') }}</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Engine
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item   @if(\Illuminate\Support\Str::contains(request()->path(), ['admin/groups', 'admin/users'])) active @endif">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#usersAndRolesMenu" aria-expanded="@if(\Illuminate\Support\Str::contains(request()->path(), ['admin/groups', 'admin/users'])) true @else false @endif" aria-controls="usersAndRolesMenu">
                <i class="fas fa-fw fa-folder"></i>
                <span>Users & Roles</span>
            </a>
            <div id="usersAndRolesMenu" class="collapse @if(\Illuminate\Support\Str::contains(request()->path(), ['admin/groups', 'admin/users'])) show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Users</h6>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/users')) active @endif" href="{{ route('admin.users.index') }}"><i class="fas fa-user"></i> Users</a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/users/create')) active @endif" href="{{ route('admin.users.create') }}"><i class="fas fa-plus-circle"></i> Add New</a>
                    <h6 class="collapse-header">Groups</h6>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/groups')) active @endif" href="{{ route('admin.groups.index') }}"><i class="fas fa-users-cog"></i> Groups</a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/groups/create')) active @endif" href="{{ route('admin.groups.create') }}"><i class="fas fa-plus-circle"></i> Add New</a>

                </div>
            </div>
        </li>
        <li class="nav-item   @if(\Illuminate\Support\Str::contains(request()->path(), ['admin/characters', 'admin/stats'])) active @endif">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#characterStatsMenu" aria-expanded="@if(\Illuminate\Support\Str::contains(request()->path(), ['admin/characters', 'admin/stats'])) true @else false @endif" aria-controls="characterStatsMenu">
                <i class="fas fa-fw fa-folder"></i>
                <span>Characters & Stats</span>
            </a>
            <div id="characterStatsMenu" class="collapse @if(\Illuminate\Support\Str::contains(request()->path(), ['admin/characters', 'admin/stats'])) show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Characters</h6>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/characters')) active @endif" href="{{ route('admin.characters.index') }}"><i class="fa fa-chess-king"></i> Characters</a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/characters/create')) active @endif" href="{{ route('admin.characters.create') }}"><i class="fas fa-plus-circle"></i> Add New</a>
                    <h6 class="collapse-header">Stats</h6>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/stats')) active @endif" href="{{ route('admin.stats.index') }}"><i class="fas fa-heart"></i> Stats</a>
                    <a class="collapse-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/stats/create')) active @endif" href="{{ route('admin.stats.create') }}"><i class="fas fa-plus-circle"></i> Add New</a>

                </div>
            </div>
        </li>
        <li class="nav-item @if(\Illuminate\Support\Str::contains(request()->path(), 'admin/settings')) active @endif">
            <a class="nav-link" href="{{ route('admin.settings.index') }}">
                <i class="fas fa-fw fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
        <li class="nav-item @if(request()->path() === 'admin/extensions') active @endif">
            <a class="nav-link" href="{{ route('admin.extensions.index') }}">
                <i class="fas fa-fw fa-puzzle-piece"></i>
                <span>Extensions</span>
            </a>
        </li>
        <li class="nav-item @if(request()->path() === 'admin/cronjobs') active @endif">
            <a class="nav-link" href="{{ route('admin.cronjobs.index') }}">
                <i class="fas fa-fw fa-stopwatch"></i>
                <span>Cronjobs</span>
            </a>
        </li>
        <li class="nav-item @if(request()->path() === 'admin/menu') active @endif">
            <a class="nav-link" href="{{ route('admin.menu.index') }}">
                <i class="fas fa-fw fa-bars"></i>
                <span>Menus</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Extensions installed
        </div>

        @foreach(resolve('extensions') as $extension)
            <li class="nav-item @if(\Illuminate\Support\Str::contains(request()->path(), '/extensions/' . $extension->slug)) active @endif">
                <a class="nav-link" href="{{ route('admin.extensions.manage', $extension->slug) }}">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>{{ ucwords(str_replace('Extensions\\', '', $extension->namespace)) }}</span>
                </a>
            </li>
        @endforeach
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                {!! \Form::open()->route('admin.search')->attrs(['class'    =>  'd-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search']) !!}
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" name="search" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="submit()">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                {!! \Form::close() !!}

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Ian</span>
                            <img class="img-profile rounded-circle" src="https://source.unsplash.com/random/60x60">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
{{--                            <a class="dropdown-item" href="#">--}}
{{--                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                Profile--}}
{{--                            </a>--}}
{{--                            <a class="dropdown-item" href="#">--}}
{{--                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                Settings--}}
{{--                            </a>--}}
{{--                            <a class="dropdown-item" href="#">--}}
{{--                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                Activity Log--}}
{{--                            </a>--}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @include('flash::message')
                @yield('page')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Titan Game Engine, pbbg.io 2019</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
            </div>


            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

@yield('scripts')
</body>
</html>
