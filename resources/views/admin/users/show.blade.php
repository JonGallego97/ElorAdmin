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
                <h2>{{ $user['name'] }} {{ $user['surname1'] }} {{ $user['surname2'] }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <p><strong>{{__('DNI')}}{{__('Colon')}}</strong> {{ $user['dni'] }}</p>
                        <p><strong>{{__('Mail')}}{{__('Colon')}}</strong> {{ $user['email'] }}</p>
                        <p><strong>{{__('Address')}}{{__('Colon')}}</strong> {{ $user['address'] }}</p>
                        <p><strong>{{__('PhoneNumber1')}}{{__('Colon')}}</strong> {{ $user['phone_number1'] }}</p>
                        <p><strong>{{__('PhoneNumber2')}}{{__('Colon')}}</strong> {{ $user['phone_number2'] }}</p>
                        @if(in_array('ALUMNO',$user->roles->pluck('name')->toArray()))
                        <p><strong>{{__('Year')}}{{__('Colon')}}</strong> {{ $user['year'] }}</p>
                        <p><strong>{{__('Dual')}}{{__('Colon')}}</strong> {{ $user['dual'] ? __('Yes') : __('No') }}</p>
                        @endif
                        <!-- Otros detalles del usuario -->
                    </div>
                    <!-- <div class="col-md-4">
                        <p><strong>{{__('Rol')}}{{__('Colon')}}</strong> {{ $user['roles'][0]['name'] }}</p>
                        <p><strong>{{__('PhoneNumber1')}}{{__('Colon')}}</strong> {{ $user['phone_number1'] }}</p>
                        <p><strong>{{__('PhoneNumber2')}}{{__('Colon')}}</strong> {{ $user['phone_number2'] }}</p>
                        @if(in_array('STUDENT',$user->roles->pluck('name')->toArray()))
                        <p><strong>{{__('Dual')}}{{__('Colon')}}</strong> {{ $user['dual'] ? __('Yes') : __('No') }}</p>
                        @endif
                    </div> -->
                    <div class="col-md-4">
                        <!-- photo -->
                        <img src="{{ asset($imagePath) }}" alt="Imagen" />
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
                </div>
                <hr>
                <!-- Si tiene el rol de Profesor -->
                @if(in_array('PROFESOR',$user->roles->pluck('name')->toArray()))
                    <h3>{{__('Cycles')}}</h3>
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

                <!-- Si tiene el rol de Profesor -->
                @if(in_array('STUDENT',$user->roles->pluck('name')->toArray()))
                    <h3>{{__('Cycles')}}</h3>
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
