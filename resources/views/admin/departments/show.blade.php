@extends('admin.plantillas.nav')
@section('nav')
<div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
    <div class="col d-flex align-items-center">
        <h1 class="me-2 mb-0" style="white-space: nowrap;">{{ __('Department') }}{{ __('Colon') }} {{ $department->name }}</h1>
        {{--<a href="{{ route('admin.departments.edit', $department) }}" class="me-2" role="button">
            <i class="bi bi-pencil-square fs-2"></i>
        </a>
        <button class="me-2" type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="departments" data-type="{{__('department')}}" data-id="{{ $department->id }}" data-name="{{ $department->name }}" id="openModalBtn">
            <i class="bi bi-trash3 fs-2"></i>
        </button>
        --}}
        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-warning me-2" role="button">
            <i class="bi bi-pencil-square"></i>
        </a>
        <!-- Botón para eliminar -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="departments"  data-type="{{__('department')}}" data-id="{{ $department->id }}" data-name="{{ $department->name }}" id="openModalBtn">
            <i class="bi bi-trash3"></i>
        </button>
    </div>
    <div class="col text-end">
        <a href="{{ route('admin.departments.index') }}" class="me-2" role="button">
            <i class="bi bi-arrow-90deg-left fs-3"></i>
        </a>
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <h4> {{ __('Name') }}{{ __('Colon') }} {{ $department->name }}</h4>
    </div>
    <div class="col text-end">
        <h4>{{ __('Number of persons') }}{{ __('Colon') }} {{ $department->users->count() }} </h4>
    </div>
</div>

<div class="mt-4">
    <h3>{{__('Users')}}</h3>
    <table class="table  table-striped">
        <thead>
            <tr>
                <th scope="col">{{__('Full name')}}</th>
                <th scope="col">{{__('Mail')}}</th>
                <th scope="col">{{__('DNI')}}</th>
                <th scope="col">{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($department->users as $user)
                <tr>
                    <td>
                        <a href="{{route('admin.users.show', $user)}}" role="button">
                            {{$user->name}} {{ $user->surname1 }} {{ $user->surname2 }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->dni }}</td>
                    <td>
                        <div class="d-flex">
                            {{--<a href="{{ route('admin.users.edit', $user) }}" class="me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="departments/destroyDepartmentUser" data-type="" data-id="{{ $department->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $department->name }}" id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button>
                             --}}
                            <a href="{{ route('admin.users.show', $user)}}" class="btn btn-info me-2" role="button">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Botón para editar -->
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2" role="button">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- Botón para eliminar -->
                            <!-- Se comenta por que no se puede tener un usuario sin departamento -->
<!--                             <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"  data-action="departments/destroyDepartmentUser" data-type="" data-id="{{ $department->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $department->name }}"id="openModalBtn">
                                <i class="bi bi-trash3"></i>
                            </button> -->
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row">
        @if ($department->users->total() > App::make('paginationCount'))
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
            {!! $department->users->links() !!}
        </div>
    </div>
</div>
@endsection
