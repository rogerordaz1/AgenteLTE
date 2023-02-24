@extends('panel_admin')

@section('contenido')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Crear Usuario</h3>
                </div>
                <div class="card-body">
                    <form class="pb-5" action="{{ route('dashboard.users.store') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Entra el Nombre">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mail"></i></span>
                                </div>
                                <input type="text" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelp" placeholder="Entre el email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" name="pass" id="pass"
                                placeholder="Contraseña">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="role_id">Roles</label>
                            </div>
                            <select name="role_name" class="custom-select" id="role_name">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Crear</button>
                        <a href="{{ route('dashboard.users.store') }}" type="submit" class="btn btn-secondary">Cancelar</a>

                    </form>
                </div>

            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection
