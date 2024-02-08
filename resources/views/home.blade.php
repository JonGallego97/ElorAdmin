@extends('plantillas.navp')

@section('nav')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100 mb-4">
            <div class="card ">
                <!-- div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    @auth
                        @if(Auth::user()->hasRole('ADMINISTRADOR'))
                        <a href="{{ route('admin.index') }}">Go to Admin Users</a>
                        @elseif (Auth::user()->hasRole('PROFESOR'))
                        <a href="{{ route('users.index', ['user' => Auth::user()->id]) }}">Go to Teacher Users</a>
                        @elseif (Auth::user()->hasRole('ALUMNO'))
                        <a href="{{ route('users.index', ['user' => Auth::user()->id]) }}">Go to alumno Users</a>
                        @elseif (Auth::user()->hasRole('JEFE DE ESTUDIOS'))
                        <a href="{{ route('users.index', ['user' => Auth::user()->id]) }}">Go to jefe de estudios Users</a>
                        @elseif (Auth::user()->hasRole('DIRECCIÓN'))
                        <a href="{{ route('users.index', ['user' => Auth::user()->id]) }}">Go to direccion Users</a>
                        @elseif (Auth::user()->hasRole('BEDEL'))
                        <a href="{{ route('users.index', ['user' => Auth::user()->id]) }}">Go to bedel Users</a>
                        @elseif (Auth::user()->hasRole('LIMPIEZA'))
                        <a href="{{ route('users.index', ['user' => Auth::user()->id]) }}">Go to limpieza Users</a>
                        @endif
                    @endauth
                </div> -->
                <div class="card border-0">
                    <div class="card-header ">
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
                                <!-- Otros detalles del rol o año -->
                            </div>
                        </div>
                    </div>
                        @if (Auth::user()->hasRole('PROFESOR'))
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>
                                    {{__('Modules')}}
                                </h3>
                                     <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            @foreach($moduleName as $module)
                                            <h2 class="accordion-header" id="heading {{ $module->id }}">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id}}" aria-expanded="true" aria-controls="collapse{{ $module->id }}">
                                                    {{ $module->code }} {{ $module->name }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $module->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $module->id}}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">{{__('Name')}} </th>
                                                                <th scope="col">{{__('Email')}} </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($module->students as $studentNameModel)


                                                            <tr>
                                                                <td>{{ $studentNameModel->name }}</td>
                                                                <td>{{ $studentNameModel->email }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endforeach
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
                                                    &nbsp;<small class="text-muted">{{ __('Year') }}:
                                                        @if($cycle->year == 1)
                                                        1
                                                    @else
                                                        2
                                                    @endif

                                                    </small>
                                                    &nbsp;<small class="text-muted">{{ __('Dual') }}:
                                                        @if($cycle->is_dual == 1)
                                                            Sí
                                                        @else
                                                            No
                                                        @endif
                                                    </small>
                                                </button>

                                            </h2>
                                            <div id="collapse{{ $cycle->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $cycle->id }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">{{__('Name')}} </th>
                                                                <th scope="col">{{__('Teacher')}} </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($moduleName as $module)
                                                                    <tr>
                                                                        <td>{{ $module->name }}</td>
                                                                        <td>
                                                                            @foreach ($module->teachers as $teacher)
                                                                                <li>
                                                                                    <a href="{{ route('users.show', $teacher->id) }}" role="button">
                                                                                            {{ $teacher->surname1 }} {{ $teacher->surname2 }}, {{ $teacher->name }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </td>
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
                        @if (Auth::user()->department)
                            <div class="card mb-3">
                                <div class="card-header">
                                        <h3>{{__('Department')}}</h3>

                                    <div class="accordion" id="accordionExample">


                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $user->department->id }}">

                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $user->department->id }}" aria-expanded="true" aria-controls="collapse{{ $user->department->id }}">
                                                    {{ $user->department->name}}
                                                </button>

                                            </h2>
                                            <div id="collapse{{ $user->department->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $user->department->id }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">{{__('Name')}} </th>
                                                                <th scope="col">{{__('Email')}} </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($usersInSameDepartment  as $userD)
                                                                    <tr>
                                                                        <td>{{ $userD->name }}</td>
                                                                        <td>{{ $userD->email }}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
