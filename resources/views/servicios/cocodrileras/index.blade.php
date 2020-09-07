@extends('layouts.appOFF')

@section('localcss')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/hover-min.css') }}" rel="stylesheet">
<style>
    .progress-container {width: 100%;height: 8px;background: #ccc;}
    .progress-bar {height: 8px;background: #4caf50;width: 0%;}
    ul.breadcrumb {
        padding: 10px 16px;
        list-style: none;
        background-color: #eee;
    }
    ul.breadcrumb li {
        display: inline;
        font-size: 18px;
    }
    ul.breadcrumb li+li:before {
        padding: 8px;
        color: black;
        content: "/\00a0";
    }
    ul.breadcrumb li a {
        color: #0275d8;
        text-decoration: none;
    }
    ul.breadcrumb li a:hover {
        color: #01447e;
        text-decoration: underline;
    }
    .hvr-radial-out{
        display:inline-block;vertical-align:middle;-webkit-transform:perspective(1px) translateZ(0);transform:perspective(1px) translateZ(0);box-shadow:0 0 1px rgba(0,0,0,0);position:relative;overflow:hidden;background:green;-webkit-transition-property:color;transition-property:color;-webkit-transition-duration:.3s;transition-duration:.3s
    }
    .card1 {
        display: flex;
        flex-direction: column;
        min-width: 100px;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }
    .hvr-sweep-to-right{width:100%;display:inline-block;vertical-align:middle;-webkit-transform:perspective(1px) translateZ(0);transform:perspective(1px) translateZ(0);box-shadow:0 0 1px rgba(0,0,0,0);position:relative;-webkit-transition-property:color;transition-property:color;-webkit-transition-duration:.3s;transition-duration:.3s}
    .hvr-sweep-to-right:before{content:"";position:absolute;z-index:-1;top:0;left:0;right:0;bottom:0;background:#2098D1;-webkit-transform:scaleX(0);transform:scaleX(0);-webkit-transform-origin:0 50%;transform-origin:0 50%;-webkit-transition-property:transform;transition-property:transform;-webkit-transition-duration:.3s;transition-duration:.3s;-webkit-transition-timing-function:ease-out;transition-timing-function:ease-out}
    .hvr-sweep-to-right:active,
    .hvr-sweep-to-right:focus,
    .hvr-sweep-to-right:hover{color:#fff}
    .hvr-sweep-to-right:active:before,
    .hvr-sweep-to-right:focus:before,
    .hvr-sweep-to-right:hover:before{-webkit-transform:scaleX(1);transform:scaleX(1)}
    
    .mystyle{
        width: 100%;
        padding: 25px;
        background-color: #d4edda;
        color: black;
        font-size: 25px;
    }
    
</style>
@endsection

@section('content-left')
<div class="side" style="padding: 10px 10px;background-color: orange">
    <ul class="breadcrumb">
        <li><a href="home">Inicio</a></li>
        <li><a href="cocodrileras">Cocodrileras</a></li>
        <li><a href="cocodrileras/create">Nueva</a></li>
    </ul>
    <div class="column">
        <div id="myDIV" class="card1">
            <p><i class="fa fa-user"></i>Notas</p>
            <h3 id="side_nombre"></h3>
        </div>
    </div>

    <a href="/rcocodrileras" class="btn"><i class="fa fa-user"></i>
        Volver a Reserva Cocodrileras
    </a>
    <a href="/mixtas" class="btn"> <i class="fa fa-user"></i>Volver a ReservaMixtas<i class="fa fa-cubes" aria-hidden="true"></i>
    </a>





</div>
@endsection

@section('content')
<div class="main" style="padding: 10px 10px; background-color: #d4edda;">

    <table id="cocodrileraDT" class="display dataTable table table-hover table-condensed" role="grid" aria-describedby="example_info">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Activa</th>
                <th>Observaciones</th>
                <th>Creado</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($cocodrileras as $user)
            <tr id="trusers"  class="@php if($user->activa==0) { echo e('rejected');}  @endphp">
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
                    <a class="btn btn-sm btn-success border-white btn-sm editbutton"
                       href="{{ URL::to('cocodrileras/' . $user->id . '/edit') }}"><i class="fa fa-home"></i></a>
                    <a class="btn btn-sm btn-danger banbutton border-white"
                       href="{{ URL::to('cocodrileras/' . $user->id . '/ban') }}"
                       data-toggle="tooltip" title="Desactivar">
                        <i class="fa fa-ban"></i>
                    </a>
                    <button  style="background-color: orange;" onclick="var id = {{$user->id}}; DTVerDatos(id);"> <i class="fa fa-eye"></i></button>
                </td>
            </tr>  
            @endforeach   


        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Activa</th>
                <th>Observaciones</th>
                <th>Creado</th>
                <th>Accion</th>
            </tr>
        </tfoot>
    </table>

    <a href="#" class="hvr-grow">Add to Basket</a>
</div>

@endsection

@section('localscript')
<script src="{{ asset('js/jquery-3.5.1.js') }}" ></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script>
                        window.onscroll = function () {
                        myFunction()
                        };
                        function myFunction() {
                        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                        var scrolled = (winScroll / height) * 100;
                        document.getElementById("myBar").style.width = scrolled + "%";
                        }

                        var Dtable = $('#cocodrileraDT').dataTable({

                        });
                        function DTVerDatos(Elem) {
                        var children = "/cocodrilera/".concat(Elem);
                        console.log(children);
                        var jqxhr = $.ajax(children)
                                .done(function(data) {

                                document.getElementById("side_nombre").innerHTML = data[Elem-1].name;
                                var element = document.getElementById("myDIV");
                                element.classList.toggle("mystyle");
                                console.log(data);
                             
                                })
                                .fail(function() {
                                alert("error");
                                })
                                .always(function() {
                              
                                });
                        }
</script>
@endsection
