@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

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
                        <a href="{{ route('person.index', ['user' => Auth::user()->id]) }}">Go to Teacher Users</a>

                        @elseif (Auth::user()->hasRole('ALUMNO'))
                        <a href="{{ route('person.index', ['user' => Auth::user()->id]) }}">Go to alumno Users</a>
                        @elseif (Auth::user()->hasRole('JEFE DE ESTUDIOS'))
                        <a href="{{ route('person.index', ['user' => Auth::user()->id]) }}">Go to jefe de estudios Users</a>
                        @elseif (Auth::user()->hasRole('DIRECCIÓN'))
                        <a href="{{ route('person.index', ['user' => Auth::user()->id]) }}">Go to direccion Users</a>
                        @elseif (Auth::user()->hasRole('BEDEL'))
                        <a href="{{ route('person.index', ['user' => Auth::user()->id]) }}">Go to bedel Users</a>
                        @elseif (Auth::user()->hasRole('LIMPIEZA'))
                        <a href="{{ route('person.index', ['user' => Auth::user()->id]) }}">Go to limpieza Users</a>



                        @endif

                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
