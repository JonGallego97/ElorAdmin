@extends('admin.plantillas.nav')

@section('nav')
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
                        <a href="{{ route('admin.users.index') }}" class="me-2" role="button">
                            <i class="bi bi-arrow-90deg-left fs-3"></i>
                        </a>
                        @break
                    @case(str_contains(url()->previous(),'teachers'))
                        <a href="{{ route('admin.teachers.index') }}" class="me-2" role="button">
                            <i class="bi bi-arrow-90deg-left fs-3"></i>
                        </a>
                        @break
                    @case(str_contains(url()->previous(),'students'))
                        <a href="{{ route('admin.students.index') }}" class="me-2" role="button">
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
                    @if(!$user->hasRole("ALUMNO") && !$user->hasRole("ADMINISTRADOR"))
                    <div class="col-md-4">
                        <h2>{{ $user['department']['name'] }}</h2>
                    </div>
                    @endif
                    <div class="col d-flex justify-content-end">
                        {{--<a href="{{ route('admin.users.edit', $user) }}" class="me-2" role="button">
                            <i class="bi bi-pencil-square fs-3"></i>
                        </a>
                        <button class="me-2" type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users" data-type="{{__('user')}}" data-id="{{ $user->id }}" data-name="{{ $user->name }}" id="openModalBtn">
                            <i class="bi bi-trash3 fs-3"></i>
                        </button>--}}

                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2" role="button">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <!-- Botón para eliminar -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users" data-type="{{__('user')}}" data-id="{{ $user->id }}" data-name="{{ $user->name }}" id="openModalBtn">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <!-- photos -->
                        <img src="{{ asset($imagePath) }}" alt="Imagen" style="max-width: 100%; max-height: 200px;" />
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{__('DNI')}}{{__('Colon')}}</strong> {{ $user['dni'] }}</p>
                        <p><strong>{{__('Mail')}}{{__('Colon')}}</strong> {{ $user['email'] }}</p>
                        <p><strong>{{__('Address')}}{{__('Colon')}}</strong> {{ $user['address'] }}</p>
                        <p><strong>{{__('PhoneNumber1')}}{{__('Colon')}}</strong> {{ $user['phone_number1'] }}</p>
                        <p><strong>{{__('PhoneNumber2')}}{{__('Colon')}}</strong> {{ $user['phone_number2'] }}</p>
                        @if(!$user->hasRole('ALUMNO'))
                        <p><strong>{{__('Department')}}{{__('Colon')}}</strong> {{ $user['department']['name'] }}</p>
                        @endif
                        <!-- Otros detalles del usuario -->
                    </div>
                    <!-- <div class="col-md-3">
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
                    </div> -->
                    <div class="col-md-3">
                        <h3>{{__("Roles")}}</h3>
                        @foreach ($user->roles as $role)
                            - {{$role->name}}
                        @endforeach
                    </div>
                </div>
                <hr>
                <!-- Si tiene el rol de Profesor -->
                @if($user->hasRole("PROFESOR"))
                    <form class="row form mb-3" name="add_module" action="{{ route('admin.users.addModule',$user) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="col-5 mb-3">
                            <h3>{{__('Cycles')}}</h3>
                        </div>
                        <div class="col-7 d-flex justify-content-end mb-3">
                            <select class="form-control" id="newModule" name="newModule">
                                <option value="null">{{__("Modules")}}</option>
                                @foreach($allCyclesWithModules as $cycle)
                                @if(!$cycle['modules']->isEmpty())
                                <optgroup label='-- {{$cycle['name']}} --' data-department-id="{{$cycle['department_id']}}">
                                @endif
                                    @foreach($cycle['modules'] as $module)
                                        <option value="{{$cycle['id']}}/{{$module['id']}}">{{$module['name']}}</option>
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
                                <div class="row">
                                <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('admin.cycles.show', $cycle['id']) }}" role="button">
                                            <h4>{{ $cycle['name'] }}</h4>
                                        </a>
                                        <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users/destroyUserCycle" data-type="" data-id="{{ $cycle['id'] }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $cycle['name'] }}" id="openModalBtn">
                                            <i class="bi bi-trash3 fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5>{{__('Modules')}}</h5>
                                <ul>
                                    @foreach ($cycle['modules'] as $module)
                                        <div class="d-flex align-items-center">
                                            <li>{{ $module['code'] }} - <a href="{{ route('admin.modules.show', $module['id']) }}" role="button">{{ $module['name'] }}</a> ({{ $module['hours'] }} {{__('Hours')}})</li>
                                            <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users/destroyUserModule" data-type="" data-id="{{ $module['id'] }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $module['name'] }}" id="openModalBtn">
                                                <i class="bi bi-trash3 fs-6"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Si tiene el rol de Alumno -->
                @if(in_array('ALUMNO',$user->roles->pluck('name')->toArray()))
                <form class="row form" name="add_cycle" action="{{ route('admin.users.addCycle',$user) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="col-3">
                        <h3>{{__('Cycles')}}</h3>
                    </div>
                    <div class="col-9 d-flex justify-content-end align-items-center">
                        <div style="margin-bottom: 5px;">
                            <select class="form-control mb-2" id="newCycle" name="newCycle" style="height: 38px;"> <!-- Añadido style="height: 38px;" -->
                                <option value="null">{{__('Cycles')}}</option>
                                @foreach($departmentsWithCycles as $department)
                                    <optgroup label="{{$department->name}}">
                                        @foreach($department->cycles as $cycle)
                                            <option value="{{$cycle->id}}">{{$cycle->name}}</option>
                                        @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <select class="form-control mb-2" id="year" name="year" style="height: 38px;"> <!-- Añadido style="height: 38px;" -->
                                <option value="null">{{__('Year')}}</option>
                                <option value="1">{{__('FirstYear')}}</option>
                                <option value="2">{{__('SecondYear')}}</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <select class="form-control mb-2" id="is_dual" name="is_dual" disabled="true" style="height: 38px;"> <!-- Añadido style="height: 38px;" -->
                                <option value="null">{{__('Dual')}}</option>
                                <option value="1">{{__('Yes')}}</option>
                                <option value="0">{{__('No')}}</option>
                            </select>
                        </div>
                        <div style="margin-left: 10px;">
                            <button type="submit" class="btn btn-primary" style="height: 38px;">{{__("addCycle")}}</button> <!-- Añadido style="height: 38px;" -->
                        </div>
                    </div>
                </form>


                    @foreach ($userData as $cycle)
                        <div class="card mb-3">
                            <div class="card-header align-items-center">
                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('admin.cycles.show', $cycle['id']) }}" role="button">
                                            <h4>{{ $cycle['name'] }}</h4>
                                        </a>
                                        {{--<button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users/destroyUserCycle" data-type="" data-id="{{ $cycle['id'] }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $cycle['name'] }}" id="openModalBtn">
                                            <i class="bi bi-trash3 fs-5"></i>
                                        </button>--}}
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users/destroyUserCycle" data-type="" data-id="{{ $cycle['id'] }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $cycle['name'] }}" id="openModalBtn">
                                            <i class="bi bi-trash3"></i>
                                        </button>


                                    </div>
                                    <div class="row">
                                        <div class="ml-3 col-1">
                                            <b>{{__('Year')}}:</b> {{ $cycle['year'] == 1 ? __('FirstYear') : ($cycle['year'] == 2 ? __('SecondYear') : '') }}
                                        </div>
                                        @if ($cycle['year'] == 2)
                                        <div class="col-1">
                                            <b>{{_('Dual')}}:</b> {{ $cycle['is_dual'] == 1 ? __('Yes') : ($cycle['is_dual'] == 0 ? __('no') : '') }}
                                        </div>
                                        @endif
                                        <div class="col-2">
                                            <b>{{__('enrollYear')}}:</b> {{$cycle['enrollYear']}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <h5>{{__('Modules')}}</h5>
                                <ul>
                                    @foreach ($cycle['modules'] as $module)
                                    <div class="d-flex align-items-center">
                                        <li>{{ $module['code'] }} - <a href="{{ route('admin.modules.show', $module['id']) }}" role="button">{{ $module['name'] }}</a> ({{ $module['hours'] }} {{__('Hours')}})</li>
                                        <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users/destroyUserModule" data-type="" data-id="{{ $module['id'] }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $module['name'] }}" id="openModalBtn">
                                            <i class="bi bi-trash3 fs-6"></i>
                                        </button>
                                       {{--
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="users/destroyUserModule" data-type="" data-id="{{ $module['id'] }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $module['name'] }}"  id="openModalBtn">
                                            <i class="bi bi-trash3 bi-sm"></i>
                                        </button>
                                        --}}

                                    </div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <script>
            const yearSelect = document.getElementById("year");
            const dualSelect = document.getElementById("is_dual");

            const dualSelectnullOption = dualSelect.querySelector('option[value="null"]');

            // Agrega un evento change al elemento select de Year
            yearSelect.addEventListener("change", function() {
                if (yearSelect.value !== "2" ) {
                    // Si Year es 1, deshabilita el select de Dual y establece su valor en null
                    dualSelect.disabled = true;
                    dualSelect.value = "null";
                } else {
                    // Si Year no es 1, habilita el select de Dual
                    dualSelect.disabled = false;
                    dualSelectnullOption.disabled = true;
                    dualSelect.value = 1;
                }
            });

            document.addEventListener("DOMContentLoaded", function() {

            });
        </script>

@endsection
