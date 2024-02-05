@extends('plantillas.navp')

@section('nav')
    <div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
        <div class="col">
            <h1>{{ __('Departments') }}</h1>
        </div>
        <div class="col text-end">
            <a href="{{ url()->previous() }}" class="me-2" role="button">
                <i class="bi bi-arrow-90deg-left fs-3"></i>
            </a>

        </div>
    </div>

    <div class="accordion" id="accordionExample">
        @foreach ($departments as $department)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $department->id }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $department->id }}" aria-expanded="true" aria-controls="collapse{{ $department->id }}">
                        {{ $department->name }} [{{count($department->users)}}]
                    </button>
                </h2>
                <div id="collapse{{ $department->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $department->id }}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">{{__('Name')}}</th>
                                    <th scope="col">{{__('Email')}}</th>
                                    <th scope="col">{{__('Phone')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department->users as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ route('users.show', $user)}}" role="button">
                                            {{ $user->surname1 }} {{ $user->surname2 }}, {{ $user->name }}
                                            </a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_number1 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
