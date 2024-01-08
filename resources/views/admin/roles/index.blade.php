@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    {{ __('Rols') }}
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('roles.create') }}" class="me-2" role="button">
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
                        <a href="{{route('roles.show', $role)}}" role="button">
                            {{$role->name}}
                        </a>
                    </td>
                    <td>{{$role->count_people}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('roles.edit', $role) }}" class="me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            @if ($roles->total() > 10)

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
                {!! $roles->links() !!}
            </div>
        </div>

        <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteRoleModalLabel">{{__('confirm_deletion')}}</h1>
                    </div>
                    <div class="modal-body">
                        {{__('are_you_sure_delete')}} <span id="roleName"></span>{{__('Question')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('cancel')}}</button>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary" >{{__('delete')}}</button>
                        </form>
                    </div>
                </div>
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
    @section('scripts')
        <script src="{{ asset('js/admin/roles/delete.js') }}"></script>
    @endsection
