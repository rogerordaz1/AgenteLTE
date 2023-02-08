@extends('panel_admin')

@section('contenido')
    


    {{--  La DataTablde DE adminlte --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Clientes</h3>
                </div>

                <div class="card-body">
                    <div id="comerciales_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="comerciales" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending"> Id </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending"> Id OC
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Rendering engine: activate to sort column descending"> Servicio
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Sector</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Nombre</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Direccion</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Cuenta Bancaria</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                                style="">Fecha alta</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1" style="">ID</th>
                                            <th rowspan="1" colspan="1" style="">Id OC</th>
                                            <th rowspan="1" colspan="1" style="">Servicio</th>
                                            <th rowspan="1" colspan="1" style="">Sector</th>
                                            <th rowspan="1" colspan="1">Nombre</th>
                                            <th rowspan="1" colspan="1" style="">Direccion</th>
                                            <th rowspan="1" colspan="1" style="">Cuenta Bancaria</th>
                                            <th rowspan="1" colspan="1" style="">Fecha alta</th>
                                            
                                         

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
            $("#comerciales").DataTable({
                "ajax" : {
                   url : "{{ route('datatable.clientes') }}",
                   dataSrc: 'data'
                },
                "columns" : [
                    {data: 'id'},
                    {data: 'id_oficina_comercial'},
                    {data: 'servicio'},
                    {data: 'sector'},
                    {data: 'nombre'},
                    {data: 'direccion'},
                    {data: 'cuenta_bancaria'},
                    {data: 'fecha_alta'},
                ],



                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#comerciales_wrapper .col-md-6:eq(0)');

        });
    </script>
@endsection
