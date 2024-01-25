@extends('admin.plantillas.nav')

@section('nav')

<div class="container">
    <p>Extra</p>
    <form class="mt-2" name="extra_create_platform" action="{{ route('users.store') }}" method="POST">
        @csrf
        <!-- Solo para editar si es alumno -->
        <div class="row">
            @if(!in_array('ALUMNO',$userRolesNames) == false && !in_array('ADMINISTRADOR',$userRolesNames) == false)
            <div class="col-4 form-group mb-3">
                <label for="department" class="form-label">{{__("Department")}}</label>
                <select class="form-control" name="department">
                    <option value="0">{{__("Department")}}</option>
                    @foreach ($departments as $department)
                    <option value={{$department->id}}>{{$department->name}}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            @if(in_array('ALUMNO',$userRolesNames) == true)
            <div class="col-4 form-group mb-3">
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
                    <select id="cycles" name="cycles" class="form-control">
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

@endsection
