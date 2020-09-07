@extends('layouts.appOFF')

@section('localcss')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
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
</style>
@endsection

@section('content-left')
<div class="side" style="padding: 10px 10px;">
    <ul class="breadcrumb">
        <li><a href="home">Inicio</a></li>
        <li><a href="cocodrileras">Cocodrileras</a></li>
        <li><a href="cocodrileras/create">Nueva</a></li>
    </ul>
    <div class="fakeimg" style="height:60px;">Image</div><br>   
    <h2 id="side_nombre">Nombre</h2><i class="fa fa-home"></i>
    <h5>Photo of me:</h5>
    <div class="fakeimg" style="height:200px;">Image</div>
    <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
    <h3>More Text</h3>
    <p>Lorem ipsum dolor sit ame.</p>
    <div class="fakeimg" style="height:60px;">Image</div><br>
    <div class="fakeimg" style="height:60px;">Image</div><br>
</div>
@endsection

@section('content')
<div class="main">

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
                    <button onclick="var id = {{$user->id}}; DTVerDatos(id);">Ok</button>
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
                                document.getElementById("side_nombre").innerHTML = data[0].name;
                                //  alert("success");
                                console.log(data);
                                })
                                .fail(function() {
                                alert("error");
                                })
                                .always(function() {
                                alert("complete");
                                });
                        }
</script>
@endsection
