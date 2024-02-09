@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col d-flex align-items-center">
                <h1 class="me-2 mb-0" style="white-space: nowrap;">{{ __('Module') }}{{ __('Colon') }} {{ $module->name }}</h1>
                {{--<a href="{{ route('admin.modules.edit', $module) }}" class="me-2" role="button">
                    <i class="bi bi-pencil-square fs-2"></i>
                </a>
                <button class="me-2" type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules" data-type="{{__('module')}}" data-id="{{ $module->id }}" data-name="{{ $module->name }}" id="openModalBtn">
                    <i class="bi bi-trash3 fs-2"></i>
                </button>
                --}}
                <!-- Botón para editar -->
                <a href="{{ route('admin.modules.edit', $module)}}" class="btn btn-warning me-2" role="button">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <!-- Botón para eliminar -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules" data-type="{{__('module')}}" data-id="{{ $module->id }}" data-name="{{ $module->name }}" id="openModalBtn">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.modules.index') }}" class="me-2" role="button">
                    <i class="bi bi-arrow-90deg-left fs-2" ></i>
                </a>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
               <h4> {{ __('Name') }}{{ __('Colon') }} {{ $module->name }}</h4>
            </div>
            <div class="col text-center">
                <h4>{{ __('Number of') }} {{ __('Teachers') }}{{ __('Colon') }} {{ $module->teachers->total() }} </h4>
            </div>
            <div class="col text-end">
                <h4>{{ __('Number of') }} {{ __('Students') }}{{ __('Colon') }} {{ $module->students->total() }} </h4>
            </div>
        </div>

        <div class="mt-4">
            <h3>{{__('Teachers')}}</h3>
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
                    @foreach ($module->teachers as $user)
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
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules/destroyModuleUser" data-type="" data-id="{{ $module->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $module->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    --}}
                                    <a href="{{route('admin.users.show', $user)}}" class="btn btn-info me-2" role="button">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <!-- Botón para editar -->
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Botón para eliminar -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules/destroyModuleUser" data-type="" data-id="{{ $module->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $module->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($module->teachers->total() > 10)
                <div class="form-inline col">
                    <form class="form-inline" method="GET" id="perPageForm">
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
                    {!! $module->teachers->links() !!}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h3>{{__('Students')}}</h3>
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
                    @foreach ($module->students as $user)
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
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    --}}
                                    <a href="{{route('admin.users.show', $user)}}" class="btn btn-info me-2" role="button">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <!-- Botón para editar -->
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Botón para eliminar -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules/destroyModuleUser" data-type="" data-id="{{ $module->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $module->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($module->students->total() > 10)
                <div class="form-inline col">
                    <form class="form-inline" method="GET" id="perPageForm">
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
                    {!! $module->students->links() !!}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h3>{{__('Cycles')}}</h3>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Departament')}}</th>
                        <th scope="col">{{__('Alumnos')}}</th>
                        <th scope="col">{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cyclesArray as $cycle)
                        <tr>
                            <td>
                                <a href="{{route('admin.cycles.show', $cycle['id'])}}" role="button">
                                    {{$cycle['name']}}
                                </a>
                            </td>
                            <td>{{ $cycle['department'][0] }}</td>
                            <td>{{ $cycle['students'] }}</td>
                            <td>
                                <div class="d-flex">
                                    {{--<a href="{{ route('admin.cycles.edit', $cycle['id']) }}" class="me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteCycleModal" data-cycle-id="{{ $cycle['id'] }}" data-cycle-name="{{ $cycle['name'] }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    --}}
                                    <a href="{{route('admin.cycles.show', $cycle['id'])}}" class="btn btn-info me-2" role="button">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <!-- Botón para editar -->
                                    <a href="{{ route('admin.cycles.edit', $cycle['id']) }}" class="btn btn-warning me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Botón para eliminar -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-cycle-id="{{ $cycle['id'] }}" data-cycle-name="{{ $cycle['name'] }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>


                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($module->students->total() > App::make('paginationCount'))
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
                    {!! $module->students->links() !!}
                </div>
            </div>
        </div>

@endsection
