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
    input[type=text] {
        width: 100%;
        /*padding: 12px 20px;*/
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
    #cocodrilera_id:focus {
        border: 3px solid orange ;
    }
    #mercado_id:focus {
        border: 3px solid orange ;
    }
    #nac_id:focus {
        border: 3px solid orange ;
    }
    #plan:focus {
        border: 3px solid orange ;
    }
    #activa:focus {
        border: 3px solid orange ;
    }
    /**/
    input[type=text], select, textarea {
        width: 100%;
        /* padding: 12px;*/
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }
    label {
        font-size: 18px;
        margin-top: 6px;
        /*  padding: 12px 12px 12px 0;*/
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
    }
    .col-75 {
        float: left;
        width: 75%;
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
        .col-15,.col-25, .col-75, input[type=submit] {
            width: 100%;
            margin-top: 0;
            margin-bottom: 0;
        }
        .label,.form-group{
            margin-top: 0;
            margin-bottom: 0;
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
    <div id="visible1">
        <i class="fas fa-spinner fa-spin"></i>
        <i class="fas fa-circle-notch fa-spin"></i>
        <i class="fas fa-sync-alt fa-spin"></i>
        <i class="fas fa-sync fa-spin"></i>
        <i class="fas fa-cog fa-spin"></i>
        <i class="fas fa-cog fa-pulse"></i>
        <i class="fas fa-spinner fa-pulse"></i>
    </div>
    <button onclick="document.getElementById('visible1').style.display = 'none';">On</button>

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


        <form   method="post" action="{{url('/rcocodrileras')}}" id="rcocodrilera-form">
            {{ csrf_field() }}       
            <div class="form-group row">
                <div class="col-15"> <label for="name">Localizador</label></div>

                <div class="col-75">  <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required unique:rcocodrileras maxlength="100" autofocus>
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div> 
            </div> 
            <div class="form-group row">   
                <div class="col-15"> <label for="cocodrilera_id">Cocodrilera</label></div>
                <div class="col-75 btn-group"> 

                    <a class="btn btn-success border-white btn-sm"  style="height:30px;"
                       href="{{ URL::to('cocodrileras/create') }}"><i class="fa fa-plus"></i>
                    </a>
                    <select  style="height:30px;" id="cocodrilera_id" class="form-control{{ $errors->has('cocodrilera_id') ? ' is-invalid' : '' }}" name="cocodrilera_id" value="{{ old('cocodrilera_id') }}" required autofocus>
                        <option value="">Escoje...</option>
                        @foreach($cocodrileras as $x => $cocodrilera) 
                        <option value="{{$cocodrilera->id}}">{{$cocodrilera->name}}</option>
                        @endforeach
                    </select>  
                    @if ($errors->has('cocodrilera_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('cocodrilera_id') }}</strong>
                    </span>
                    @endif                              
                </div>                                     
            </div>                                     

            <div class="form-group row">                                            
                <div class="col-15"><label for="mercado_id">Mercado</label></div>
                <div class="col-75 btn-group" role="group"> <a class="btn btn-success border-white btn-sm" 
                                                               style="height:30px;" href="{{ URL::to('mercados/create') }}"><i class="fa fa-plus"></i>
                    </a>
                    <select style="height:30px;" id="mercado_id" class="form-control{{ $errors->has('mercado_id') ? ' is-invalid' : '' }}" name="mercado_id" value="{{ old('mercado_id') }}" required autofocus>
                        <option value="">Escoje...</option>
                        @foreach($mercados as $x => $mercado) 
                        <option value="{{$mercado->id}}">{{$mercado->name}}</option>
                        @endforeach
                    </select>  
                    @if ($errors->has('mercado_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('mercado_id') }}</strong>
                    </span>
                    @endif
                </div> 
            </div> 
            <div class="form-group row">
                <div class="col-15"><label for="total_pax">Total_pax</label></div>
                <div class="col-75"> <input id="total_pax" type="number" class="form-control{{ $errors->has('total_pax') ? ' is-invalid' : '' }}" 
                                            name="total_pax" value="{{ old('total_pax') }}" min="1" max="100" required autofocus step="1"
                                            onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)">
                    @if ($errors->has('total_pax'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('total_pax') }}</strong>
                    </span>
                    @endif
                </div>  
            </div>  
            <div class="form-group row">                                            
                <div class="col-15">  <label for="nac_id">Nacionalidad</label></div>
                <div class="col-75 btn-group" role="group">  <a class="btn btn-success border-white btn-sm" style="height:30px;"
                                                                href="{{ URL::to('nacs/create') }}"><i class="fa fa-plus"></i>
                    </a>
                    <select style="height:30px;" id="nac_id" class="form-control{{ $errors->has('nac_id') ? ' is-invalid' : '' }}" name="nac_id" value="{{ old('nac_id') }}" required autofocus>
                        <option value="">Escoje...</option>
                        @foreach($nacs as $x => $nac) 
                        <option value="{{$nac->id}}">{{$nac->name}}</option>
                        @endforeach
                    </select>  
                    @if ($errors->has('nac_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nac_id') }}</strong>
                    </span>
                    @endif

                </div> 
            </div> 
            <div class="form-group row">
                <div class="col-15"> <label for="activa"  >Plan</label></div>
                <div class="col-75">     <select id="plan"  class="form-control{{ $errors->has('plan') ? ' is-invalid' : '' }}" name="plan" value="{{ old('plan') }}" required autofocus>
                        <option value="">Escoje...</option>
                        <option value="0">No Plan</option>
                        <option value="1">(AP)</option>
                        <option value="2">(MAP)</option>
                        <option value="3">(EP)</option>
                        <option value="4">(CP)</option>
                        <option value="5">Todo Incluido</option>                                        
                        <option value="6">Desayuno</option>                                        
                        <option value="7">Merienda</option>                                        
                        <option value="8">Almuerzo</option>                                        
                        <option value="9">Comida</option>                                        
                        <option value="10">Desayuno,Merienda</option>                                        
                        <option value="11">Desayuno,Almuerzo</option>                                        
                        <option value="12">Desayuno,Comida</option>                                        
                        <option value="13">Desy.,Almz.,Comd</option>                                        
                        <option value="14">Merienda,Almuerzo</option>                                        
                        <option value="15">Merienda,Comida</option>                                        
                        <option value="16">Almuerzo,Comida</option>                                         
                    </select>  
                    @if ($errors->has('plan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('plan') }}</strong>
                    </span>
                    @endif
                </div> 
            </div> 
            <div class="form-group row">
                <div class="col-15"><label for="fecha_entrada">Fecha_entrada</label></div>
                <div class="col-75">   <input id="fecha_entrada" type="date" class="form-control{{ $errors->has('fecha_entrada') ? ' is-invalid' : '' }}" name="fecha_entrada" value="{{ old('fecha_entrada') }}" required autofocus>
                    @if ($errors->has('fecha_entrada'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('fecha_entrada') }}</strong>
                    </span>
                    @endif
                </div>  
            </div>  
            <div class="form-group row">
                <div class="col-15"><label for="fecha_salida">Fecha_salida</label></div>
                <div class="col-75">  <input id="fecha_salida" type="date" class="form-control{{ $errors->has('fecha_salida') ? ' is-invalid' : '' }}" name="fecha_salida" value="{{ old('fecha_salida') }}" required autofocus>
                    @if ($errors->has('fecha_salida'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('fecha_salida') }}</strong>
                    </span>
                    @endif
                </div>  
            </div>  
            <div class="form-group row">
                <div class="col-15">  <label for="activa"  >Activa</label></div>
                <div class="col-75"> <select id="activa"  class="form-control{{ $errors->has('activa') ? ' is-invalid' : '' }}" name="activa" value="{{ old('activa') }}" required autofocus>
                        <option value="">Escoje...</option>                                                   
                        <option value="1">Sí</option>
                        <option value="0">No</option>                                                    
                    </select>  
                    @if ($errors->has('activa'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('activa') }}</strong>
                    </span>
                    @endif
                </div> 
            </div> 
            <div class="form-group row">
                <div class="col-15"><label for="observaciones"  >Observaciones</label></div>
                <div class="col-75"> <input id="observaciones" type="text" class="form-control{{ $errors->has('observaciones') ? ' is-invalid' : '' }}" name="observaciones" value="{{ old('observaciones') }}">
                    @if ($errors->has('observaciones'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('observaciones') }}</strong>
                    </span>
                    @endif
                </div> 
            </div> 
        </form>
        <a id="fb1" class="btn btn-outline-success" href="/home"
           onclick="event.preventDefault();
                       if (validateForm()){
               document.getElementById('rcocodrilera-form').submit(); }
           ">
            Crear una nueva Reserva de Cocodrilera</a>


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

               /*Chequeo completo de todo por JS antes de hacer submit*/
               function validateForm() {
                   var nameForm = document.getElementById('name').value;
                   var cocodrileraForm = document.getElementById('cocodrilera_id').value;
                   var mercadoForm = document.getElementById('mercado_id').value;
                   var totalForm = document.getElementById('total_pax').value;
                   var nacForm = document.getElementById('nac_id').value;
                   var planForm = document.getElementById('plan').value;
                   var fechaEForm = document.getElementById('fecha_entrada').value;
                   var fechaSForm = document.getElementById('fecha_salida').value;
                   var activaForm = document.getElementById('activa').value;
                   var observacionesForm = document.getElementById('observaciones').value;
                   console.log(nameForm);
                   console.log(cocodrileraForm);
                   console.log(mercadoForm);
                   console.log(totalForm);
                   console.log(nacForm);
                   console.log(planForm);
                   console.log(fechaEForm);
                   console.log(fechaSForm);
                   console.log(activaForm);
                   if (cumpleTODO(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm)) {
                       return false;
                   }
                   return false;
               }
               function cumpleTODO(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm) {
                   var todo = false;
                   if (EstanLLenosLosComponentes(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm))
                   {
                       todo = true;
                   }
                   return todo;
               }
               function EstanLLenosLosComponentes(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm) {
                   if (nameForm == "" ||
                           cocodrileraForm == "" ||
                           mercadoForm == "" ||
                           totalForm == "" ||
                           nacForm == "" ||
                           planForm == "" ||
                           fechaEForm == "" ||
                           fechaSForm == "" ||
                           activaForm == ""
                           )
                   {
                       console.log('hay Campos Vacios');
                       return false;
                   }
                   return true;
               }
</script>
@endsection
