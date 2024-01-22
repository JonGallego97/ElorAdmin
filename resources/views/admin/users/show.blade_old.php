@extends('admin.plantillas.nav')

@section('nav')
    <div class="container">
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    dd(Request::url)
                    @switch(Request::url)
                        @case('*user*')
                            <h1>{{__('User')}}</h1>
                            @break
                    @endswitch
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.users.index') }}" class="me-2" role="button">
                    <i class="bi bi-arrow-90deg-left fs-3"></i>
                </a>

            </div>
        </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection
