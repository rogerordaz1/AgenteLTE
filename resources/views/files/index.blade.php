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
                    <form action="{{ route('dashboard.file.clientes') }}"  enctype="multipart/form-data" id="upload" method="POST">
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
                            <div id="loader" style="display:none;">Cargando...</div>
                            <div id="message"></div>
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
{{-- 
@section('js')
    <script>
        $(document).ready(function() {
            $("#upload").submit(function(event) {
                event.preventDefault(); // Detener el envío del formulario predeterminado

                // Obtener los archivos seleccionados
                var files = $("#file").prop("files");

                // Crear un objeto FormData para enviar los datos del archivo
                var formData = new FormData();
                $.each(files, function(key, value) {
                    formData.append(key, value);
                });

             
                $.ajax({
                    url: '{{ route('dashboard.file.clientes') }}',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(data) {
                        console.log(data);
                        alert('Los archivos se han cargado con éxito.');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Se produjo un error al cargar los archivos.');
                    }
                });
            });
        });
    </script>
@endsection --}}
