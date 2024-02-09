@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    {{ __('Departments') }}
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.departments.create') }}" class="me-2" Department="button">
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
                @foreach ($departments as $department)
                <tr>
                    <td>
                        <a href="{{route('admin.departments.show', $department)}}" Department="button">
                            {{$department->name}}
                        </a>
                    </td>
                    <td>{{$department->count_people}}</td>
                    <td>
                        <div class="d-flex">
                          {{-- <a href="{{ route('admin.departments.edit', $department) }}" class="me-2" Department="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="departments" data-type="{{__('department')}}" data-id="{{ $department->id }}" data-name="{{ $department->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>
                            --}}
                            <!-- Botón para visualizar -->
                            <a href="{{ route('admin.departments.show', $department)}}" class="btn btn-info me-2" role="button">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Botón para editar -->
                            <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-warning me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- Botón para eliminar -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="departments"  data-type="{{__('department')}}" data-id="{{ $department->id }}" data-name="{{ $department->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            @if ($departments->totalDepartments > App::make('paginationCount'))

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
                {!! $departments->links() !!}
            </div>
        </div>

        @endsection
