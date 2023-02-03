@extends('panel_admin')

@section('contenido')
    <h2>La oficina comercia es : {{ $comercial->nombre }}</h2>

    @foreach ($clientes as $cliente)
        {{ $cliente->nombre }}
    @endforeach
@endsection