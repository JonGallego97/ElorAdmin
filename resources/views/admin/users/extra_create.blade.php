@extends('admin.plantillas.nav')

@section('nav')

<div class="container">
    <form class="mt-2" name="extra_create_platform" action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Solo para editar si no es alumno ni admin -->
            @if(in_array('ALUMNO',$userRolesNames) == false && in_array('ADMINISTRADOR',$userRolesNames) == false)
            <div class="col-4 form-group mb-3">
                <label for="department" class="form-label">{{__("Department")}}</label>
                <select class="form-control" id="department" name="department" onchange="handleDropdownChange()">
                    <option value="0">{{__("Department")}}</option>
                    @foreach ($departments as $department)
                    <option value={{$department->id}}>{{$department->name}}</option>
                    @endforeach
                </select>
            </div>

            <div id="modules_div" class="col-6 form-group mb-3">
                <label for="modules" class="form-label">{{__("Modules")}}</label>
                <select class="form-control" id="modules" name="modules[]" multiple="multiple">
                    @foreach($cycles as $cycle)
                    <optgroup label='-- {{$cycle->name}} --' data-department-id="{{$cycle->department_id}}">
                        @foreach($cycle->modules as $module)
                            <option value="{{$cycle->id}}/{{$module->id}}">{{$module->name}}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
            
            <!-- Solo si es alumno -->
            @if(in_array('ALUMNO',$userRolesNames) == true)
            <div class="col-4 form-group mb-5">
                <label for="year" class="form-label">{{__("Year")}}</label>
                <select class="form-control" name="year">
                    <option value="1">{{__("FirstYear")}}</option>
                    <option value="2">{{__("SecondYear")}}</option>
                </select>
                <label for="dual" class="form-label">{{__("Dual")}}</label>
                <select class="form-control" name="dual">
                    <option value="true">{{__("Yes")}}</option>
                    <option value="false">{{__("No")}}</option>
                </select>
            </div>
            <div class="col-6 form-group mb-3">
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
            @endif
        </div>
        <input type="hidden" name="user_id" value={{$user_id}}></input>


        <button type="submit" class="btn btn-primary" name="">{{__("Create")}}</button>
    </form>
</div>
<script>
    function handleDropdownChange() {
        var selectedDepartmentId = document.getElementById("department").value;
        var modulesSelect = document.getElementById("modules");

        // Si se selecciona la opción 0, mostrar todas las opciones
        if (selectedDepartmentId === "0") {
            var optgroups = modulesSelect.getElementsByTagName("optgroup");
            for (var i = 0; i < optgroups.length; i++) {
                optgroups[i].style.display = "block";
            }
        } else {
            // Oculta todos los grupos de opciones
            var optgroups = modulesSelect.getElementsByTagName("optgroup");
            for (var i = 0; i < optgroups.length; i++) {
                optgroups[i].style.display = "none";
            }

            // Muestra solo el grupo de opciones correspondiente al departamento seleccionado
            var selectedOptgroup = modulesSelect.querySelector("optgroup[data-department-id='" + selectedDepartmentId + "']");
            if (selectedOptgroup) {
                selectedOptgroup.style.display = "block";
            }
        }
    }
</script>
@endsection