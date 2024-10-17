@extends('layouts.app')

@section('content')

    <h2>Gestionar Roles para {{ $user->persona->nombre }}</h2>

    <form action="{{ route('users.updateRoles', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="roles">Roles:</label>
            <select name="roles[]" id="roles" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        @if($user->hasRole($role->name)) selected @endif>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Actualizar Roles</button>
    </form>



    {{ $users2->links() }}  <!-- Para la paginación -->
@endsection
