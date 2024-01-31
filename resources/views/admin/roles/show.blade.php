@extends('admin.plantillas.nav')
    @section('nav')
    <div class="container mt-4">
        <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
            <div class="col d-flex align-items-center">
                <h1 class="me-2 mb-0" style="white-space: nowrap;">{{ __('Role') }}{{ __('Colon') }} {{ $role->name }}</h1>
                <a href="{{ route('roles.edit', $role) }}" class="me-2" role="button">
                    <i class="bi bi-pencil-square" style="font-size: 24px;"></i>
                </a>
            </div>
            <div class="col text-end">
                <a href="{{ route('roles.index') }}" class="me-2" role="button">
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
                                <a href="{{route('users.show', $user)}}" role="button">
                                    {{$user->name}} {{ $user->surname1 }} {{ $user->surname2 }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->dni }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('users.edit', $user) }}" class="me-2" role="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="roles/destroyRoleUser" data-type="" data-id="{{ $role->id }}/{{ $user->id}}" data-name="{{ $user->name }} {{__('from')}} {{ $role->name }}" id="openModalBtn">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                @if ($role->users->total() > 10)
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
                    {!! $role->users->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
