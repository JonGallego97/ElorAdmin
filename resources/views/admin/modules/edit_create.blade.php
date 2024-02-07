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
                action="{{route('admin.modules.update', $module)}}"
            @else
                action="{{route('admin.modules.store')}}"
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
            <!-- <div class="form-group mb-3">
                <label for="cycle" class="form-label">{{__('Cycle')}}</label>
                <select id="cycle" name="cycle[]" class="form-control" multiple>
                @foreach ($departmentsWithCycles as $department)
                    <optgroup label='-- {{$department->name}} --'>
                    @foreach ($department->cycles as $cycle)
                    <option value="{{ $cycle->id }}"
                    @if(in_array($cycle->id,$moduleCyclesIds))
                    selected
                    @endif
                    >{{ $cycle['name'] }}</option>
                    @endforeach
                @endforeach
                </select>
            </div> -->
            <div class="form-group mb-3 col-4" style="max-height: 200px; overflow-y: auto;">
                <label class="form-label">{{__('Cycles')}}</label>
                @foreach ($departmentsWithCycles as $department)
                    <div class="mb-2">
                        <strong>-- {{ $department->name }} --</strong>
                    </div>
                    @foreach ($department->cycles as $cycle)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="cycles[]" value="{{ $cycle->id }}" id="cycle_{{ $cycle->id }}"
                            @if(in_array($cycle->id, $moduleCyclesIds))
                                checked
                            @endif
                            >
                            <label class="form-check-label" for="cycle_{{ $cycle->id }}">{{ $cycle->name }}</label>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary" name="">
                @if($module->id != null)
                    {{__('Edit')}}
                @else
                    {{__('Create')}}
                @endif

            </button>
            <input type="hidden" name="last_url" value="{{  URL::previous() }}">
        </form>
    </div>
    @endsection
