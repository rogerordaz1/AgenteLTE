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
                    <form action="{{ route('dashboard.file.clientes') }}" enctype="multipart/form-data" id="clientes-upload"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="files[]" multiple required id="file"
                                        placeholder="ELige el archivo">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary" id="confirm-cliente" type="submit">
                                    Confirmar
                                </button>
                                <button class="btn btn-primary" id="loading-cliente" style="display: none;" type="button"
                                    disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Cargando...
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selecciones los archivos de las facturas</h3>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger btn-sm" id="delete-facturas-btn">Eliminar
                            Facturas</button>
                    </div>

                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.file.facturas') }}" enctype="multipart/form-data" id="facturas-upload"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="files[]" multiple required id="file"
                                        placeholder="ELige el archivo">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary" id="confirm-factura" type="submit">
                                    Confirmar
                                </button>
                                <button class="btn btn-primary" id="loading-factura" style="display: none;" type="button"
                                    disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Cargando...
                                </button>
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



@section('js')
    <script>
        $(document).ready(function() {
            $('#delete-facturas-btn').click(function() {
                $('#delete-facturas-modal').modal('show');
            });
        });
    </script>
    {{-- Este es el script de los clientes... --}}
    <script>
        $('#clientes-upload').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('dashboard.file.clientes') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    console.log('Antes de enviar');
                    // Muestra el indicador de carga
                    $('#loading-cliente').show();
                    $('#confirm-cliente').hide();
                },
                success: function(response) {
                    // Maneja la respuesta del servidor
                    $('#loading-cliente').hide();
                    $('#confirm-cliente').show();
                    console.log(response);

                    swal({
                            title: response.header,
                            text: response.message,
                            icon: response.icon,
                            button: "Cerrar",
                        }

                    ).then((value) => {
                        location.reload();

                    });


                },
                error: function(xhr, status, error) {
                    // Maneja los errores
                    $('#confirm-cliente').show();
                    $('#loading-cliente').hide();
                    console.log(error);

                    swal({
                        title: "Ha Occurrido algun Error",
                        text: error,
                        icon: 'error',
                        button: "Cerrar",
                    }).then((value) => {
                        location.reload();

                    });

                },

            });
        });
    </script>
    {{-- Este es el script de las facturas --}}

    <script>
        $('#facturas-upload').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('dashboard.file.facturas') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    console.log('Antes de enviar');
                    // Muestra el indicador de carga
                    $('#loading-factura').show();
                    $('#confirm-factura').hide();
                },
                success: function(response) {
                    // Maneja la respuesta del servidor
                    $('#loading-factura').hide();
                    $('#confirm-factura').show();
                    console.log(response);
                    swal({
                            title: response.header,
                            text: response.message,
                            icon: response.icon,
                            button: "Cerrar",
                        }
                    ).then((value) => {
                        location.reload();

                    });
                },
                error: function(xhr, status, error) {
                    // Maneja los errores
                    $('#confirm-factura').show();
                    $('#loading-factura').hide();
                    console.log(error);

                    swal({
                        title: "Ha Occurrido algun Error",
                        text: error,
                        icon: 'error',
                        button: "Cerrar",
                    }).then((value) => {
                        location.reload();
                    });

                },

            });
        });
    </script>
@endsection
