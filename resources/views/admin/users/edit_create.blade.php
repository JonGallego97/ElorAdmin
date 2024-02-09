@extends('admin.plantillas.nav')

@section('nav')

<div class="container">
    <div id="user_data" data-user={{$user->roles}}></div>
    <form class="mt-2" name="edit_create_platform" action="{{ Route::currentRouteName() == 'admin.users.edit' ? route('admin.users.update', $user) : route('admin.users.store', $user) }}" method="POST">
        @csrf
        @if(Route::currentRouteName() == 'admin.users.edit')
        @method('PUT')
        @endif
        <div class="form-group mb-3">
            <h1>
                @if(Route::currentRouteName() == 'admin.users.edit')
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
            <div class="col-8 form-group mb-3">
                <div class="row">
                    <div class="col md-4">
                        <label for="dni" class="form-label">{{__("DNI")}}</label>
                        <input type="text" class="form-control" id="dni" name="dni" required
                            value="{{$user->dni}}"/>
                    </div>
                    <div class="col form-group mb-3">
                        <label for="name" class="form-label">{{__("Name")}}</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            value="{{$user->name}}"/>
                    </div>
                </div>
                <div class="row">
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
            </div>
            <div id="rolesContainer" class="col-3 form-group mb-3" style="max-height: 180px; overflow-y: auto; border: 1px solid #ccc; border-radius: 5px;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>{{__("Roles")}}</h3>
                </div>
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" id="role_{{ $role->name }}" value="{{ $role->id }}"
                            @if(Route::currentRouteName() == 'admin.users.create')
                                @if((str_contains(url()->previous(),'teachers') && $role->name == 'PROFESOR') || (str_contains(url()->previous(),'students') && $role->name == 'ALUMNO'))
                                    checked
                                @endif
                            @elseif(Route::currentRouteName() == 'admin.users.edit')
                                @if($user->hasRole($role->name))
                                    checked
                                @endif
                            @endif
                            @if($role->name == 'ALUMNO')
                                onclick="handleAlumnoCheckbox(this)"
                            @endif
                            @if($role->name == 'PROFESOR')
                                onclick="handleProfesorCheckbox(this)"
                            @endif
                        >
                        <label class="form-check-label" for="role_{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="row">
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
                <div id="departmentContainer" class="col form-group mb-3">
                    <label for="department" class="form-label">{{__("Department")}}</label>
                    <select class="form-control" name="department">
                        <option value="0">{{__("Department")}}</option>
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
            </div>
            <div class="row">
                <div class="col form-group mb-3">
                    <label for="address" class="form-label">{{__("Address")}}</label>
                    <input type="text" class="form-control" id="address" name="address" required
                        value="{{$user->address}}"/>
                </div>
            </div>
        </div>
        @if(Route::currentRouteName() == 'admin.users.create')
        <hr>
        <div class="row">
            <div id="modulesContainer" class="col-6 form-group mb-3">
                <label for="modules" class="form-label">{{__("Modules")}}</label>
                <div style="max-height: 200px; overflow-y: auto;">
                    @foreach($cycles as $cycle)
                        <div class="mb-2 department-block department_{{$cycle->department_id}}">
                            <label class="fw-bold">{{$cycle->name}}</label>
                            @foreach($cycle->modules as $module)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="{{$cycle->id}}/{{$module->id}}" id="module_{{$module->id}}">
                                    <label class="form-check-label" for="module_{{$module->id}}">{{$module->name}}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="cyclesContainer" class="col-6 form-group mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>{{__("Cycles")}}</h3>
                </div>
                <div class= "col mb-3">
                    <select id="cycle" name="cycle" class="form-control">
                    @foreach ($cycles as $cycle)
                        <option value="{{ $cycle->id }}">
                        {{ $cycle['name'] }}
                        </option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>
         @endif
        

        


        <button type="submit" class="btn btn-primary" name="">
            @if(Route::currentRouteName() == 'admin.users.edit')
                {{__("Update")}}
            @else
                {{__("Create")}}
            @endif
        </button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@if(Route::currentRouteName() == 'admin.users.create')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var departmentContainer = document.getElementById('departmentContainer');
        var modulesContainer = document.getElementById('modulesContainer');
        var cyclesContainer = document.getElementById('cyclesContainer');

        var alumnoCheckbox = document.getElementById('role_ALUMNO');
        var profesorCheckbox = document.getElementById('role_PROFESOR');

        switch (true) {
            case alumnoCheckbox.checked:
                handleAlumnoCheckbox(alumnoCheckbox);
                break;
            case profesorCheckbox.checked:
                handleProfesorCheckbox(profesorCheckbox);
                break;
            default:
                modulesContainer.style.display = 'none';
                cyclesContainer.style.display = 'none';
                break;
        }

    });
    

    function handleAlumnoCheckbox(alumnoCheckbox) {
        var departmentContainer = document.getElementById('departmentContainer'); // Fix the ID
        var modulesContainer = document.getElementById('modulesContainer');
        var checkboxes = document.querySelectorAll('input[name="roles[]"]');
        var cyclesContainer = document.getElementById('cyclesContainer');

        // Disable other checkboxes and uncheck them
        checkboxes.forEach(function (checkbox) {
            if (checkbox !== alumnoCheckbox) {
                checkbox.disabled = alumnoCheckbox.checked;
                checkbox.checked = false;
            }
        });
        
        departmentContainer.style.display = alumnoCheckbox.checked ? 'none' : 'block';
        cyclesContainer.style.display = alumnoCheckbox.checked ? 'block' : 'none';

        // Clear values for both containers
        if (alumnoCheckbox.checked) {
            modulesContainer.style.display = 'none';
        } else {
            departmentContainer.value = "0";
        }
    }

    function handleProfesorCheckbox(profesorCheckbox) {
        var modulesContainer = document.getElementById('modulesContainer');
        var cyclesContainer = document.getElementById('cyclesContainer');

        modulesContainer.style.display = profesorCheckbox.checked ? 'block' : 'none';

        if (profesorCheckbox.checked) {
            modulesContainer.style.display = 'block';
            cyclesContainer.style.display = 'none';
        }

    }
    
</script>
@else
<script>

document.addEventListener('DOMContentLoaded', function () {
        // Execute code when the page is loaded
        var alumnoCheckbox = document.getElementById('role_ALUMNO');

        if (alumnoCheckbox.checked) {
            handleAlumnoCheckbox(alumnoCheckbox);
        }

    });

    function handleAlumnoCheckbox(alumnoCheckbox) {
        var checkboxes = document.querySelectorAll('input[name="roles[]"]');
        var departmentContainer = document.getElementById('departmentContainer');
        
        // Disable other checkboxes and uncheck them
        checkboxes.forEach(function (checkbox) {
            if (checkbox !== alumnoCheckbox) {
                checkbox.disabled = alumnoCheckbox.checked;
                checkbox.checked = false;
            }
        });

        departmentContainer.style.display = alumnoCheckbox.checked ? 'none' : 'block';
    }
</script>
@endif

@endsection
