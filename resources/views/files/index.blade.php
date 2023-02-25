@extends('panel_admin')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('contenido')
    {{--  La DataTablde DE adminlte --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selecciones los archivos de la lista numérica</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.file.clientes') }}" enctype="multipart/form-data" id="upload"
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
                    <h3 class="card-title">Selecciones los archivos de el cargo a emitir</h3>
                    <div class="d-flex justify-content-end">

                        {{-- <a href="{{ route('dashboard.file.vaciarFacturas') }}" type="button"
                            class="btn btn-info btn-sm ml-auto">Vaciar Facturas</a> --}}

                        <button type="button" class="btn btn-danger btn-sm" id="delete-facturas-btn">Eliminar
                            Facturas</button>
                    </div>

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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selecione los Agentes a Subir</h3>
                </div>

                <div class="card-body">
                    <form id="upload-form" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="files[]" multiple>
                        <button class="btn btn-primary" id="confirm" type="submit">
                           Confirmar
                        </button>
                        <button class="btn btn-primary" id="loading" style="display: none;" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="delete-facturas-modal" tabindex="-1" role="dialog"
        aria-labelledby="delete-facturas-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-facturas-modal-label">Eliminar Facturas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que deseas eliminar las facturas?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="delete-facturas-form" action="{{ route('dashboard.file.vaciarFacturas') }}" method="get">
                        @csrf

                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('js')
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('#delete-facturas-btn').click(function() {
                $('#delete-facturas-modal').modal('show');
            });
        });
    </script>
    <script>
        $('#upload-form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            console.log(formData);

            $.ajax({
                url: '{{ route('dashboard.file.clientes_prueba') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(event) {
                        if (event.lengthComputable) {
                            var percent = Math.round((event.loaded / event.total) * 100);
                            $('#progress-bar').css('width', percent + '%').attr('aria-valuenow',
                                percent);
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function() {
                    console.log('Antes de enviar');
                    // Muestra el indicador de carga
                    $('#loading').show();
                    $('#confirm').hide();
                },
                success: function(response) {
                    // Maneja la respuesta del servidor
                    $('#loading').hide();
                    $('#confirm').show();
                    console.log(response);
                    // swal("Good job!", "You clicked the button!", "success");
                },
                error: function(xhr, status, error) {
                    // Maneja los errores
                    $('#confirm').show();
                    $('#loading').hide();
                    console.error(error);
                },
                complete: function() {
                    // Oculta el indicador de carga
                    $('#loading').hide();
                    $('#confirm').show();
                }
            });
        });
    </script>
@endsection
