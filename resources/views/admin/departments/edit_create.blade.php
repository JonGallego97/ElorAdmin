@extends('admin.plantillas.nav')
    @section('nav')
    <div class="container">

        @if(Route::currentRouteName() == 'admin.departments.edit')
            <h1>{{__('Edit')}} {{__('department')}} {{__('Colon')}} {{$department->name}}</h1>
            <form class="mt-2" name="create_platform" action="{{route('admin.departments.update', $department)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name" class="form-label">{{__('Name')}}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{$department->name}}"/>
                </div>
                <button type="submit" class="btn btn-primary" name="">{{__('Edit')}}</button>
            </form>
        @else
            <h1>{{__('Create')}} {{__('department')}}</h1>
            <form class="mt-2" name="create_platform" action="{{route('admin.departments.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" class="form-label">{{__('Name')}}</label>
                    <input type="text" class="form-control" id="name" name="name" required/>
                </div>
                <button type="submit" class="btn btn-primary" name="">{{__('Create')}}</button>
            </form>
        @endif
    </div>
    @endsection
