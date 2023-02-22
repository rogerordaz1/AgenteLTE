@extends('panel_admin')

@section('contenido')
    {{--  La DataTablde DE adminlte --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Facturas de los clientes de : {{ $agente->nombre }}</h3>
                    <div id="buttons"></div>
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
                                                style="">TOTAL
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
                                            <th rowspan="1" colspan="1">TOTAL</th>
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
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                    colspan="1" aria-label="Browser: activate to sort column ascending"
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
                                                <td style="">{{ $nagregado->nombre }}</td>
                                                <td style="">{{ $agente->nombre }}</td>
                                                <td style="">{{ $nagregado->servicio }}</td>
                                            @endforeach
                                            <tr>
                                            </tr>
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
                dom: 'B<"col-md-6 col-sm-12">frtip',
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
                        data: 'total'
                    },
                ],
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [
                    "copy", "csv", "excel", "pdf",
                ]
            });


        });

        $("#nagregados").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#nagregados_wrapper .col-md-6:eq(0)');
    </script>
@endsection
