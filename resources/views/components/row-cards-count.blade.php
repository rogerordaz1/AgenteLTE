<div class="row">

    <x-count-card count="{{ $countUser }}" text="Cantidad de Clientes" color="info"/>
   
    <x-count-card  text="Cantidad de Agentes" color="success"/>
   
    <x-count-card  text="Cantidad de Oficinas Comerciales" color="warning"/>
   
    <x-count-card count="{{ $roles }}" text="Cantidad de Roles" color="danger"/>
    
</div>
  <!-- /.row -->
