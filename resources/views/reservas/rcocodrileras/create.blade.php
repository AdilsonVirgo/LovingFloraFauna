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
    #agencia_id:focus {
        border: 3px solid orange ;
    }
    #nac_id:focus {
        border: 3px solid orange ;
    }
    #plan:focus {
        border: 3px solid orange ;
    }
    #adultos:focus {
        border: 3px solid orange ;
    }
    #menores:focus {
        border: 3px solid orange ;
    }
    #activa:focus {
        border: 3px solid orange ;
    }
    input[type=number]:focus{
        border: 3px solid orange ;
    }
    input[type=number]:active{
        border: 3px solid orange ;
    }
    input[type=number]:after{
        border: 3px solid orange ;
    }
    input[type=number]:hover{
        border: 3px solid orange ;
    }
    input[type=number]{
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
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
    .col-20 {
        float: left;
        width: 20%;
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
        .col-15,.col-20,.col-25, .col-75, input[type=submit] {
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
        <li><a href="{{route('home')}}">Inicio</a></li>
        <li><a href="{{route('rcocodrileras.index')}}">Reservas</a></li>
        <li><a href="{{route('rcocodrileras.create')}}">Nueva</a></li>
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
    <div>
        <h6 id="resultadoTotal" style="display:none;">false</h6>
        <div id="totalMaximo" style="display:none;"></div>
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
<div class="main" style="padding: 5px 5px; background-color: #d4edda;">
    <form   method="GET" action="{{url('/tengo')}}" id="rcocodrilera-form">
        {{ csrf_field() }}       

        <div class="row">

            <div class="col-md-4" style="position:unset;">
                <div class="row m-1"><label for="name" class="m-1">Localizador</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class=" m-1" required unique:rcocodrileras maxlength="100" autofocus style="height:30px;"/>
                </div>
                <div class="row m-1"><label for="cocodrilera_id" class="m-1">Cocodrilera</label>
                    <a class="btn btn-success border-white btn-sm"  href="{{ URL::to('cocodrileras/create') }}"><i class="fa fa-plus"></i></a>
                    <select id="cocodrilera_id" class="m-1" name="cocodrilera_id" value="{{ old('cocodrilera_id') }}" required autofocus  style="height:30px;">
                        <option value="">Escoje...</option>@foreach($cocodrileras as $x => $cocodrilera) <option value="{{$cocodrilera->id}}">{{$cocodrilera->name}}</option>@endforeach
                    </select>
                </div>

            </div>
            <div class="col-md-4" style="position:unset;">
                <div class="row m-1"><label for="plan" class="m-1">Plan</label>
                    <select id="plan"  class="m-1" name="plan" value="{{ old('plan') }}" required autofocus style="height:30px;">
                        <option value="">Escoje...</option><option value="0">No Plan</option><option value="1">(AP)</option><option value="2">(MAP)</option><option value="3">(EP)</option><option value="4">(CP)</option><option value="5">Todo Incluido</option><option value="6">Desayuno</option>                                        
                        <option value="7">Merienda</option><option value="8">Almuerzo</option><option value="9">Comida</option><option value="10">Desayuno,Merienda</option><option value="11">Desayuno,Almuerzo</option><option value="12">Desayuno,Comida</option>                                        
                        <option value="13">Desy.,Almz.,Comd</option><option value="14">Merienda,Almuerzo</option><option value="15">Merienda,Comida</option><option value="16">Almuerzo,Comida</option>                                         
                    </select>  
                </div>

                <div class="row m-1"><label for="mercado_id" class="m-1">Mercado</label>
                    <a class="btn btn-success border-white btn-sm" href="{{ URL::to('mercados/create') }}"><i class="fa fa-plus"></i></a>
                    <select  id="mercado_id" class="m-1" name="mercado_id" value="{{ old('mercado_id') }}" required autofocus  style="height:30px;">
                        <option value="">Escoje...</option>@foreach($mercados as $x => $mercado) <option value="{{$mercado->id}}">{{$mercado->name}}</option>@endforeach
                    </select>  
                </div> 

            </div>
            <div class="col-md-4" style="position:unset;">
                <div class="row m-1"><label for="agencia_id" class="m-1">Agencia</label>
                    <select id="agencia_id" class="m-1" name="agencia_id" value="{{ old('agencia_id') }}" required autofocus  style="height:30px;">
                        <option value="">Escoje...</option>@foreach($agencias as $x => $agencia)<option value="{{$agencia->id}}">{{$agencia->name}}</option>@endforeach
                    </select>  
                </div>
                <!--            <div class="row m-1"><label for="adultos" class="m-1">Adultos</label>
                                <input id="adultos" type="text" name="adultos" value="{{ old('adultos') }}" class=" m-1" required maxlength="3" autofocus style="height:30px;" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)"/>
                            </div>-->
                <div class="row m-1"><label for="nac_id" class="m-1">Nacionalidad</label>
                    <a class="btn btn-success border-white btn-sm" href="{{ URL::to('nacs/create') }}"><i class="fa fa-plus"></i></a>
                    <select id="nac_id" class="m-1" name="nac_id" value="{{ old('nac_id') }}" required autofocus style="height:30px;">
                        <option value="">Escoje...</option>@foreach($nacs as $x => $nac)<option value="{{$nac->id}}">{{$nac->name}}</option>@endforeach
                    </select>  
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4 " style="position:unset;">
                <div class="row m-1"><label for="adultos" class="m-1">Adultos</label>
                    <input id="adultos" type="text" name="adultos" value="{{ old('adultos') }}" class=" m-1" required  maxlength="3" autofocus style="height:30px;" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)"/>
                </div>
            </div>
            <div class="col-md-4 " style="position:unset;">
                <div class="row m-1"><label for="menores" class="m-1">Menores</label>
                    <input id="menores" type="text" name="menores" value="{{ old('menores') }}" class=" m-1" required  maxlength="3" autofocus style="height:30px;" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)"/>
                </div>
            </div>
            <div class="col-md-4 " style="position:unset;">            
                <div class="row m-1"><label for="total_pax" class="m-1">Total Pax</label>
                    <input id="total_pax" type="text" name="total_pax" value="{{ old('total_pax') }}" class=" m-1" required maxlength="3" autofocus style="height:30px;" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)"/>
                </div>
            </div>
        </div>

        <div class="row"> 
            <div class="col-md-4 " style="position:unset;">
                <div class="row m-1"><label for="fecha_entrada" class="m-1">Fecha Entrada</label>
                    <input id="fecha_entrada" type="date" class="m-1" style="width: 100%" name="fecha_entrada" value="{{ old('fecha_entrada') }}" required autofocus style="height:30px;"> 
                </div>
            </div>
            <div class="col-md-4 " style="position:unset;">
                <div class="row m-1"><label for="fecha_salida" class="m-1">Fecha Salida</label>
                    <input id="fecha_salida" type="date" class="m-1" style="width: 100%" name="fecha_salida" value="{{ old('fecha_salida') }}" required autofocus style="height:30px;"> 
                </div>
            </div>
            <div class="col-md-4 " style="position:unset;">
                <div class="row m-1"><label for="observaciones" class="m-1">Observaciones</label>
                    <input id="observaciones" class="m-1" type="text" name="observaciones" value="{{ old('observaciones') }}" required autofocus style="padding: 0.375rem 0.75rem;border: 1px solid #ced4da;border-radius: 0.25rem; height:30px;">  
                </div>
            </div>
        </div>   
        <div>
            <div class="col-md-4 " style="position:unset;">
                <div class="row m-1">
                    <input id="activa" class="m-1" type="hidden" name="activa" value="1" required autofocus style="padding: 0.375rem 0.75rem;border: 1px solid #ced4da;border-radius: 0.25rem; height:30px;">  
                </div>
            </div>
        </div>   

    </form>

    <div> 
        <a id="fb1" style="margin-left:8px;height:30px;display: unset; " class="btn btn-outline-success" href="/home"
           onclick="/*event.preventDefault();
            if (validateForm()){*/
               event.preventDefault();
                       if (validateForm()){
               alert('heyyyyy');
                       //AJAX CONTIgodocument.getElementById('rcocodrilera-form').submit();
               }
               else{
               event.preventDefault();
               }
           ">
            Reservar </a>
    </div>

</div>
@endsection

@section('localscript')
<script src="{{ asset('js/jquery-3.5.1.js') }}" ></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('js/sweetalert.min.js') }}" ></script>
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
                   var adultosForm = document.getElementById('adultos').value;
                   var menoresForm = document.getElementById('menores').value;
                   //var totalForm = Number.parseInt(adultosForm) + Number.parseInt(menoresForm);
                   var nacForm = document.getElementById('nac_id').value;
                   var planForm = document.getElementById('plan').value;
                   var fechaEForm = document.getElementById('fecha_entrada').value;
                   var fechaSForm = document.getElementById('fecha_salida').value;
                   var agenciaForm = document.getElementById('agencia_id').value;
                   var activaForm = document.getElementById('activa').value;
                   var observacionesForm = document.getElementById('observaciones').value;
                   console.log('AQUI EMPIEZA TOTAL+ADULTO+MENORES+agencia');
                   console.log(totalForm);
                   console.log(adultosForm);
                   console.log(menoresForm);
                   console.log(agenciaForm);
                   console.log('AQUI ACABA');
                   /*console.log(nameForm);
                    console.log(cocodrileraForm);
                    console.log(mercadoForm);
                    
                    console.log(nacForm);
                    console.log(planForm);
                    console.log(fechaEForm);
                    console.log(fechaSForm);
                    console.log(activaForm);*/
                   if (cumpleTODO(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm, adultosForm, menoresForm, agenciaForm)) {
                       var urlchildren = '/dispococo12params/' + nameForm + '/' + cocodrileraForm +
                               '/' + mercadoForm + '/' + totalForm + '/' + nacForm + '/' + planForm + '/' + fechaEForm +
                               '/' + fechaSForm + '/' + adultosForm + '/' + menoresForm + '/' + agenciaForm + '/' + activaForm;
                       console.log(urlchildren);
                       var jqxhr = $.ajax({
                           url: urlchildren,
                           async: false,
                           timeout: 10000
                       })
                               .done(function (data) {
                                   if (data == 1) {
                                       MensajeDeExito();
                                       LimpiarTodo();
                                       MostrarNumeroReserva();
                                   }
                                   if (data == 0) {
                                       MensajeDeNoInsertada();
                                   }
                                   if (data == -1) {
                                       MensajeDeNoCabe();
                                   }

                               })
                               .fail(function (data) {
                                   console.log(data);
                               })
                               .always(function () {
                               });

                       return false;
                   }
                   return false;
               }

               function cumpleTODO(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm, adultosForm, menoresForm, agenciaForm) {
                   var todo = false;
                   if (EstanLLenosLosComponentes(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm, adultosForm, menoresForm, agenciaForm)) {
                       if (TotalEsMenorqueCapacidad(totalForm, cocodrileraForm, adultosForm, menoresForm)) {
                           if (FechasCorrectamente(fechaEForm, fechaSForm)) {
                               if (ReservaActiva()) {
                                   return true;
                               }
                           }
                       }
                   }
                   return todo;
               }

               function EstanLLenosLosComponentes(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm, adultosForm, menoresForm, agenciaForm) {
                   if (nameForm == "") {
                       document.getElementById('name').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('name').style.backgroundColor = "white";
                   }
                   if (cocodrileraForm == "") {
                       document.getElementById('cocodrilera_id').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('cocodrilera_id').style.backgroundColor = "white";
                   }
                   if (mercadoForm == "") {
                       document.getElementById('mercado_id').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('mercado_id').style.backgroundColor = "white";
                   }
                   if (agenciaForm == "") {
                       document.getElementById('agencia_id').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('agencia_id').style.backgroundColor = "white";
                   }
                   if (totalForm == "") {
                       document.getElementById('total_pax').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('total_pax').style.backgroundColor = "white";
                   }
                   if (adultosForm == "") {
                       document.getElementById('adultos').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('adultos').style.backgroundColor = "white";
                   }
                   if (menoresForm == "") {
                       document.getElementById('menores').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('menores').style.backgroundColor = "white";
                   }
                   if (nacForm == "") {
                       document.getElementById('nac_id').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('nac_id').style.backgroundColor = "white";
                   }
                   if (planForm == "") {
                       document.getElementById('plan').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('plan').style.backgroundColor = "white";
                   }
                   if (fechaEForm == "") {
                       document.getElementById('fecha_entrada').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('fecha_entrada').style.backgroundColor = "white";
                   }
                   if (fechaSForm == "") {
                       document.getElementById('fecha_salida').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('fecha_salida').style.backgroundColor = "white";
                   }
                   if (activaForm == "") {
                       document.getElementById('activa').style.backgroundColor = "lightgreen";
                   } else {
                       document.getElementById('activa').style.backgroundColor = "white";
                   }

                   if (nameForm == "" ||
                           cocodrileraForm == "" ||
                           mercadoForm == "" ||
                           totalForm == "" ||
                           totalForm == "0" ||
                           totalForm == "00" ||
                           totalForm == "000" ||
                           adultosForm == "" ||
                           adultosForm == "0" ||
                           adultosForm == "00" ||
                           adultosForm == "000" ||
                           menoresForm == "" ||
                           nacForm == "" ||
                           planForm == "" ||
                           fechaEForm == "" ||
                           fechaSForm == "" ||
                           agenciaForm == "" ||
                           activaForm == ""
                           )
                   {

                       MensajeDeVacio();
                       return false;
                   }
                   return true;
               }

               function MensajeDeVacio() {
                   let timerInterval;
                   Swal.fire({
                       icon: 'error',
                       title: 'Error de Datos!',
                       /* html: 'I will close in <b></b> milliseconds.',*/
                       html: 'Hay campos Vacios.',
                       timer: 2000,
                       timerProgressBar: true,
                       onBeforeOpen: () => {
                           Swal.showLoading();
                           timerInterval = setInterval(() => {
                               const content = Swal.getContent()
                               if (content) {
                                   const b = content.querySelector('b')
                                   if (b) {
                                       b.textContent = Swal.getTimerLeft()
                                   }
                               }
                           }, 100)
                       },
                       onClose: () => {
                           clearInterval(timerInterval)
                       }
                   }).then((result) => {
                       /* Read more about handling dismissals below */
                       if (result.dismiss === Swal.DismissReason.timer) {
                           console.log('Autocerrado')
                       }
                   })
               }

               function TotalEsMenorqueCapacidad(totalForm, cocodrileraForm, adultosForm, menoresForm) {
                   document.getElementById("resultadoTotal").innerHTML = 'false';
                   ApiCocodrileraCapacidad(totalForm, cocodrileraForm);             
                   if (totalForm < adultosForm) {//SI DA TRUE ESTA MAL
                       MensajeDeTotalMayorIgualQAdultos();
                       document.getElementById('adultos').style.backgroundColor = "lightgreen";
                       document.getElementById('total_pax').style.backgroundColor = "lightgreen";
                       return false;
                   } else {
                       if (document.getElementById("resultadoTotal").innerHTML === 'true') {
                           document.getElementById('total_pax').style.backgroundColor = "white";
                           document.getElementById('adultos').style.backgroundColor = "white";
                           return true;
                       }
                       let totalMaximo = document.getElementById("totalMaximo").innerHTML;
                       MensajeDeTotal(totalMaximo);
                       document.getElementById('adultos').style.backgroundColor = "lightgreen";
                       document.getElementById('total_pax').style.backgroundColor = "lightgreen";
                       return false;
                   }
               }

               function MensajeDeTotalMayorIgualQAdultos() {
                   let timerInterval;
                   Swal.fire({
                       icon: 'error',
                       title: 'Error de Datos!',
                       /* html: 'I will close in <b></b> milliseconds.',*/
                       html: '<h5 style="color:red;">Total Pax</h5> debe ser mayor igual q Adultos',
                       timer: 2000,
                       timerProgressBar: true,
                       onBeforeOpen: () => {
                           Swal.showLoading();
                           timerInterval = setInterval(() => {
                               const content = Swal.getContent();
                           }, 100)
                       },
                       onClose: () => {
                           clearInterval(timerInterval)
                       }
                   }).then((result) => {
                       if (result.dismiss === Swal.DismissReason.timer) {
                           console.log('Autocerrado')
                       }
                   })
               }

               function MensajeDeTotal(totalMaximo) {
                   let timerInterval;
                   let tM = totalMaximo;
                   Swal.fire({
                       icon: 'error',
                       title: 'Error de Datos!',
                       /* html: 'I will close in <b></b> milliseconds.',*/
                       html: 'Total Maximo Admitido( <b></b> ).',
                       timer: 2000,
                       timerProgressBar: true,
                       onBeforeOpen: () => {
                           Swal.showLoading();
                           timerInterval = setInterval(() => {
                               const content = Swal.getContent()
                               if (content) {
                                   const b = content.querySelector('b')
                                   if (b) {                                     //  b.textContent = Swal.getTimerLeft()
                                       b.textContent = tM;
                                   }
                               }
                           }, 100)
                       },
                       onClose: () => {
                           clearInterval(timerInterval)
                       }
                   }).then((result) => {
                       /* Read more about handling dismissals below */
                       if (result.dismiss === Swal.DismissReason.timer) {
                           console.log('Autocerrado')
                       }
                   })
               }

               function ApiCocodrileraCapacidad(total, Elem) {
                   var children = "/api/cocodrilera/".concat(Elem); //  console.log(children);
                   var capacidad = 0;
                   var retorno = false;
                   var jqxhr = $.ajax({
                       url: children,
                       async: false,
                       timeout: 10000
                   })
                           .done(function (data) {
                               capacidad = data.capacidad; //console.log(total);       //console.log(data[0].capacidad);
                               document.getElementById("totalMaximo").innerHTML = capacidad;
                               if (total <= capacidad) {
                                   document.getElementById("resultadoTotal").innerHTML = true;
                               } else {
                                   document.getElementById("resultadoTotal").innerHTML = false;
                               }
                           })
                           .fail(function () {
                               document.getElementById("resultadoTotal").innerHTML = false;
                           })
                           .always(function () {                               //return retorno;                       
                           });
               }

               function FechasCorrectamente(fechaEForm, fechaSForm) {
                   var d1 = new Date(fechaEForm);
                   var d2 = new Date(fechaSForm);
                   if (d1 > d2) {
                       document.getElementById('fecha_entrada').style.backgroundColor = "lightgreen";
                       document.getElementById('fecha_salida').style.backgroundColor = "lightgreen";
                       MensajeDeFecha();
                       return false;
                   }
                   return true;
               }

               function MensajeDeFecha() {
                   let timerInterval;
                   Swal.fire({
                       icon: 'error',
                       title: 'Error de Datos!',
                       /* html: 'I will close in <b></b> milliseconds.',*/
                       html: '<h5 style="color:red;">Fecha entrada</h5> debe ser menor q FSalida',
                       timer: 2000,
                       timerProgressBar: true,
                       onBeforeOpen: () => {
                           Swal.showLoading();
                           timerInterval = setInterval(() => {
                               const content = Swal.getContent();
                           }, 100)
                       },
                       onClose: () => {
                           clearInterval(timerInterval)
                       }
                   }).then((result) => {
                       if (result.dismiss === Swal.DismissReason.timer) {
                           console.log('Autocerrado')
                       }
                   })
               }

               function ReservaActiva() {
                   var activaForm = document.getElementById('activa').value;
                   if (activaForm == "0") {
                       document.getElementById('activa').style.backgroundColor = "lightgreen";
                       return false;
                   }
                   document.getElementById('activa').style.backgroundColor = "white";
                   return true;
               }

               function SiHayDisponibilidad(total, Elem, fechaEForm, fechaSForm) {

               }

               function SiHayDispoTodosParametros(nameForm, cocodrileraForm, mercadoForm, totalForm, nacForm, planForm, fechaEForm, fechaSForm, activaForm) {

               }

               function MensajeDeExito(numeroReserva) {
                   Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'Tu reserva ha sido salvada',
                       showConfirmButton: false,
                       timer: 1500
                   })
               }

               function MensajeDeNoInsertada() {
                   Swal.fire(
                           'Que paso?',
                           'No se inserto la reserva por una razon no conocida',
                           'question'
                           )
               }

               function MensajeDeNoCabe() {
                   Swal.fire(
                           'No hay esta dispo!',
                           'No tienes esta disponibilidad',
                           'question'
                           )
               }

               function LimpiarTodo() {
                   document.getElementById('name').value = "";
                   document.getElementById('cocodrilera_id').value = "";
                   document.getElementById('mercado_id').value = "";
                   document.getElementById('agencia_id').value = "";
                   document.getElementById('adultos').value = "";
                   document.getElementById('menores').value = "";
                   document.getElementById('nac_id').value = "";
                   document.getElementById('plan').value = "";
                   document.getElementById('fecha_entrada').value = "";
                   document.getElementById('fecha_salida').value = "";
                   document.getElementById('activa').value = "";
                   document.getElementById('observaciones').value = "";
               }

               function MostrarNumeroReserva() {

               }
</script>
@endsection
