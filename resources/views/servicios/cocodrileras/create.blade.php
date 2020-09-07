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
    input[type=text] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 3px solid #ccc;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        outline: none;
    }

    input[type=text]:focus {
        border: 3px solid orange ;
    }
    input[type=number]:focus {
        border: 3px solid orange ;
    }
    textarea:focus {
        border: 3px solid orange ;
    }
    select:focus {
        border: 3px solid orange ;
    }
    #ueb_id:focus {
        border: 3px solid orange ;
    }
    /**/
    input[type=text], select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }
    label {
        font-size: 18px;
        padding: 12px 12px 12px 0;
        display: inline-block;
        color: black;
    }
    input[type=submit] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }
    input[type=submit]:hover {
        background-color:red;/* #01447e;*/
    }
    .col-15 {
        float: left;
        width: 15%;
        margin-top: 6px;
    }
    .col-75 {
        float: left;
        width: 75%;
        margin-top: 6px;
    }
    .row:after {
        content: "";
        display: table;
        clear: both;
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
    @media screen and (max-width: 600px) {
        .col-25, .col-75, input[type=submit] {
            width: 100%;
            margin-top: 0;
        }
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
        <div class="card1">
            <p><i class="fa fa-user"></i>Notas</p>
            <h3 id="explicacion"></h3>
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
    <div class="container">


        <form   method="post" action="{{url('/cocodrileras')}}" id="cocodrilera-form">
            {{ csrf_field() }}   
            <div class="form-group row">
                <div class="col-15">
                    <label for="name">Nombre</label>
                </div>
                <div class="col-75">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required unique:cocodrileras maxlength="100" autofocus 
                           onclick="document.getElementById('explicacion').innerHTML='Aqui se escribe el nombre de la Cocodrilera';">
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>    
            </div>    

            <div class="form-group row">
                <div class="col-15">    <label for="name">Capacidad</label></div>
                <div class="col-75"> <input id="capacidad" type="number" class="form-control{{ $errors->has('capacidad') ? ' is-invalid' : '' }}" 
                                            name="capacidad" value="{{ old('capacidad') }}" min="1" max="100" required autofocus step="1"
                                            onclick="document.getElementById('explicacion').innerHTML='Aqui se escribe la Capacidad de la Cocodrilera';"
                                            onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)">
                    @if ($errors->has('capacidad'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('capacidad') }}</strong>
                    </span>
                    @endif
                </div>  
            </div>  

            <div class="form-group row">                                            
                <div class="col-15">  <label for="ueb_id">Ueb</label></div>
                <div class="col-75">  <a class="btn btn-success border-white btn-sm"
                                         href="{{ URL::to('uebs/create') }}"><i class="fa fa-plus"></i>
                    </a>
                    <select id="ueb_id" class="form-control{{ $errors->has('ueb_id') ? ' is-invalid' : '' }}" name="ueb_id" value="{{ old('ueb_id') }}" required autofocus
                            onclick="document.getElementById('explicacion').innerHTML='Aqui se selecciona la UEB de la Cocodrilera';">
                        <option value="">Escoje...</option>
                         @foreach($uebs as $x => $ueb) 
                                        <option value="{{$ueb->id}}">{{$ueb->name}}</option>
                                        @endforeach
                    </select>  
                    @if ($errors->has('ueb_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('ueb_id') }}</strong>
                    </span>
                    @endif
                </div>    
            </div>    

            <div class="form-group row">
                <div class="col-15"><label for="observaciones"  >Observaciones</label></div>
                <div class="col-75"><input id="observaciones" type="text" class="form-control{{ $errors->has('observaciones') ? ' is-invalid' : '' }}" name="observaciones" value="{{ old('observaciones') }}"
                                           onclick="document.getElementById('explicacion').innerHTML='Aqui se escribe la Observaciones';">
                    @if ($errors->has('observaciones'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('observaciones') }}</strong>
                    </span>
                    @endif
                </div>
            </div>


        </form>
        <div class="col-15"></div><div class="col-75">
            <a id="fb1" class="btn btn-outline-success" href="/home"
               onclick="event.preventDefault();document.getElementById('cocodrilera-form').submit();
               "><i class="fa fa-thumbs-up"></i>
                Crear un Nuevo Cocodrilera</a>
        </div>
    </div>
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
                                               .done(function (data) {
                                                   document.getElementById("side_nombre").innerHTML = data[0].name;
                                                   //  alert("success");
                                                   console.log(data);
                                               })
                                               .fail(function () {
                                                   alert("error");
                                               })
                                               .always(function () {
                                                   alert("complete");
                                               });
                                   }
</script>
@endsection
