@extends('layouts.master')

@section('css')
<!-- CSS SITE -->
<link href="{{ asset('css/site.css') }}" rel="stylesheet">
<style>
    #showbtn{
        color: green;
        font-size: 20px;
    }
    </style>
<!-- END CSS -->
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #003300">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Detalles de esta Cocodrilera</h1>

                  
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/cocodrileras">Cocodrileras</a></li>
                        <li class="breadcrumb-item active text-white">{{$cocodrilera->name}}</li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-12"> <br/> </div>

                <div class="input-group mb-3 input-group-lg">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" disabled>ID</button>                        
                    </div>
                    <span  class="input-group-text text-black bg-success">
                       {{$cocodrilera->id}}
                    </span>
                </div>
                <div class="input-group mb-3 input-group-lg">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" disabled>Activa</button>                        
                    </div>
                    <span  class="input-group-text text-black bg-success">
                        <?php if ($cocodrilera->activa == '1') {
                            echo e('Si');
                        } else {
                            echo e('No');
                        } ?>
                    </span>
                </div>
                <div class="input-group mb-3 input-group-lg">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" disabled>Nombre</button>                        
                    </div>
                    <span  class="input-group-text text-black bg-success">
                        {{$cocodrilera->name}}
                    </span>
                </div>
                <div class="input-group mb-3 input-group-lg">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" disabled>Fecha/Creado</button>                        
                    </div>
                    <span  class="input-group-text text-black bg-success">
                        {{$cocodrilera->created_at}}
                    </span>
                </div>
                <div class="input-group mb-3 input-group-lg">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" disabled>Observaciones</button>                        
                    </div>
                    <span  class="input-group-text text-black bg-success">
                        <?php if ($cocodrilera->observaciones != null) {
                            echo e($cocodrilera->observaciones);
                        } else {
                            echo e('No existen observaciones');
                        } ?>
                    </span>
                </div>
                
                
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

</div>
<!-- /.content-wrapper -->
@endsection

@section('javascript')
<!-- jQuery -->
<script src="/dist/plugins/jquery/jquery.min.js"></script>
<!--jQuery UI 1.11.4 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>-->
<!-- Bootstrap 4 -->
<script src="/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Sparkline -->
<script src="/dist/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- Slimscroll -->
<script src="/dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.2 -->
<script src="/dist/plugins/chartjs-old/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- DATATABLE -->
<script src="{{ asset('js/datatables.js') }}" defer></script>

<script>
    $(document).ready(function () {
        $('#table_id').dataTable({
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Filtrar :",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
@stop