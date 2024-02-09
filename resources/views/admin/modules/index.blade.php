@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    {{ __('Modules') }}
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.modules.create') }}" class="me-2" role="button">
                    <i class="bi bi-person-plus fs-3"></i>
                </a>

            </div>
        </div>

        <table class="table  table-striped">
            <thead>
                <tr>
                    <th scope="col">{{__('Code')}}</th>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Hours2')}}</th>
                    <th scope="col">{{__('Teachers')}}</th>
                    <th scope="col">{{__('Students')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modules as $module)
                <tr>
                    <td>{{$module->code}}</td>
                    <td>
                        <a href="{{route('admin.modules.show', $module)}}" role="button">
                            {{$module->name}}
                        </a>
                    </td>
                    <td>{{$module->hours}}</td>
                    <td>{{$module->count_teachers}}</td>
                    <td>{{$module->count_students}}</td>
                    <td>
                        <div class="d-flex">
                            {{--<a href="{{ route('admin.modules.edit', $module) }}" class="me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules" data-type="{{__('module')}}" data-id="{{ $module->id }}" data-name="{{ $module->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>
                            --}}
                            <a href="{{route('admin.modules.show', $module)}}" class="btn btn-info me-2" role="button">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Botón para editar -->
                            <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-warning me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- Botón para eliminar -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules" data-type="{{__('module')}}" data-id="{{ $module->id }}" data-name="{{ $module->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            @if ($modules->totalModules > App::make('paginationCount'))

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
                {!! $modules->links() !!}
            </div>
        </div>
        @endsection
