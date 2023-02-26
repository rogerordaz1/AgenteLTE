<div class="row">
    <x-custom-card
     count="{{ $ocomerciales }}"
     text="Cantidad de Oficinas Comerciales"
     color="navy"
     icon="fas fa-landmark"


     />

    <x-custom-card
    count="{{ $roles }}"
    text="Cantidad de roles"
    color="navy"
    icon="fas fa-user-shield"

    />

    <x-custom-card
    count="${{ number_format($totalFactutas , 2 ,',', '.') }}"
    text="Total de Recaudar"
    color="navy"
    icon="fas fa-dollar-sign"

    />

    <x-custom-card
    count="${{ number_format($totalAtraso , 2 ,',', '.') }}"
    text="Total de Atraso de los Clientes"
    color="navy"
    icon="fas fa-dollar-sign"
    />

</div>
  <!-- /.row -->
