@extends('admin.plantillas.nav')
    @section('nav')
    <div class="container mt-4">
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col">
                <h1>
                    <h1>{{ __('Module') }}{{ __('Colon') }} {{ $module->name }}</h1>
                </h1>
            </div>
            <div class="col text-end">
                <a href="{{ route('modules.index') }}" class="me-2" role="button">
                    <i class="bi bi-arrow-90deg-left fs-3"></i>
                </a>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
               <h4> {{ __('Name') }}{{ __('Colon') }} {{ $module->name }}</h4>
            </div>
            <div class="col text-center">
                <h4>{{ __('Number of') }} {{ __('Teachers') }}{{ __('Colon') }} {{ $module->teachers->total() }} </h4>
            </div>
            <div class="col text-end">
                <h4>{{ __('Number of') }} {{ __('Students') }}{{ __('Colon') }} {{ $module->students->total() }} </h4>
            </div>
        </div>

        <div class="mt-4">
            <h3>{{__('Teachers')}}</h3>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{__('Full name')}}</th>
                        <th scope="col">{{__('Mail')}}</th>
                        <th scope="col">{{__('DNI')}}</th>
                        <th scope="col">{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($module->teachers as $user)
                        <tr>
                            <td>
                                <a href="{{route('users.show', $user)}}" role="button">
                                    {{$user->name}} {{ $user->surname1 }} {{ $user->surname2 }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->DNI }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('users.edit', $user) }}" class="me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="modules/destroyModuleUser" data-type="" data-id="{{ $module->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $module->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($module->teachers->total() > 10)
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
                    {!! $module->teachers->links() !!}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h3>{{__('Students')}}</h3>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{__('Full name')}}</th>
                        <th scope="col">{{__('Mail')}}</th>
                        <th scope="col">{{__('DNI')}}</th>
                        <th scope="col">{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($module->students as $user)
                        <tr>
                            <td>
                                <a href="{{route('users.show', $user)}}" role="button">
                                    {{$user->name}} {{ $user->surname1 }} {{ $user->surname2 }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->DNI }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('users.edit', $user) }}" class="me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($module->students->total() > 10)
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
                    {!! $module->students->links() !!}
                </div>
            </div>
        </div>

    </div>

@endsection
