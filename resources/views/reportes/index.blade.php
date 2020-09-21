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
</style>
@endsection

@section('content')
<div class="main" style="padding:10px 10px;">
    <p>Some Font Awesome icons:</p>
    <i class="fas fa-band-aid"></i>
    <i class="fas fa-cat"></i>
    <i class="fas fa-dragon"></i>
    <i class="far fa-clock"></i>
    <i class="fas fa-clock"></i>

    <p>Styled Font Awesome icons (size, color, and shadow):</p>
    <i class="fas fa-clock" style="font-size:24px;"></i>
    <i class="fas fa-clock" style="font-size:36px;"></i>
    <i class="fas fa-clock" style="font-size:48px;color:red;"></i>
    <i class="fas fa-clock" style="font-size:60px;color:lightblue;text-shadow:2px 2px 4px #000000;"></i>
    
    <input id="fecha_entrada" type="date"  name="fecha_entrada"> 
    
    <h2>TITLE HEADING</h2>
    <h5>Title description, Dec 7, 2017</h5>
    <div class="fakeimg" style="height:200px;">Image</div>
    <p>Some text..</p>
    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
    <br>
    <h2>TITLE HEADING</h2>
    <h5>Title description, Sep 2, 2017</h5>
    <div class="fakeimg" style="height:200px;">Image</div>
    <p>Some text..</p>
    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
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
