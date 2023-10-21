@extends('layout/main')

@section('main-content')
    <div class="text-center bg-dark" id="pages" style="height:140vh;position: relative;">
        <div id="page1" class="inner-pages text-center d-flex align-items-center justify-content-center bg-dark text-light">
            <h1 id="first-view">
                <div class="welcome-text text-start" id="first-slide">
                    <h1>Welcome to threads <br>Developed by <b class="text-info">Jinit</b>.</h1>
                    <h4>An app where you can <b class="text-success"><u>connect to the world</u></b> and discuss various topics from anywhere anytime.</h4>
                    <h6>This app is mainly focused on gathering people online and <b class="text-warning">brinstorm</b>.</h6>
                </div>
                <img src="{{asset('ThreeD/logo.png')}}" alt="" height="400" id="thread-logo" class="animate-right" data-aos="flip-left" data-aos-duration="1600">
                
            </h1>
        </div>
        <div id="page2" class="inner-pages text-center d-flex align-items-center justify-content-center bg-dark text-light position-relative">
            <h1 id="second-view">
                <img src="{{asset('ThreeD/socialmedia2.png')}}" alt="" height="400" id="thread-logo" class="animate-left" data-aos="flip-right">
                <div class="welcome-text text-start">
                    <h1>Discover Threads</h1>
                    <h4>An app where you can <b class="text-success"><u>explore the world</u></b> and engage in discussions on various topics from anywhere, anytime.</h4>
                    <h6>This app is primarily focused on bringing people together online to <b class="text-warning">ignite creativity</b>.</h6>
                </div>
                
            </h1>
        </div>
        
        <div class=" d-flex justify-content-center align-items-center bg-dark w-100" style="height: 100vh">
            <a class="btn btn-success text-light fw-bold my-5 me-4" href="/reg">Register</a>
            <a class="btn btn-success text-light fw-bold my-5 ms-4" href="/login">Login</a>
        </div>
    </div>
@endsection
