@extends('admin.plantillas.nav')
    @section('nav')
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col d-flex align-items-center">
                <h1 class="me-2 mb-0" style="white-space: nowrap;">{{ __('Role') }}{{ __('Colon') }} {{ $role->name }}</h1>
               {{-- <a href="{{ route('admin.roles.edit', $role) }}" class="me-2" role="button">
                    <i class="bi bi-pencil-square fs-2"></i>
                </a>
                <button class="me-2" type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="roles" data-type="{{__('role')}}" data-id="{{ $role->id }}" data-name="{{ $role->name }}" id="openModalBtn">
                    <i class="bi bi-trash3 fs-2"></i>
                </button>
                --}}
                <a href="{{ route('admin.roles.edit', $role)  }}" class="btn btn-warning me-2" role="button">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <!-- Botón para eliminar -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="roles" data-type="{{__('role')}}" data-id="{{ $role->id }}" data-name="{{ $role->name }}" id="openModalBtn">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.roles.index') }}" class="me-2" role="button">
                    <i class="bi bi-arrow-90deg-left fs-3"></i>
                </a>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
               <h4> {{ __('Name') }}{{ __('Colon') }} {{ $role->name }}</h4>
            </div>
            <div class="col text-end">
                <h4>{{ __('Number of persons') }}{{ __('Colon') }} {{ $role->users->total() }} </h4>
            </div>
        </div>

        <div class="mt-4">
            <h3>{{__('Users')}}</h3>
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
                    @foreach ($role->users as $user)
                        <tr>
                            <td>
                                <a href="{{route('admin.users.show', $user)}}" role="button">
                                    {{$user->name}} {{ $user->surname1 }} {{ $user->surname2 }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->dni }}</td>
                            <td>
                                <div class="d-flex">
                                   {{-- <a href="{{ route('admin.users.edit', $user) }}" class="me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="roles/destroyRoleUser" data-type="" data-id="{{ $role->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $role->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    --}}
                                    <a href="{{route('admin.users.edit', $user)  }}" class="btn btn-warning me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Botón para eliminar -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="roles/destroyRoleUser" data-type="" data-id="{{ $role->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $role->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>


                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($role->users->total() > App::make('paginationCount'))
                <div class="form-inline col">
                    <form class="form-inline" method="GET" id="perPageForm">
                        <label class="mr-2" for="per_page">{{__('Show')}}{{__('Colon')}}</label>
                        <select class="form-control" name="per_page" id="per_page" onchange="document.getElementById('perPageForm').submit()">
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            <option value="150" {{ request('per_page') == 150 ? 'selected' : '' }}>150</option>
                            <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                        </select>
                    </form>
                </div>
                @endif
                <div class="d-flex justify-content-end col">
                    {!! $role->users->links() !!}
                </div>
            </div>
        </div>
@endsection
