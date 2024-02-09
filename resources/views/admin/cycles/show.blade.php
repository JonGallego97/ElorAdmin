@extends('admin.plantillas.nav')
    @section('nav')
    <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
        <div class="col d-flex align-items-center">
            <h1 class="me-2 mb-0" style="white-space: nowrap;">{{ __('Cycle') }}{{ __('Colon') }} {{ $cycle->name }}</h1>
           {{-- <a href="{{ route('admin.cycles.edit', $cycle) }}" class="me-2" role="button">
                <i class="bi bi-pencil-square fs-2"></i>
            </a>
            <button class="me-2" type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="cycles" data-type="{{__('cycle')}}" data-id="{{ $cycle->id }}" data-name="{{ $cycle->name }}" id="openModalBtn">
                <i class="bi bi-trash3 fs-2"></i>
            </button>
            --}}

            <!-- Botón para editar -->
            <a href="{{ route('admin.cycles.edit', $cycle)}}" class="btn btn-warning me-2" role="button">
                <i class="bi bi-pencil-square"></i>
            </a>
            <!-- Botón para eliminar -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="cycles" data-type="{{__('cycle')}}" data-id="{{ $cycle->id }}" data-name="{{ $cycle->name }}" id="openModalBtn">
                <i class="bi bi-trash3"></i>
            </button>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.cycles.index') }}" class="me-2" role="button">
                <i class="bi bi-arrow-90deg-left fs-3"></i>
            </a>

        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col">
            <h4>{{ __('Department') }}{{ __('Colon') }} {{$cycle->department->name}}</h4>
        </div>
        <div class="col text-center">
            <h4>{{ __('Number of') }} {{ __('Students') }}{{ __('Colon') }} {{ $cycle->count_students }} </h4>
        </div>
        <div class="col text-end">
            <h4>{{ __('Number of modules') }}{{ __('Colon') }} {{ $cycle->modules->total() }} </h4>
        </div>
    </div>

    <div class="mt-4">
        <h3>{{__('Modules')}}</h3>
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
                @foreach ($cycle->modules as $module)
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
                                <a href="{{ route('admin.modules.show', $module)}}" class="btn btn-info me-2" role="button">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <!-- Botón para editar -->
                                <a href="{{ route('admin.modules.edit', $module)  }}" class="btn btn-warning me-2" role="button">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <!-- Botón para eliminar -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="cycles/destroyCycleModule" data-type="" data-id="{{ $cycle->id }}/{{ $module->id}}" data-name="{{ $module->name }} {{__('from')}} {{ $cycle->name }}" id="openModalBtn">
                                    <i class="bi bi-trash3"></i>
                                </button>


                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            @if ($cycle->modules->total() > App::make('paginationCount'))
            <div class="form-inline col">
                <form class="form-inline" method="GET" id="perPageForm">
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
                {!! $cycle->modules->links() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteUserModalLabel">{{__('confirm_deletion')}}</h1>
                </div>
                <div class="modal-body">
                    {{__('are_you_sure_delete')}} {{$module->name}} {{__('Question')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('cancel')}}</button>
                    <form action="{{ route('modules.destroy', $module) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary" >{{__('delete')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
