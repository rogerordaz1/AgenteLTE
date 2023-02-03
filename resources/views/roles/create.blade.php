@extends('panel_admin')

@section('contenido')
    <h1>Crear Rol</h1>
    {!! Form::open(['route' => 'dashboard.roles.index']) !!}
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




    {!! Form::submit('Crear Rol', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('dashboard.roles.index') }}" type="button" class="btn btn-secondary">Cancelar</a>

    {!! Form::close() !!}
@endsection
