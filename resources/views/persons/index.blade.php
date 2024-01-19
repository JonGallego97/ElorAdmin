@extends('persons.plantillas.navp')
@if (Auth::user()->hasRole('PROFESOR'))
    @section('nav')
@else
    @section('content')
@endif

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
            @if (Auth::user()->hasRole('PROFESOR'))
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h3>{{__('Modules')}}</h3>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">

                          <div class="card-body">
                            @foreach ($user['cycles'] as $cycle)
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('Nº')}}</th>
                                        <th scope="col">{{__('Name')}}</th>
                                        <th scope="col">{{__('Hours')}}</th>
                                        <th scope="col">{{__('Users')}}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cycle['modules'] as $module)
                                        @if (in_array($module->id, $user['modules']->pluck('id')->toArray()))
                                            <tr>
                                                <td>{{ $module['code'] }}</td>
                                                <td>
                                                    {{ $module['name'] }}
                                                </td>
                                                <td>({{ $module['hours'] }} {{__('Hours')}})</td>
                                                <td>

                                                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#usersCollapse{{ $module->id }}" aria-expanded="false" aria-controls="usersCollapse{{ $module->id }}">
                                                        Show Users
                                                    </button>
                                                    <div class="collapse" id="usersCollapse{{ $module->id }}">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                @foreach ($usersInRole3ByModule[$module->id] as $userInRole3)
                                                                <tr>
                                                                    <th scope="col">{{__('Name')}}</th>
                                                                    <th scope="col">{{__('email')}}</th>

                                                                </tr>
                                                                @endforeach
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $userInRole3->name }}</td>
                                                                    <td>{{ $userInRole3->email }}</td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
                            @endforeach
                        </div>

                    </div>

                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h3>{{__('Staff')}}</h3>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">

                            <div class="card mb-3">

                                <div class="card-body">
                                    <h5>{{__('Teachers')}}</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Name')}}</th>
                                                <th scope="col">{{__('Surname1')}}</th>
                                                <th scope="col">{{__('Surname2')}}</th>
                                                <th scope="col">{{__('Mail')}}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usera as $usera)
                                            <tr>
                                                <td>

                                                        {{$usera->name}}

                                                </td>
                                                <td>{{$usera->surname1}}</td>
                                                <td>{{$usera->surname2}}</td>
                                                <td>{{$usera->email}}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (Auth::user()->hasRole('ALUMNO'))

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#usersCollapse" aria-expanded="false" aria-controls="usersCollapse">
                            <h3>{{__('Cycles')}}</h3>
                        </button>
                    </h2>
                    <div id="usersCollapse" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="card-body">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Name')}}</th>
                                                <th scope="col">{{__('Department')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                                @if (is_object($cycle) && property_exists($cycle, 'someProperty') && $cycle->someProperty)
                                                @foreach ($cycle as $cycle)
                                                    <tr>
                                                        <td>
                                                            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#detailsCollapse{{ $cycle->id }}" aria-expanded="false" aria-controls="detailsCollapse{{ $cycle->id }}">

                                                                {{$cycle->name}}
                                                            </button>
                                                            <div class="collapse" id="detailsCollapse{{ $cycle->id }}">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">{{__('Matricula')}}</th>
                                                                            <th scope="col">{{__('Fecha')}}</th>
                                                                            <th scope="col">{{__('Curso')}}</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ $cycle['id'] }}</td>
                                                                            <td>{{ $cycle['created_at'] }}</td>
                                                                            <td>{{ $user['year'] }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td>{{$cycle->department->name}}</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2">No hay ciclos</td>
                                                    </tr>
                                                @endif
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
    @endif
</div>
@endsection
