@extends('layouts.main')

@section('sideNav')

<div class="container-fluid">
    <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
            <div class="main-navbar">
                <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                    <a class="navbar-brand w-100 mr-0" href="{{ route('dashboard') }}" style="line-height: 25px;">
                        <div class="d-table m-auto">
                            <img id="main-logo" class="d-inline-block align-center mr-1" style="max-width: 30px;" src="{{ asset('frontend') }}/images/logo.png" alt="petakom logo">
                            <span class="d-none d-md-inline ml-1"> {{ config('app.name', 'Vizika') }}</span>
                        </div>
                    </a>
                    <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                        <i class="material-icons">&#xE5C4;</i>
                    </a>
                </nav>
            </div>
            <!-- <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
                    <div class="input-group input-group-seamless ml-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
                    </div>
                </form> -->
            <div class="nav-wrapper">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="material-icons">info</i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- DASHBOARD START -->
                    @if( auth()->user()->category== "Contractor")
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="material-icons">work</i>
                            <span>Safety Briefing</span>
                        </a>
                    </li>
                    @endif

                    @if( auth()->user()->category== "Visitor" || auth()->user()->category== "SHEQ Guard")
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('appointment*') ? 'active' : '' }}" href="{{ route('appointment') }}">
                            <i class="material-icons">today</i>
                            <span>Appointment</span>
                        </a>
                    </li>
                    @endif

                    @if( auth()->user()->category== "SHEQ Officer")
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="material-icons">checklist</i>
                            <span>Visitor Log</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="material-icons">event</i>
                            <span>Calendar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('visitor*') ? 'active' : '' }}" href="{{ route('visitor') }}">
                            <i class="material-icons">badge</i>
                            <span>Visitors</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="material-icons">assessment</i>
                            <span>Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="material-icons">work</i>
                            <span>Safety Briefing</span>
                        </a>
                    </li>
                    @endif

                    @if( auth()->user()->category== "SHEQ Guard")
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="material-icons">fingerprint</i>
                            <span>Biometric</span>
                        </a>
                    </li>
                    @endif

                    @if( auth()->user()->category== "Staff")
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('appointment*') ? 'active' : '' }}" href="{{ route('appointment') }}">
                            <i class="material-icons">today</i>
                            <span>Appointment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('choosevisitor*') ? 'active' : '' }}" href="{{ route('choosevisitor') }}">
                            <i class="material-icons">today</i>
                            <span>Visitor & Contractor</span>
                        </a>
                    </li>
                    @endif


                    <!-- DASHBOARD START -->

                </ul>


            </div>

        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
            <div class="main-navbar sticky-top bg-white">
                <!-- Main Navbar -->
                <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">

                    <div class="row mt-auto mb-auto ml-3 " style="width: auto;">

                        <div class="d-md-flex mt-auto mb-auto mr-md-4 d-none" style="width: auto">

                        </div>

                    </div>
                    <ul class="navbar-nav border-left flex-row ml-auto ">
                        <li class="nav-item border-right dropdown">
                            <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <img class="user-avatar rounded-circle mr-2" src="{{ asset('frontend') }}/images/avatar.jpg" alt="Avatar" width="30px" height="30px" style="vertical-align:baseline">
                                <span class="d-none d-md-inline-block"><strong>{{ Auth::user()->name }}</strong><br> {{Auth::user()->category}}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-small">
                                <a class="dropdown-item" href="{{ route('profile', Auth::user()->id ) }}">
                                    <i class="material-icons">&#xE7FD;</i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="material-icons text-danger">&#xE879;</i> Logout </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                    <nav class="nav">
                        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                            <i class="material-icons">&#xE5D2;</i>
                        </a>
                    </nav>
                </nav>
            </div>
            <!-- / .main-navbar -->

            @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <i class="fa fa-check mx-2"></i>

                {{ session()->get('success') }}
            </div>
            @endif

            @if(session()->get('failed'))
            <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <i class="fa fa-times mx-2"></i>

                {{ session()->get('failed') }}
            </div>
            @endif

            <div class="main-content-container container-fluid px-4">
                <br>
                @yield('content')
            </div>

            <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
                <span class="copyright ml-auto my-auto mr-2">Copyright © {{ now()->year }}
                    <a href="#" rel="nofollow">KANEKA Malaysia Sdn. Bhd.</a>
                </span>
            </footer>

    </div>
</div>

<!-- End Page Header -->


@endsection