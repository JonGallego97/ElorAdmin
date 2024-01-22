@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    @if(request()->is('admin/students*'))
                        {{ __('Students') }}
                    @elseif(request()->is('admin/teachers*'))
                        {{ __('Teachers') }}
                    @else
                        {{ __('Users') }}
                    @endif
                    {{ __('Colon') }} {{$users->total()}}
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('users.create') }}" class="me-2" role="button">
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
                        <a href="{{ route('users.show', $user)}}" role="button">
                            {{$user->name}}
                        </a>
                    </td>
                    <td>{{$user->surname1}}</td>
                    <td>{{$user->surname2}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('users.edit', $user) }}" class="me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users/destroy" data-type="{{__('user')}}" data-id="{{ $user->id }}" data-name="{{ $user->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            @if ($users->total() > 10)
            <div class="form-inline col">
                <form
                @if(request()->is('admin/students*'))
                    action="{{ route('admin.students.index') }}"
                @elseif(request()->is('admin/teachers*'))
                    action="{{ route('admin.teachers.index') }}"
                @endif
                class="form-inline" method="GET" id="perPageForm">
                    <label class="mr-2" for="per_page">{{__('Show')}}{{__('Colon')}}</label>
                    <select class="form-control" name="per_page" id="per_page" onchange="document.getElementById('perPageForm').submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    </select>
                </form>
            </div>
            @endif
            <div class="d-flex justify-content-end col">
                {!! $users->links('vendor.pagination.default') !!}
            </div>
        </div>
    @endsection

