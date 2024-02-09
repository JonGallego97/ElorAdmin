@extends('admin.plantillas.nav')
    @section('nav')
    <div class="container">
        @if(Route::currentRouteName() == 'admin.cycles.edit')
            <h1>{{__('Edit')}} {{__('Cycle')}} {{__('Colon')}} {{$cycle->name}}</h1>
            <form class="mt-2" name="create_platform" action="{{route('admin.cycles.update', $cycle)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name" class="form-label">{{__('Name')}}</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{$cycle->name}}"/>
                </div>
                <div class="form-group mb-3">
                <label for="department" class="form-label">{{__('Department')}}</label>
                    <select id="department" name="department" class="form-control">
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                        @if($department->id == $cycle->department_id)
                        selected
                        @endif
                        >{{ $department['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3" style="max-height: 200px; overflow-y: auto;">
                    <label for="modules" class="form-label">{{__('Modules')}}</label>

                    @foreach ($allModules as $module)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modules[]" id="module_{{ $module->id }}" value="{{ $module->id }}"
                            {{ $cycle->modules->contains('id', $module->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="module_{{ $module->id }}">
                                {{ $module['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary" name="">{{__('Edit')}}</button>
            </form>
        @else
            <h1>{{__('Create')}} {{__('Cycle')}}</h1>
            <form class="mt-2" name="create_platform" action="{{route('admin.cycles.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" class="form-label">{{__('Name')}}</label>
                    <input type="text" class="form-control" id="name" name="name" required/>
                </div>
                <div class="form-group mb-3">
                    <label for="department" class="form-label">{{__('Department')}}</label>
                    <select id="department" name="department" class="form-control">
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3" style="max-height: 200px; overflow-y: auto;">
                    <label for="modules" class="form-label">{{__('Modules')}}</label>

                    @foreach ($modules as $module)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="modules[]" id="module_{{ $module->id }}" value="{{ $module->id }}">
                            <label class="form-check-label" for="module_{{ $module->id }}">
                                {{ $module['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary" name="">{{__('Create')}}</button>
            </form>
        @endif
    </div>
    @endsection