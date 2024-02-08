@extends('admin.plantillas.nav')

@section('nav')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $user['name'] }} {{ $user['surname1'] }} {{ $user['surname2'] }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="col d-flex justify-content-center">
                                    <!-- photos -->
                                    <img src="{{ asset($imagePath) }}" alt="Imagen" style="max-width: 100%; max-height: 200px;" />
                                </div>
                            </div>
                            <div class="col">
                                <p><strong>{{__('Mail')}}{{__('Colon')}}</strong> {{ $user['email'] }}</p>
                                <p><strong>{{__('DNI')}}{{__('Colon')}}</strong> {{ $user['dni'] }}</p>
                                <p><strong>{{__('Address')}}{{__('Colon')}}</strong> {{ $user['address'] }}</p>
                                <p><strong>{{__('Rol')}}{{__('Colon')}}</strong> {{ $user['roles'][0]['name'] }}</p>
                                <p><strong>{{__('PhoneNumber1')}}{{__('Colon')}}</strong> {{ $user['phone_number1'] }}</p>
                                <p><strong>{{__('PhoneNumber2')}}{{__('Colon')}}</strong> {{ $user['phone_number2'] }}</p>
                                <p><strong>{{__('Department')}}{{__('Colon')}}</strong> {{ $user['department']['name'] }}</p>
                            </div>
                            <div class="col">
                                <h3>{{__("Roles")}}</h3>
                                @foreach ($user->roles as $role)
                                <a href="{{route('admin.roles.show', $role)}}" role="button">
                                    {{$role->name}}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
