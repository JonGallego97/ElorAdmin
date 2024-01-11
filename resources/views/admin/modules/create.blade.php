@extends('admin.plantillas.nav')
    @section('nav')
    <div class="container">

        @if($module->name != null)
            <h1>{{__('Edit')}} {{__('module')}} {{__('Colon')}} {{$module->name}}</h1>
        @else
            <h1>{{__('Create')}} {{__('module')}}</h1>
        @endif

        <form class="mt-2" name="create_platform"

            @if($module->id != null)
                action="{{route('modules.update', $module)}}"
            @else
                action="{{route('modules.store')}}"
            @endif

            method="POST" enctype="multipart/form-data">
            @csrf
            @if($module->id != null)
                @method('PUT')
            @endif

            @csrf
            <div class="form-group mb-3">
                <label for="name" class="form-label">{{__('Name')}}</label>
                <input type="text" class="form-control" id="name" name="name" required
                    value="{{$module->name}}"/>
            </div>
            <div class="form-group mb-3">
                <label for="name" class="form-label">{{__('Code')}}</label>
                <input type="text" class="form-control" id="code" name="code" required
                    value="{{$module->code}}"/>
            </div>
            <div class="form-group mb-3">
                <label for="name" class="form-label">{{__('Hours2')}}</label>
                <input type="text" class="form-control" id="hours" name="hours" required
                    value="{{$module->hours}}"/>
            </div>
            <button type="submit" class="btn btn-primary" name="">
                @if($module->id != null)
                    {{__('Edit')}}
                @else
                    {{__('Create')}}
                @endif

            </button>
        </form>
    </div>
    @endsection
