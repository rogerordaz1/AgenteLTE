@extends('panel_admin')

@section('contenido')
    {{--  La DataTablde DE adminlte --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selecciones los archivos de la lista numérica</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.file.clientes') }}" enctype="multipart/form-data" id="upload-file"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="file[]" multiple required
                                        id="file" placeholder="ELige el archivo">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Confirmar</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selecciones los archivos de el cargo a emitir</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.file.facturas') }}" enctype="multipart/form-data" id="upload-file"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="file[]" multiple required id="file"
                                        placeholder="ELige el archivo">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Confirmar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selecione los Agentes a Subir</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.file.agentes') }}" enctype="multipart/form-data" id="upload-file"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="file[]" multiple required id="file"
                                        placeholder="ELige el archivo">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Confirmar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
