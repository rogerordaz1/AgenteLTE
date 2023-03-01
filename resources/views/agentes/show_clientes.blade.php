@extends('panel_admin')

@section('contenido')
    {{--  La DataTablde DE adminlte --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Facturas de los clientes de : {{ $agente->nombre }}</h3>
                    <div class="d-flex justify-content-end datatable-buttons">

                        <a href="{{ route('dashboard.agentes.edit', $agente) }}" type="button"
                            class="btn btn-info btn-sm ml-auto mr-1">Adicionar Cliente</a>

                    </div>
                </div>
                <div class="card-body">
                    <div id="clientes-agente_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="clientes-agente" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending"> Oficina
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending"> Nombre
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending">
                                                Agrupacion
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Cuenta
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">#Factura
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Servicio
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Atraso
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Total
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Utilidad
                                            </th>


                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Oficina</th>
                                            <th rowspan="1" colspan="1">Nombre</th>
                                            <th rowspan="1" colspan="1">Agrupacion</th>
                                            <th rowspan="1" colspan="1">Cuenta</th>
                                            <th rowspan="1" colspan="1">#Factura</th>
                                            <th rowspan="1" colspan="1">Servicio</th>
                                            <th rowspan="1" colspan="1">Atraso</th>
                                            <th rowspan="1" colspan="1">Total</th>
                                            <th rowspan="1" colspan="1">Utilidad</th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($agente->nagregados->isNotEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Numeros de otras provincias del agente : {{ $agente->nombre }}</h3>
                        <div id="buttons"></div>
                    </div>
                    <div class="card-body">
                        <div id="nagregados_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="nagregados" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Rendering engine: activate to sort column descending">
                                                    Nombre
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="">Agente
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="">#Servicio
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($agente->nagregados as $nagregado)
                                                <tr>
                                                    <td style="">{{ $nagregado->nombre }}</td>
                                                    <td style="">{{ $agente->nombre }}</td>
                                                    <td style="">{{ $nagregado->servicio }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>

                                                <th rowspan="1" colspan="1">Nombre</th>
                                                <th rowspan="1" colspan="1">Agente</th>
                                                <th rowspan="1" colspan="1">$Servicio</th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection



@section('css')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }} ">
@endsection

@section('js')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }} "></script>

    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js ') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


    <script>
        $(function() {
            let table = $("#clientes-agente").DataTable({
                dom: "B<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "{{ route('datatable.cliente-agente', $agente) }}",
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'oficina'
                    },
                    {
                        data: 'nombre_cliente'
                    },
                    {
                        data: 'agrupacion'
                    },
                    {
                        data: 'cuenta'
                    },
                    {
                        data: 'no_factura'
                    },
                    {
                        data: 'servicio_cliente'
                    },
                    {
                        data: 'atraso'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'unlink_client'
                    },
                ],
                responsive: true,
                autoWidth: false,
                buttons: [{
                        extend: 'pdf',
                        text: 'PDF',
                        titleAttr: 'Exportar a PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        className: 'btn btn-warning btn-sm mr-1'
                    },
                    {
                        extend: 'excel',
                        text: 'Exel',
                        titleAttr: 'Exportar a EXEL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]

                        },
                        className: 'btn btn-warning btn-sm mr-1'
                    },
                    {
                        extend: 'copy',
                        text: 'Copiar',
                        titleAttr: 'Copiar el Contenido',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]

                        },
                        className: 'btn btn-warning btn-sm mr-1'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        titleAttr: 'Exportar a CSV',
                        exportOptions: {
                            columns: [5, 7]
                        },
                        customize: function(csv) {
                            // Obtiene el contenido del CSV sin el encabezado
                            var rows = csv.split('\n').slice(1);

                            // Recorre cada fila del CSV y obtiene los valores de las columnas "número de teléfono" y "total a pagar"
                            for (var i = 0; i < rows.length; i++) {
                                var cols = rows[i].split(',');
                                var telefono = cols[0].replace(/"/g, '');
                                var total = cols[1].replace(/"/g, '');;
                                // Crea una nueva fila con el formato "número de teléfono, CUP, total a pagar"
                                var newRow = telefono + ',CUP,' + total;
                                // Reemplaza la fila original con la nueva fila
                                rows[i] = newRow;
                            }

                            // Une las filas modificadas con el encabezado personalizado
                            var newCsv =  rows.join('\n');

                            // Devuelve el CSV modificado
                            return newCsv;
                        },
                        className: 'btn btn-warning btn-sm mr-1',

                    },
                ],
                language: {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "Nada encontrado - disculpa",
                    "info": "Mostrando la pagina _PAGE_ de _PAGES_ con _TOTAL_ registros",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "loadingRecords": "Cargando Datos Por favor espere...",

                },
            });

            table.buttons().container().appendTo($('.datatable-buttons'));
        });

        $("#nagregados").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Nada encontrado - disculpa",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_ con _TOTAL_ registros",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "loadingRecords": "Cargando Datos Por favor espere...",
            }
        });
    </script>
@endsection
