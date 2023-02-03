@extends('layouts.adminlte')

@section('title', 'Roger')

@section('body')

    <div class="wrapper">



        @include('componentes.navbar')

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            @include('componentes.sidebar_top')


            <!-- Sidebar -->
            @include('componentes.sidebar')
            <!-- /.sidebar -->


            
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-4">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    

                    <x-row-cards-count/>

                    @yield('contenido')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            
            <!-- Default to the left -->
            <strong>Copyright &copy; 2023 <a href="/">Etecsa</a>.</strong> Todos los derechos reservados.
        </footer>
    </div>
    <!-- ./wrapper -->
   
@endsection


@section('css')
    @yield('css')
@endsection

@section('js')
    @yield('js')
@endsection