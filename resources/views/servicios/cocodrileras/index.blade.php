@extends('layouts.appOFF')

@section('localcss')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<style>
    .progress-container {width: 100%;height: 8px;background: #ccc;}
    .progress-bar {height: 8px;background: #4caf50;width: 0%;}
</style>
@endsection

@section('content')
<div class="main">

    <table id="table_id" class="display dataTable table table-hover table-condensed" role="grid" aria-describedby="example_info">
        <thead>
            <tr>
                <th style="background: linear-gradient(to bottom, green,white);color:black"  >Id</th>
                <th  style="background: linear-gradient(to bottom,green,white);color:black" >Nombre</th>
                <th   style="background: linear-gradient(to bottom,green,white);color:black" >Activa</th>
                <th   style="background: linear-gradient(to bottom,green,white);color:black">Observaciones</th>
                <th class="mobilehide"  style="background: linear-gradient(to bottom,green,white);color:black">Creado</th>
                <th   style="background: linear-gradient(to bottom,green,white);color:black">Accion</th>
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

@endsection

@section('localscript')
<script src="{{ asset('js/datatables.min.js') }}" defer></script>
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
    
        var oTable = $('#table_id').dataTable({});
   

</script>
@endsection
