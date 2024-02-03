@extends('layouts.app')
    @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-start bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item" style="text-align: center; margin-top: 10px;margin-bottom: 10px;">
                                <img src="{{ asset('images/admin/Elorrieta_Logo.svg') }}" style="max-width: 80%; margin: 0 auto; display: block;" />
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('admin.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.index') }}">
                                    {{__('Dashboard')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('admin.users.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.users.index') }}">
                                    {{__('Users')}}
                                </a>
                                <div id="usuariosCollapse">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class=" ml-3 small nav-link{{ Route::is('admin.students.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.students.index') }}">
                                                {{__('Students')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="  ml-3 small nav-link{{ Route::is('admin.teachers.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.teachers.index') }}">
                                                {{__('Teachers')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="  ml-3 small nav-link{{ Route::is('admin.personal.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.personal.index') }}">
                                                {{__('Personal')}}</a>
                                        </li>
                                        <li class="nav-item {{ Route::is('admin.withoutRole.index') ? ' active' : '' }}">
                                            <a class="  ml-3 small nav-link{{ Route::is('admin.withoutRole.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.withoutRole.index') }}">
                                                {{__('UsersWithoutRole')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                
                                <a class="nav-link{{ Route::is('admin.roles.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.roles.index') }}">
                                    {{__('Rols')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                
                                <a class="nav-link{{ Route::is('admin.departments.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.departments.index') }}">
                                    {{__('Departments')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                
                                <a class="nav-link{{ Route::is('admin.cycles.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.cycles.index') }}">
                                    {{__('Cycles')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                
                                <a class="nav-link{{ Route::is('admin.modules.index') ? ' font-weight-bold' : '' }}" href="{{ route('admin.modules.index') }}">
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
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteModalLabel">{{__('confirm_deletion')}}</h1>
                        </div>
                        <div class="modal-body">
                            {{__('are_you_sure_delete')}} <span id="type"></span>{{__('Colon')}} <span id="name"></span>{{__('Question')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('cancel')}}</button>
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary" >{{__('delete')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div id="errorModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#errorModal').modal('show');
                    });
                </script>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/delete.js') }}"></script>
@endsection
