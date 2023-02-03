@extends('panel_admin')

@section('contenido')
    <h1>Editar Rol</h1>

    @if (session('info'))
        <div class="alert alert-success">
            {{session('info')}}
        </div>
        
    @endif

    {!! Form::model($role, ['route' => ['dashboard.roles.update', $role], 'method' => 'put']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, [
            'class' => 'form-control',
            'placeholder' => 'Ingrese el nombre del rol',
        ]) !!}
    </div>
    @error('name')
        <small class="text-danger">
            {{ $message }}
        </small>
    @enderror

    <h2 class="h3"> Lista de Permisos</h2>

    @foreach ($permissions as $permission)
        <div>
            <label>


                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1']) !!}
              
                {{ $permission->description }}

            </label>
        </div>
    @endforeach

    {!! Form::submit('Editar Rol', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection
