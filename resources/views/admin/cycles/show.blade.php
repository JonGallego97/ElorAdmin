@extends('admin.plantillas.nav')
    @section('nav')
    <div class="container mt-4">
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col d-flex align-items-center">
                <h1 class="me-2 mb-0" style="white-space: nowrap;">{{ __('Cycle') }}{{ __('Colon') }} {{ $cycle->name }}</h1>
                <a href="{{ route('cycles.edit', $cycle) }}" class="me-2" role="button">
                    <i class="bi bi-pencil-square" style="font-size: 24px;"></i>
                </a>
            </div>
            <div class="col text-end">
                <a href="{{ route('cycles.index') }}" class="me-2" role="button">
                    <i class="bi bi-arrow-90deg-left fs-3"></i>
                </a>

            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col">
                <h4>{{ __('Department') }}{{ __('Colon') }} {{$cycle->department->name}}</h4>
            </div>
            <div class="col text-center">
                <h4>{{ __('Number of') }} {{ __('Students') }}{{ __('Colon') }} {{ $cycle->count_students }} </h4>
            </div>
            <div class="col text-end">
                <h4>{{ __('Number of modules') }}{{ __('Colon') }} {{ $cycle->modules->total() }} </h4>
            </div>
        </div>

        <div class="mt-4">
            <h3>{{__('Modules')}}</h3>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{__('Code')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Hours2')}}</th>
                        <th scope="col">{{__('Teachers')}}</th>
                        <th scope="col">{{__('Students')}}</th>
                        <th scope="col">{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cycle->modules as $module)
                        <tr>
                            <td>{{$module->code}}</td>
                            <td>
                                <a href="{{route('modules.show', $module)}}" role="button">
                                    {{$module->name}}
                                </a>
                            </td>
                            <td>{{$module->hours}}</td>
                            <td>{{$module->count_teachers}}</td>
                            <td>{{$module->count_students}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('modules.edit', $module) }}" class="me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="cycles/destroyCycleModule" data-type="" data-id="{{ $cycle->id }}/{{ $module->id}}" data-name="{{ $module->name }} {{__('from')}} {{ $cycle->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($cycle->modules->total() > 10)
                <div class="form-inline col">
                    <form class="form-inline" method="GET" id="perPageForm">
                        <label class="mr-2" for="per_page">{{__('Show')}}{{__('Colon')}}</label>
                        <select class="form-control" name="per_page" id="per_page" onchange="document.getElementById('perPageForm').submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        </select>
                    </form>
                </div>
                @endif
                <div class="d-flex justify-content-end col">
                    {!! $cycle->modules->links() !!}
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteUserModalLabel">{{__('confirm_deletion')}}</h1>
                </div>
                <div class="modal-body">
                    {{__('are_you_sure_delete')}} {{$module->name}} {{__('Question')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('cancel')}}</button>
                    <form action="{{ route('modules.destroy', $module) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary" >{{__('delete')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
