@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    {{ __('Rols') }}
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.roles.create') }}" class="me-2" role="button">
                    <i class="bi bi-person-plus fs-3"></i>
                </a>

            </div>
        </div>

        <table class="table  table-striped">
            <thead>
                <tr>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('People')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>
                        <a href="{{route('admin.roles.show', $role)}}" role="button">
                            {{$role->name}}
                        </a>
                    </td>
                    <td>{{$role->count_people}}</td>
                    <td>
                        <div class="d-flex">
                           {{-- <a href="{{ route('admin.roles.edit', $role) }}" class="me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="roles" data-type="{{__('role')}}" data-id="{{ $role->id }}" data-name="{{ $role->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>--}}
                            <a href="{{ route('admin.roles.show', $role)}}" class="btn btn-info me-2" role="button">
                                <i class="bi bi-eye"></i>
                            </a>
                             <!-- Botón para editar -->
                            <a href="{{ route('admin.roles.edit', $role)  }}" class="btn btn-warning me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- Botón para eliminar -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="roles" data-type="{{__('role')}}" data-id="{{ $role->id }}" data-name="{{ $role->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            @if ($roles->total() > App::make('paginationCount'))
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
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        <option value="150" {{ request('per_page') == 150 ? 'selected' : '' }}>150</option>
                        <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                    </select>
                </form>
            </div>
            @endif
            <div class="d-flex justify-content-end col">
                {!! $roles->links() !!}
            </div>
        </div>
        @if(session('error'))
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
                            {{ session('error') }}
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
        @endsection
