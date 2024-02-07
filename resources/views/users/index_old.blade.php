@extends('plantillas.navp')
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
                    <p><strong>{{__('DNI')}}{{__('Colon')}}</strong> {{ $user['dni'] }}</p>
                    <p><strong>{{__('Address')}}{{__('Colon')}}</strong> {{ $user['address'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>{{__('Rol')}}{{__('Colon')}}</strong> {{ $user['roles'][0]['name'] }}</p>
                    <p><strong>{{__('PhoneNumber1')}}{{__('Colon')}}</strong> {{ $user['phone_number1'] }}</p>
                    <p><strong>{{__('PhoneNumber2')}}{{__('Colon')}}</strong> {{ $user['phone_number2'] }}</p>
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
                            <h3>{{$cycle['name'] }}</h3>
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
                                    @foreach ($user['modules'] as $module)
                                        @if ($user['modules']->contains('id', $module['id']))
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

                                                                <tr>
                                                                    <th scope="col">{{__('Name')}}</th>
                                                                    <th scope="col">{{__('email')}}</th>

                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    @if ($usersInRole3ByModule)
                                                                    @foreach ($usersInRole3ByModule as $user)
                                                                        <tr>
                                                                            <td>{{ $user->name }}</td>
                                                                            <td>{{ $user->email }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="2">No users found</td>
                                                                    </tr>
                                                                @endif
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
            @elseif (Auth::user()->hasRole('ALUMNO'))
                <div class="card mb-3">
                    <div class="card-header">
                            <h3>{{__('Cycles')}}</h3>

                        <div class="accordion" id="accordionExample">
                            @if ($user->cycles->isEmpty())
                            <p>No cycles found for this user.</p>
                            @else
                            @foreach ($user->cycles as $cycle)

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $cycle->id }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $cycle->id }}" aria-expanded="true" aria-controls="collapse{{ $cycle->id }}">
                                        {{ $cycle->name }}

                                        &nbsp;<small class="text-muted">{{ __('Registered') }}: {{ $cycle->created_at->toDateString() }}</small>
                                        &nbsp;<small class="text-muted">{{ __('Year') }}: {{ max(1, $cycle->year - date('Y')) }}</small>
                                    </button>

                                </h2>
                                <div id="collapse{{ $cycle->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $cycle->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{__('Name')}} </th>
                                                    <th scope="col">{{__('user')}} </th>
                                                    <th scope="col">{{__('email')}} </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cycle->sortedModules  as $module)
                                                        <tr>
                                                            <td>{{ $module->name }}</td>
                                                            @foreach ($usera as $aUser)
                                                                @if ($aUser->hasRole('PROFESOR'))

                                                                    <td>{{ $aUser->name }}</td>
                                                                    <td>{{ $aUser->email }}</td>
                                                                @break
                                                                @endif
                                                        @endforeach
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
