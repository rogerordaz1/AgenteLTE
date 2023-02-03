@extends('panel_admin')

@section('contenido')
    <h1>Editar Usuario</h1>

    <form class="pb-5" action="{{ route('dashboard.users.update' , $user) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" 
            class="form-control" 
            name="name" 
            id="name" 
            value="{{ $user->name }}"
            placeholder="Entra el Nombre">
            
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control"
            value="{{ $user->email }}"
            name="email" id="email" aria-describedby="emailHelp"
                placeholder="Entre el email">
        </div>

        <div class="form-group">
            <label for="pass">Password</label>
            <input type="password"
             class="form-control"
              name="pass"
               id="pass"
               value="{{ $user->password }}"
                placeholder="Contraseña">
        </div>



        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="role_id">Roles</label>
            </div>
            <select name="role_id" class="custom-select" id="role_id">
                @foreach ($roles as $role)
               
                <option  value="{{ $role->id }}">{{ $role->name }}</option>
                    
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Editar</button>
        <a href="/dashboard/users" type="submit" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
