@extends('admin.plantillas.nav')
    @section('nav')
    <div class="container">

        @if($role->name != null)
            <h1>{{__('Edit')}} {{__('role')}} {{__('Colon')}} {{$role->name}}</h1>
        @else
            <h1>{{__('Create')}} {{__('role')}}</h1>
        @endif

        <form class="mt-2" name="create_platform"

            @if($role->id != null)
                action="{{route('admin.roles.update', $role)}}"
            @else
                action="{{route('admin.roles.store')}}"
            @endif

            method="POST" enctype="multipart/form-data">
            @csrf
            @if($role->id != null)
                @method('PUT')
            @endif

            @csrf
            <div class="form-group mb-3">
                <label for="name" class="form-label">{{__('Name')}}</label>
                <input type="text" class="form-control" id="name" name="name" required
                    value="{{$role->name}}"/>
            </div>
            <button type="submit" class="btn btn-primary" name="">
                @if($role->id != null)
                    {{__('Edit')}}
                @else
                    {{__('Create')}}
                @endif

            </button>
        </form>
    </div>
    @endsection
