<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/logo_aljauhar.jpg') }}" type="image/icon type">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    {{-- <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script> --}}
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        (function () {
            window.Laravel={
                csrfToken: '{{ csrf_token() }}'
            };
          })();
    </script>
</head>
<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper" id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                      </li>

                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <p>
                            <i class="nav-icon fas fa-power-off"></i>
                            Logout
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{route('home')}}" class="brand-link">
                <img src="{{ asset('img/logo_aljauhar.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AL-JAUHAR</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar overflow-hidden">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (auth()->user()->photo == 'avatar.jpg' && auth()->user()->photo )
                            <img src="{{ asset("img/user.svg") }}" class="img-circle elevation-2" alt="User Image">
                        @else
                            <img src="{{ asset("upload/profil/".auth()->user()->photo) }}" class="img-circle elevation-2" alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{route("user.profile")}}" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{route('home')}}" class="nav-link {{ request()->is('home') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-chalkboard"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ request()->is('Management') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('create role')
                                <li class="nav-item ml-3">
                                    <a href="{{ route('role.index') }}" class="nav-link {{ request()->is('role') ? 'active' : ''}}">
                                        <i class="fas fa-bomb nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a href="{{ route('permission.index') }}" class="nav-link {{ request()->is('permission') ? 'active' : ''}}">
                                        <i class="fas fa-bomb nav-icon"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                                @endcan
                                @can('melihat pendaftar')
                                <li class="nav-item ml-3">
                                    <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user') ? 'active' : ''}}">
                                        <i class="fas fa-users-cog nav-icon"></i>
                                        <p>User aktif</p>
                                    </a>
                                </li>
                                @endcan
                                <li class="nav-item ml-3">
                                    <a href="/alumni" class="nav-link {{ request()->is('alumni') ? 'active' : ''}}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Alumni</p>
                                    </a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a href="/santri" class="nav-link {{ request()->is('santri') ? 'active' : ''}}">
                                        <i class="fas fa-user nav-icon"></i>
                                        <p>Santri</p>
                                    </a>
                                </li>
                                @can('melihat pendaftar')
                                <li class="nav-item ml-3">
                                    <a href="{{route("pendaftaran.santri")}}" class="nav-link {{ request()->is('pendaftaran-santri') ? 'active' : ''}}">
                                        <i class="fas fa-user-plus nav-icon"></i>
                                        <p>Pendaftaran Santri</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @can('membuat biografi')
                        <li class="nav-item">
                            <a href="{{route("biografi")}}" class="nav-link {{ request()->is('biografi') ? 'active' : ''}}">
                                {{-- <i class="fas fa-user-plus"></i> --}}
                                <i class="fas fa-address-card nav-icon"></i>
                                <p>Biografi</p>
                            </a>
                        </li>
                        @endcan
                        @can("membuat artikel")
                        <li class="nav-item">
                            <a href="{{route("artikel.index")}}" class="nav-link {{ request()->is('artikel') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-paste"></i>
                                <p>
                                    Artikel
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('membuat berita')
                        <li class="nav-item">
                            <a href="{{route('berita.index')}}" class="nav-link {{ request()->is('berita') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-newspaper nav-icon"></i>
                                <p>
                                    Berita
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('membuat berita')
                        <li class="nav-item">
                            <a href="{{route('testimoni.index')}}" class="nav-link {{ request()->is('testimoni') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-comment-dots"></i>
                                <p>
                                    Testimoni
                                </p>
                            </a>
                        </li>
                        @endcan

                        <li class="nav-item">
                            <a href="{{ route('userGetPassword') }}" class="nav-link {{ request()->is('password/change') ? 'active' : ''}}">
                                <i class="fas fa-lock nav-icon"></i>
                                <p>
                                    Ganti Password
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.profile') }}" class="nav-link {{ request()->is('profile') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 399px;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@yield('pageName')</h1>
                        </div><!-- /.col -->
                        {{-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div><!-- /.col --> --}}
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @include('partials.alert')
                    @yield('content')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            {{-- <div class="float-right d-none d-sm-inline">
                Official website PPM AL-JAUHAR
            </div> --}}
            <!-- Default to the left -->
            Official website PPM AL-JAUHAR
        </footer>
        <div id="sidebar-overlay"></div>
    </div>
    <!-- ./wrapper -->
    </body>

</html>
