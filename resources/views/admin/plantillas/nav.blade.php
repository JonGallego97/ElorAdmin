@extends('layouts.app')
    @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('admin.index') }}">
                                    {{__('Dashboard')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                {{--<a class="nav-link d-flex align-items-center gap-2" href="{{route('admin.users.index')}}">--}}

                                <a class="nav-link" data-toggle="collapse" href="#usuariosCollapse" role="button" aria-expanded="ture" aria-controls="usuariosCollapse">
                                    {{__('Users')}}
                                    </a>
                                    <div class="collapse" id="usuariosCollapse">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link ml-3 small" href="#">{{__('Students')}}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link ml-3 small" href="#">{{__('Teachers')}}</a>
                                            </li>
                                        </ul>
                                    </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('home') }}">
                                    {{__('Rols')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('home') }}">
                                    {{__('Departments')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('home') }}">
                                    {{__('Cycles')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('home') }}">
                                    {{__('Modules')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('nav')
            </main>
        </div>
    </div>
@endsection
