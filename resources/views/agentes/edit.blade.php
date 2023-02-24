@extends('panel_admin')

@section('contenido')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Editar Agente</h3>
                </div>
                <div class="card-body">
                    <form class="pb-5" action="{{ route('dashboard.agentes.update', $agente) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="cliente">Seleccione un cliente: (Por Servicio)</label>
                            <select class="form-control" data-ajax-url="{{ route('dashboard.select.clientes') }}"
                                name="servicio" id="servicio">


                            </select>

                        </div>
                        <button type="submit" class="btn btn-info btn-sm">Agregar</button>
                        <a href="{{route('dashboard.agentes.show' , $agente)}}" class="btn btn-secondary btn-sm">Cancelar</a>

                    </form>

                </div>

            </div>

        </div>
        <div class="col-md-3"></div>
    </div>
@endsection

@section('css')
    <style>
        .select2-selection__rendered {
            line-height: normal !important;
        }
    </style>
@endsection


@section('js')
    <script>
        $(document).ready(function() {

            var miselect = $('#servicio').select2({
                ajax: {
                    url: $(this).data('ajax-url'),
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            servicio: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results.map(function(cliente) {
                                return {
                                    id: cliente.id,
                                    text: cliente.nombre + ' ' + cliente.servicio
                                };
                            })
                        };
                    },
                    cache: true
                },

                placeholder: 'Selecciona el cliente a agregar',
                minimumInputLength: 1,

            });


            $.ajax({
                url: '{{ route('dashboard.select.clientes') }}',
                dataType: 'json',
                success: function(data) {
                    $.each(data.results, function(index, value) {

                        miselect.append('<option value="' + value.id + '">' + value.nombre +
                            ' ' + value.servicio + '</option>');

                    });
                }
            });
        });
    </script>
@endsection
