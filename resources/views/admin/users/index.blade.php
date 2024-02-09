@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    @if(Route::currentRouteName() == 'admin.students.index')
                        {{ __('Students') }}
                    @elseif(Route::currentRouteName() == 'admin.teachers.index')
                        {{ __('Teachers') }}
                    @elseif(Route::currentRouteName() == 'admin.withoutRole.index')
                        {{ __('UsersWithoutRole') }}
                    @elseif(Route::currentRouteName() == 'admin.personal.index')
                        {{ __('Personal') }}
                    @else
                        {{ __('Users') }}
                    @endif
                    {{ __('Colon') }} {{$users->total()}}
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.users.create') }}" class="me-2" role="button">
                    <i class="bi bi-person-plus fs-3"></i>
                </a>

            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Surname1')}}</th>
                    <th scope="col">{{__('Surname2')}}</th>
                    <th scope="col">{{__('Mail')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('admin.users.show', $user)}}" role="button">
                            {{$user->name}}
                        </a>
                    </td>
                    <td>{{$user->surname1}}</td>
                    <td>{{$user->surname2}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        {{--<div class="d-flex">
                            <a href="{{ route('admin.users.edit', $user) }}" class="me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users" data-type="{{__('user')}}" data-id="{{ $user->id }}" data-name="{{ $user->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>--}}
                        <div class="d-flex">
                            <div class="btn-group" role="group">
                                <!-- Botón para visualizar -->
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info me-2" role="button">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <!-- Botón para editar -->
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2" role="button">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <!-- Botón para eliminar -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users" data-type="{{__('user')}}" data-id="{{ $user->id }}" data-name="{{ $user->name }}" id="openModalBtn">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            @if ($users->total() > App::make('paginationCount'))
            <div class="form-inline col">
                <form
                @if(request()->is('admin/students*'))
                    action="{{ route('admin.students.index') }}"
                @elseif(request()->is('admin/teachers*'))
                    action="{{ route('admin.teachers.index') }}"
                @elseif(request()->is('admin/teachers*'))
                    action="{{ route('admin.withoutRole.index') }}"
                @elseif(request()->is('admin/teachers*'))
                    action="{{ route('admin.persons.index') }}"
                @else
                    action="{{ route('admin.users.index') }}"
                @endif
                class="form-inline" method="GET" id="perPageForm">
                    <label class="mr-2" for="per_page">{{__('Show')}}{{__('Colon')}}</label>
                    <select class="form-control" name="per_page" id="per_page" onchange="document.getElementById('perPageForm').submit()">
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        <option value="150" {{ request('per_page') == 150 ? 'selected' : '' }}>150</option>
                        <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                    </select>
                </form>
            </div>
            @endif
            <div class="d-flex justify-content-end col">
                {!! $users->links('vendor.pagination.default') !!}
            </div>
        </div>
    @endsection

