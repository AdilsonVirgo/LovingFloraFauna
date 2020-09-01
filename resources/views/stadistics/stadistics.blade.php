@extends('layouts.appOFF')

@section('localcss')
<style>
    .progress-container {
        width: 100%;
        height: 8px;
        background: #ccc;
    }

    .progress-bar {
        height: 8px;
        background: #4caf50;
        width: 0%;
    }
    /* Float four columns side by side */
.column {
  float: left;
  width: 25%;
  padding: 0 5px;
}

.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 10px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #444;
  color: white;
}

.fa {font-size:50px;}
</style>
@endsection

@section('content')
<div class="main" style="padding:10px 10px;">
    <div class="row">
        <div class="column">
            <div class="card">
                <p><i class="fa fa-user"></i></p>
                <h3>11+</h3>
                <p>Partners</p>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <p><i class="fa fa-check"></i></p>
                <h3>55+</h3>
                <p>Projects</p>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <p><i class="fa fa-smile"></i></p>
                <h3>100+</h3>
                <p>Happy Clients</p>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <p><i class="fa fa-coffee"></i></p>
                <h3>100+</h3>
                <p>Meetings</p>
            </div>
        </div>
    </div> 
</div>

@endsection

@section('localscript')
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
</script>
@endsection
