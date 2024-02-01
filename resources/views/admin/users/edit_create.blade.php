@extends('admin.plantillas.nav')

@section('nav')

<div class="container">
    <div id="user_data" data-user={{$user->roles}}></div>
    <form class="mt-2" name="edit_create_platform" action="{{ Route::currentRouteName() == 'users.edit' ? route('users.update', $user) : route('users.extra_create', $user) }}" method="POST">
        @csrf
        @if(Route::currentRouteName() == 'users.edit')
        @method('PUT')
        @endif
        <div class="form-group mb-3">
            <h1>
                @if(Route::currentRouteName() == 'users.edit')
                {{__("Edit")}}
                @else
                {{__("Create")}}
                @endif
                @switch(true)
                    @case(str_contains(url()->previous(),'users'))
                        {{__('User')}}
                        @break
                    @case(str_contains(url()->previous(),'teachers'))
                        {{__('Teachers')}}
                        @break
                    @case(str_contains(url()->previous(),'students'))
                        {{__('Students')}}
                        @break
                @endswitch
            </h1>
        </div>
        <div class="row">
            <div class="col form-group mb-3">
                <label for="name" class="form-label">{{__("Name")}}</label>
                <input type="text" class="form-control" id="name" name="name" required
                    value="{{$user->name}}"/>
            </div>
            <div class=" col form-group mb-3">
                <label for="surname1" class="form-label">{{__("Surname1")}}</label>
                <input type="text" class="form-control" id="surname1" name="surname1" required
                    value="{{$user->surname1}}"/>
            </div>
            <div class="col form-group mb-3">
                <label for="surname2" class="form-label">{{__("Surname2")}}</label>
                <input type="text" class="form-control" id="surname2" name="surname2" required
                    value="{{$user->surname2}}"/>
            </div>
        </div>
        <div class="row">
            <div class="col form-group mb-3">
                <label for="dni" class="form-label">{{__("DNI")}}</label>
                <input type="text" class="form-control" id="dni" name="dni" required
                    value="{{$user->dni}}"/>
            </div>
            <div class="col form-group mb-3">
                <label for="phone_number1" class="form-label">{{__("PhoneNumber1")}}</label>
                <input type="text" class="form-control" id="phone_number1" name="phone_number1" required
                    value="{{$user->phone_number1}}"/>
            </div>
            <div class="col form-group mb-3">
                <label for="phone_number2" class="form-label">{{__("PhoneNumber2")}}</label>
                <input type="text" class="form-control" id="phone_number2" name="phone_number2" required
                    value="{{$user->phone_number2}}"/>
            </div>
        </div>
        <div class="row">
            <div class="col form-group mb-3">
                <label for="address" class="form-label">{{__("Address")}}</label>
                <input type="text" class="form-control" id="address" name="address" required
                    value="{{$user->address}}"/>
            </div>
            @if(!in_array('ALUMNO',$user->roles->pluck('name')->toArray()) && Route::currentRouteName() == 'users.edit')
                <div class="col form-group mb-3">
                    <label for="department" class="form-label">{{__("Department")}}</label>
                    <select class="form-control" name="department">
                        @foreach ($departments as $department)
                        <option value={{$department->id}}
                        @if($department->id == $user->department_id)
                            selected 
                        @endif    
                        >{{$department->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
            @elseif (Route::currentRouteName() == 'users.edit')
                <div class="col form-group mb-3">
                    <label for="dual" class="form-label">{{__("Dual")}}</label>
                    <select class="form-control" name="dual">
                        <option value="1" <?= ($user->dual == 1) ? 'selected' : '' ?>>{{__("Yes")}}</option>
                        <option value="0" <?= ($user->dual == 0) ? 'selected' : '' ?>>{{__("No")}}</option>
                    </select>
                </div>
                <div class="col form-group mb-3">
                    <label for="year" class="form-label">{{__("Year")}}</label>
                    <select class="form-control" name="year">
                        <option value="1" <?= ($user->year == 1) ? 'selected' : '' ?>>{{__("FirstYear")}}</option>
                        <option value="2" <?= ($user->year == 0) ? 'selected' : '' ?>>{{__("SecondYear")}}</option>
                    </select>
                </div>
            @endif
        </div>
        <hr>

        <hr class="my-4">
        @if(Route::currentRouteName() == 'users.create')
            <div class="row">
                <div id="rolesContainer" class="col-4 form-group mb-3" style="max-height: 200px; overflow-y: auto;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>{{__("Roles")}}</h3>
                    </div>
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}"
                                @if((str_contains(url()->previous(),'teachers') && $role->name == 'PROFESOR') || (str_contains(url()->previous(),'students') && $role->name == 'ALUMNO'))
                                    checked
                                @endif
                            >
                            <label class="form-check-label" for="role_{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif


        <!-- Si viene del edit -->
        @if(Route::currentRouteName() == 'users.edit')
        <div class="form-group mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__("Roles")}}</h3>
                <input type="hidden" id="selectedRolesInput" name="selectedRoles" value="">
                <input type="hidden" id="hiddenRoleIds" value="{{ implode(',', $user->roles->pluck('id')->toArray()) }}">
                <button type="button" style="border: none; background: none;" id="roleEdit" data-bs-toggle="modal" data-bs-target="#rolesModal" data-role-ids="sad">
                    <i class="bi bi-pencil fs-3"></i>
                </button>
            </div>
            <select id="roles" name="roles[]" class="form-control" multiple>
                @foreach ($user->roles as $role)
                    <option value="{{ $role->id }}">
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <hr class="my-4">
        <div class="form-group mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__("Cycles")}}</h3>
                <input type="hidden" id="selectedCyclesInput" name="selectedCycles" value="">
                <input type="hidden" id="hiddenCycleIds" value="{{ implode(',', $user->cycles->pluck('id')->toArray()) }}">
                <button type="button" style="border: none; background: none;" id="cycleEdit" data-bs-toggle="modal" data-bs-target="#cyclesModal">
                    <i class="bi bi-pencil fs-3"></i>
                </button>
            </div>
            <div>
                @foreach ($user['cycles'] as $cycle)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>{{ $cycle['name'] }}</h4>
                                <a class="text-decoration-none">
                                    <i class="bi bi-pencil fs-4"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>{{__('Modules')}}</h5>
                            <ul>
                                @foreach ($cycle['modules'] as $module)
                                    <li>{{ $module['code'] }} - {{ $module['name'] }}  ({{ $module['hours'] }} {{__('Hours')}})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        


        <!-- Modals -->

        <!-- Si viene del edit -->
        @if(Route::currentRouteName() == 'users.edit')
        <div class="modal fade" id="rolesModal" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rolesModalLabel">{{__('Roles')}}</h1>
                    </div>
                    <div class="modal-body">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}">
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('cancel')}}</button>
                        <form id="editRolesForm" action="{{ route('users.editRoles', ['user' => $user]) }}" method="POST" style="display: none;">
                        @method('PUT')
                        @csrf
                        </form>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="editRolesBtn">{{__('Edit')}}</button>
                        <form id="editRolesForm" action="{{ route('users.editRoles', ['user' => $user]) }}" method="POST">
                        @method('PUT')
                        @csrf
                            <input type="hidden" name="selectedRoles" id="selectedRolesInput" value="">
                            <button type="submit" id="editListDeRoles" class="btn btn-primary" style="display: none;">{{__('Edit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> 

        <div class="modal fade" id="cyclesModal" tabindex="-1" aria-labelledby="cyclesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cyclesModalLabel">{{__('Cycles')}}</h1>
                    </div>
                    <div class="modal-body">
                        @foreach ($cycles_modules as $ciclo)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ciclos[]" id="cycle_{{ $ciclo->id }}" value="{{ $ciclo->id }}">
                                <label class="form-check-label" for="cycle_{{ $ciclo->id }}">
                                    {{ $ciclo->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('cancel')}}</button>
                        <form id="editCyclesForm" action="{{ route('users.editCycles', $user) }}" method="GET" style="display: none;">
                        </form>
                        <button type="button" class="btn btn-primary" id="editCyclesBtn">{{__('Edit')}}</button>

                        <form id="editCyclesFormSubmit" action="{{ route('users.editCycles', $user) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="selectedCycles" id="selectedCyclesInput" value="">
                            <button type="submit" id="editListDeCycles" class="btn btn-primary" style="display: none;">{{__('Edit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       {{-- <div class="modal fade" id="modulesModal" tabindex="-1" aria-labelledby="modulesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modulesModalLabel">{{__('Modules')}}</h1>
                    </div>
                    <div class="modal-body">
                        @foreach ($cycles_modules->modules as $module)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="modules[]" id="module_{{ $module->id }}" value="{{ $module->id }}">
                                <label class="form-check-label" for="module_{{ $module->id }}">
                                    {{ $module->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('cancel')}}</button>
                        <form id="editModulesForm" action="{{ route('users.editModules', $user) }}" method="GET" style="display: none;">
                        </form>
                        <button type="button" class="btn btn-primary" id="editModulesBtn">{{__('Edit')}}</button>

                        <form id="editModulesFormSubmit" action="{{ route('users.editModules', $user) }}" method="GET">
                            <input type="hidden" name="selectedModules" id="selectedModulesInput" value="">
                            <button type="submit" id="editListDeModules" class="btn btn-primary" style="display: none;">{{__('Edit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        @endif


        <button type="submit" class="btn btn-primary" name="">
            @if(Route::currentRouteName() == 'users.edit')
                {{__("Update")}}
            @else
                {{__("Create")}}
            @endif
        </button>
    </form>
</div>



@endsection
@section('scripts')
    <script src="{{ asset('js/admin/users/teachers/index.js') }}"></script>

@endsection
