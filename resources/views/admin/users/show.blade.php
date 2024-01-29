@extends('admin.plantillas.nav')

@section('nav')
    <div class="container">
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    @switch(true)
                        @case(str_contains(url()->previous(),'users'))
                            <h1>{{__('User')}}</h1>
                            @break
                        @case(str_contains(url()->previous(),'teachers'))
                            <h1>{{__('Teachers')}}</h1>
                            @break
                        @case(str_contains(url()->previous(),'students'))
                        <h1>{{__('Students')}}</h1>
                            @break
                    @endswitch
                    
                </h1>
            </div>
            <div class="col text-end">
                @switch(true)
                    @case(str_contains(url()->previous(),'users'))
                        <a href="{{ route('users.index') }}" class="me-2" role="button">
                            <i class="bi bi-arrow-90deg-left fs-3"></i>
                        </a>
                        @break
                    @case(str_contains(url()->previous(),'teachers'))
                        <a href="{{ route('teachers.index') }}" class="me-2" role="button">
                            <i class="bi bi-arrow-90deg-left fs-3"></i>
                        </a>
                        @break
                    @case(str_contains(url()->previous(),'students'))
                        <a href="{{ route('students.index') }}" class="me-2" role="button">
                            <i class="bi bi-arrow-90deg-left fs-3"></i>
                        </a>
                        @break
                @endswitch
                

            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <h2>{{ $user['name'] }} {{ $user['surname1'] }} {{ $user['surname2'] }}</h2>
                    </div>
                    @if(!in_array('ALUMNO',$user->roles->pluck('name')->toArray()) && !in_array('ADMINISTRADOR',$user->roles->pluck('name')->toArray()))
                    <div class="col-md-4">
                        <h2>{{ $user['department']['name'] }}</h2>
                    </div>
                    @endif
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('users.edit', $user) }}" class="me-2" role="button">
                            <i class="bi bi-pencil-square" style="font-size: 24px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{__('DNI')}}{{__('Colon')}}</strong> {{ $user['dni'] }}</p>
                        <p><strong>{{__('Mail')}}{{__('Colon')}}</strong> {{ $user['email'] }}</p>
                        <p><strong>{{__('Address')}}{{__('Colon')}}</strong> {{ $user['address'] }}</p>
                        <p><strong>{{__('PhoneNumber1')}}{{__('Colon')}}</strong> {{ $user['phone_number1'] }}</p>
                        <p><strong>{{__('PhoneNumber2')}}{{__('Colon')}}</strong> {{ $user['phone_number2'] }}</p>
                        @if(in_array('ALUMNO',$user->roles->pluck('name')->toArray()))
                        <p><strong>{{__('Year')}}{{__('Colon')}}</strong> {{ $user['year'] }}</p>
                        <p><strong>{{__('Dual')}}{{__('Colon')}}</strong> {{ $user['dual'] ? __('Yes') : __('No') }}</p>
                        @elseif(!in_array('ADMINISTRADOR',$user->roles->pluck('name')->toArray()))
                        <p><strong>{{__('Department')}}{{__('Colon')}}</strong> {{ $user['department']['name'] }}</p>
                        @endif
                        <!-- Otros detalles del usuario -->
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>{{__("Roles")}}</h3>
                        </div>
                        <select id="roles" name="roles[]" class="form-control" multiple readonly>
                            @foreach ($user->roles as $role)
                                <option disabled value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <!-- photo -->
                        <img src="{{ asset($imagePath) }}" alt="Imagen" />
                    </div>
                </div>
                <hr>
                <!-- Si tiene el rol de Profesor -->
                @if(in_array('PROFESOR',$user->roles->pluck('name')->toArray()))
                    <form class="row form" name="add_module" action="{{ route('users.addModule',$user) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="col-5 mb-3">
                            <h3>{{__('Cycles')}}</h3>
                        </div>
                        <div class="col-7 d-flex justify-content-end mb-3">
                            <select class="form-control" id="newModule" name="newModule">
                                <option value="null">{{__("Modules")}}</option>
                                @foreach($allCyclesWithModules as $cycle)
                                <optgroup label='-- {{$cycle->name}} --' data-department-id="{{$cycle->department_id}}">
                                    @foreach($cycle->modules as $module)
                                        <option value="{{$cycle->id}}/{{$module->id}}">{{$module->name}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            <button type="submit" class="col-2 ml-3 btn btn-primary" name="">{{__("addCycle")}}</button>
                        </div>
                    </form>
                    
                    @foreach ($cyclesWithModules as $cycle)
                        <div class="card mb-3">
                            <div class="card-header">
                                <a href="{{route('cycles.show', $cycle['id'])}}" role="button">
                                    <h4>{{ $cycle['name'] }}</h4>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5>{{__('Modules')}}</h5>
                                <ul>
                                    @foreach ($cycle['modules'] as $module)
                                        <li>{{ $module['code'] }} - <a href="{{ route('modules.show', $module['id']) }}" role="button">{{ $module['name'] }}</a> ({{ $module['hours'] }} {{__('Hours')}})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Si tiene el rol de Alumno -->
                @if(in_array('ALUMNO',$user->roles->pluck('name')->toArray()))
                <div class="row">
                    <div class="col form-group mb-3">
                        <h3>{{__('Cycles')}}</h3>
                    </div>
                    <form class="mt-2" name="add_cycle" action="{{ route('users.addCycle',$user) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="col form-group mb-3">
                            <select id="newCycle" name="newCycle">
                                <option value="null">{{__('Cycles')}}</optgroup>
                                @foreach($departmentsWithCycles as $department)
                                    <optgroup label="{{$department->name}}">
                                    @foreach($department->cycles as $cycle)
                                        <option value="{{$cycle->id}}">{{$cycle->name}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 form-group mb-3">
                        <button type="submit" class="btn btn-primary" name="">{{__("addCycle")}}</button>
                        </div>
                    </form>
                </div>
                    @foreach ($user['cycles'] as $cycle)
                        <div class="card mb-3">
                            <div class="card-header">
                                <a href="{{route('cycles.show', $cycle)}}" role="button">
                                    <h4>{{ $cycle['name'] }}</h4>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5>{{__('Modules')}}</h5>
                                <ul>
                                    @foreach ($cycle['modules'] as $module)
                                        <li>{{ $module['code'] }} - <a href="{{ route('modules.show', $module) }}" role="button">{{ $module['name'] }}</a> ({{ $module['hours'] }} {{__('Hours')}})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
