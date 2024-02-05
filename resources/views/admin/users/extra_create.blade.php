@extends('admin.plantillas.nav')

@section('nav')

<div class="container">
    <form class="mt-2" name="extra_create_platform" action="{{ route('admin.users.store') }}" method="POST">
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

            @if(in_array('PROFESOR',$userRolesNames) == true)
            <div id="modules_div" class="col-6 form-group mb-3">
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
            @endif


            <!-- <div id="modules_div" class="col-6 form-group mb-3">
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
            </div> -->
            @endif
            
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
                    <option value="1">{{__("Yes")}}</option>
                    <option value="0">{{__("No")}}</option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    /* function handleDropdownChange() {
        var selectedDepartmentId = document.getElementById("department").value;
        var modulesSelect = document.getElementById("modules");
        var modulesDiv = document.getElementById("modules_div");

        // Define un array que contiene los departmentIds permitidos
        var noTeacherDepartmentIds = [1,2,3,4];

        var optgroups = modulesSelect.getElementsByTagName("optgroup");
            for (var i = 0; i < optgroups.length; i++) {
                // Obtiene el department_id del optgroup
                var departmentId = optgroups[i].getAttribute("data-department-id");

                // Muestra u oculta el optgroup según el department_id y la existencia en el array permitido
                if (selectedDepartmentId === "0" || departmentId === selectedDepartmentId) {
                    optgroups[i].style.display = "block";
                } else {
                    optgroups[i].style.display = "none";
                }
            }
        if (noTeacherDepartmentIds.includes(selectedDepartmentId)) {
            modulesDiv.style.visibility = "hidden";
        } else {
            modulesDiv.style.visibility = "visible";
        }
    } */
    function handleDropdownChange() {
        var selectedDepartmentId = $("#department").val();
        
        // Oculta todos los bloques de departamento
        $(".department-block").hide();
        
        // Muestra solo el bloque del departamento seleccionado
        $(".department_" + selectedDepartmentId).show();

        if (selectedDepartmentId == 0) {
            $(".department-block").show();
        }
    }

</script>
@endsection