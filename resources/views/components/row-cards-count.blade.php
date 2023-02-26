<div class="row">
    <x-count-card count="{{ $clientes }}" text="Cantidad de Clientes" color="info" link="{{ route('dashboard.clientes.index') }}"/>

    <x-count-card count="{{ $facturas }}" text="Cantidad de facturas" color="warning" link="{{ route('dashboard.ocomerciales.index') }}"/>

    <x-count-card count="{{ $agentes }}" text="Cantidad de Agentes" color="info" link="{{ route('dashboard.users.index') }}" />

    <x-count-card count="{{ $countUser }}" text="Cantidad de Usuarios" color="warning" link="{{ route('dashboard.users.index') }}"/>

</div>
  <!-- /.row -->
