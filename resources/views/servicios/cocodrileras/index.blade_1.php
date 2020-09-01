@extends('layouts.master')

@section('css')
<!-- CSS SITE -->
<link href="{{ asset('css/site.css') }}" rel="stylesheet">
<style>
    .center {text-align: center;
    }
</style>
<!-- END CSS -->
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background: green;padding: 0px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Cocodrileras</h1>   
                    @if (session('status'))
                    <div class="alert alert-success text-white alert-dismissible fade show" role="alert">
                        <strong> {{ session('status') }} </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="{{ URL::to('home') }}" style="color:white;">Inicio</a></li>
                        <li class="breadcrumb-item active text-white">Cocodrileras</li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-12 text-center">
                    <input type="checkbox" id="myCheckId"> Id &nbsp;
                    <input type="checkbox" id="myCheck"> Nombre &nbsp;
                    <input type="checkbox" id="myCheckActiva"> Activa &nbsp;
                    <input type="checkbox" id="myCheckObs">   Observacion &nbsp;
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-12">
                    <!-- TABLE: USERS -->
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive"  >
                                <a class="btn btn-success border-white btn-sm addbutton"
                                   href="{{ URL::to('cocodrileras/create') }}"><i class="fa fa-plus"></i></a>


                                <table id="table_id" class="display dataTable table table-hover table-condensed" role="grid" aria-describedby="example_info">
                                    <thead>
                                        <tr>
                                            <th style="background: linear-gradient(to bottom, darkgreen,white);color:black"  >Id</th>
                                            <th  style="background: linear-gradient(to bottom,darkgreen,white);color:black" >Nombre</th>
                                            <th   style="background: linear-gradient(to bottom,darkgreen,white);color:black" >Activa</th>
                                            <th   style="background: linear-gradient(to bottom,darkgreen,white);color:black">Observaciones</th>
                                            <th class="mobilehide"  style="background: linear-gradient(to bottom,darkgreen,white);color:black">Creado</th>
                                            <th   style="background: linear-gradient(to bottom,darkgreen,white);color:black">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cocodrileras as $user)
                                        <tr id="trusers"  class="@php 
                                            if($user->activa==0) { echo e('rejected');}  @endphp">
                                            <td>
                                                <a href="{{ URL::to('cocodrileras/'. $user->id) }}"style="color:black">{{$user->id}}</a>
                                            </td>
                                            <td>
                                                <a href="{{ URL::to('cocodrileras/'. $user->id) }}"style="color:black">{{$user->name}}</a>
                                            </td>
                                            <td>
                                                <a href="{{ URL::to('cocodrileras/'. $user->id) }}"style="color:black">@php 
                                                    if($user->activa==1) { echo e('activa');} 
                                                    if($user->activa==0) { echo e('inactiva');}
                                                    @endphp</a>
                                            </td>
                                            <td>
                                                <a href="{{ URL::to('cocodrileras/'. $user->id) }}"style="color:black">{{$user->observaciones}}</a>
                                            </td>
                                            <td class="mobilehide">
                                                <a href="{{ URL::to('cocodrileras/'. $user->id) }}"style="color:black">{{$user->created_at}}</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-success border-white btn-sm editbutton"
                                                   href="{{ URL::to('cocodrileras/' . $user->id . '/edit') }}"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-sm btn-danger banbutton border-white"
                                                   href="{{ URL::to('cocodrileras/' . $user->id . '/ban') }}"
                                                   data-toggle="tooltip" title="Desactivar">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            </td>
                                        </tr>  
                                        @endforeach                                       
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">
                                                <select>
                                                    <option value=""></option>
                                                    @foreach($cocodrileras as $x => $provincia) 
                                                    <option value="{{$provincia->id}}">{{$provincia->name}}</option>
                                                    @endforeach
                                                </select> 
                                            </th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        
                    </div>
                </div>

            </div>
            <!-- /.row -->


        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('javascript')
<!-- jQuery -->
<script src="/dist/plugins/jquery/jquery.min.js"></script>
<!--jQuery UI 1.11.4--> 
<script src="/dist/plugins/jquery/jquery-ui.min.js"></script>
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
        /* $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
         $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
         });*/
        var oTable = $('#table_id').dataTable({
            /*  scrollY: 200,
             scrollCollapse: true,
             paging:         false,*/
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Elementos del _START_ al _END_ , de _TOTAL_ encontrados",
                "sInfoEmpty": "Elementos del 0 al 0 ,de 0 buscados",
                "sInfoFiltered": "( de un total de _MAX_ registros)",
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
            },
            "pageLength": 5,
            "autoWidth": true,
            "orderClasses": false,
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                        );
                                column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                            });
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option>' + d + '</option>')
                    });
                });
            }
        });
        $("input#myCheckId").click(function (event) {
            var checkBox = document.getElementById("myCheckId");
            if (checkBox.checked === false)
            {
                oTable.fnSetColumnVis(0, false);
            } else
            {
                oTable.fnSetColumnVis(0, true);
            }
        });
        $("input#myCheck").click(function (event) {
            var checkBox = document.getElementById("myCheck");
            if (checkBox.checked === false)
            {
                oTable.fnSetColumnVis(1, false);
            } else
            {
                oTable.fnSetColumnVis(1, true);
            }
        });
        $("input#myCheckActiva").click(function (event) {
            var checkBox = document.getElementById("myCheckActiva");
            if (checkBox.checked === false)
            {
                oTable.fnSetColumnVis(2, false);
            } else
            {
                oTable.fnSetColumnVis(2, true);
            }
        });
        $("input#myCheckObs").click(function (event) {
            var checkBox = document.getElementById("myCheckObs");
            if (checkBox.checked === false)
            {
                oTable.fnSetColumnVis(3, false);
            } else
            {
                oTable.fnSetColumnVis(3, true);
            }
        });
        oTable.fnSetColumnVis(0, false);
    }
    );

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
@stop