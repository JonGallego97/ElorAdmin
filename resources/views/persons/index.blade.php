@extends('persons.plantillas.navp')
@section('nav')
<div class="container">
    <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
        <div class="col">
            <h1>
                @auth
                @if (Auth::user()->hasRole('PROFESOR'))
                    {{__('teacher')}}
                @elseif (Auth::user()->hasRole('ALUMNO'))
                    {{__('Student')}}
                @elseif (Auth::user()->hasRole('JEFE DE ESTUDIOS'))
                    {{__('Head of studies')}}
                @elseif (Auth::user()->hasRole('DIRECCIÓN'))
                {{__('Head of studies')}}
                @elseif (Auth::user()->hasRole('BEDEL'))
                {{__('Bedel')}}
                @elseif (Auth::user()->hasRole('LIMPIEZA'))
                {{__('Limpieza')}}
                @endif
            @endauth

            </h1>
        </div>
        <div class="col text-end">
           <a href="{{ route('admin.teachers.index') }}" class="me-2" role="button">
                <i class="bi bi-arrow-90deg-left fs-3"></i>
            </a>

        </div>
    </div>
    @if ($user)
    <div class="card">

        <div class="card-header">

            <h2>{{ $user['name'] }} {{ $user['surname1'] }} {{ $user['surname2'] }}</h2>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>{{__('Mail')}}{{__('Colon')}}</strong> {{ $user['email'] }}</p>
                    <p><strong>{{__('DNI')}}{{__('Colon')}}</strong> {{ $user['DNI'] }}</p>
                    <p><strong>{{__('Address')}}{{__('Colon')}}</strong> {{ $user['address'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>{{__('Rol')}}{{__('Colon')}}</strong> {{ $user['roles'][0]['name'] }}</p>
                    <p><strong>{{__('PhoneNumber1')}}{{__('Colon')}}</strong> {{ $user['phoneNumber1'] }}</p>
                    <p><strong>{{__('PhoneNumber2')}}{{__('Colon')}}</strong> {{ $user['phoneNumber2'] }}</p>

                    <!-- Otros detalles del rol o año -->
                </div>
                @if (Auth::user()->hasRole('PROFESOR'))
                <div class="col-md-6">
                    <p><strong>{{__('Department')}}{{__('Colon')}}</strong> {{ $user->department->name}}</p>
                </div>
                @endif
            </div>

            <hr>

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
                                    @if (in_array($module->id, $user['modules']->pluck('id')->toArray()))

                                        <li>{{ $module['code'] }} - <a href="{{ route('modules.show', $module) }}" role="button">{{ $module['name'] }}</a> ({{ $module['hours'] }} {{__('Hours')}})</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach


        </div>
    </div>
    @endif
</div>
@endsection
