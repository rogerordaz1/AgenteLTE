@extends('panel_admin')

@section('contenido')
    {{--  La DataTablde DE adminlte --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Agentes</h3>
                    <div class="d-flex justify-content-end datatable-buttons"></div>

                </div>
                <div class="card-body">
                    <div id="agentes_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="agentes" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <td>

                                                <select data-column="0" class="form-control filter-input" id="filtro">
                                                    <option value="">Seleciona la Oficina</option>
                                                    @foreach ($ocomerciales as $oficina)
                                                        <option value="{{ $oficina->nombre }}"> {{ $oficina->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
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
                                                aria-label="Rendering engine: activate to sort column descending"> Creado
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending">
                                                Modificado
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending"> Ver
                                                Clientes
                                            </th>

                                        </tr>

                                    </thead>
                                    <tfoot>
                                        <tr>

                                            <th rowspan="1" colspan="1">Oficina</th>
                                            <th rowspan="1" colspan="1">Nombre</th>
                                            <th rowspan="1" colspan="1">Creado</th>
                                            <th rowspan="1" colspan="1">Modificado</th>
                                            <th rowspan="1" colspan="1">Ver Clientes</th>
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

            let table = $("#agentes").DataTable({
                dom: "B<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "{{ route('datatable.agentes') }}",
                    dataSrc: 'data'
                },
                columns: [

                    {
                        data: 'oficina_nombre'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'created_at_diff'
                    },
                    {
                        data: 'updated_at_diff'
                    },
                    {
                        data: 'show_clients'
                    },
                ],
                responsive: true,
                autoWidth: false,
                buttons: [{
                        extend: 'pdf',
                        text: 'PDF',
                        titleAttr: 'Exportar a PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3]

                        },
                        className: 'btn btn-warning btn-sm mr-1'
                    },
                    {
                        extend: 'excel',
                        text: 'Exel',
                        titleAttr: 'Exportar a EXEL',
                        exportOptions: {
                            columns: [0, 1, 2, 3]

                        },
                        className: 'btn btn-warning btn-sm mr-1'
                    },
                    {
                        extend: 'copy',
                        text: 'Copiar',
                        titleAttr: 'Copiar el Contenido',
                        exportOptions: {
                            columns: [0, 1, 2, 3]

                        },
                        className: 'btn btn-warning btn-sm mr-1'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        titleAttr: 'Exportar a CSV',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-warning btn-sm mr-1'
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

                }
            });

            table.buttons().container().appendTo($('.datatable-buttons'));

            $('#filtro').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });
        });
    </script>
@endsection
