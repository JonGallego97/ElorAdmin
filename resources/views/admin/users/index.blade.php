@extends('admin.plantillas.nav')
    @section('nav')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <a href="{{route('users.show', $user)}}" role="button">
                        <td>{{$user->name}}</td>
                    </a>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role_id}}</td>
                    <td>
                        <a href="{{route('users.edit', $user)}}" role="button">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{route('users.destroy', $user)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button style="border: none; background: none; " type="submit" onclick="return confirm('¿Estás seguro?')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
@endsection
