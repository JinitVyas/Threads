<!doctype html>
<html lang="en">

<head>
    <title>JV's Threads</title>

    <style>
        .error {
            background: #fff;
            border-radius: 20px;
            padding: 0.5em;
        }
        header
        {
            position:fixed;
            width: 100%;
            background: #0000008a;
            z-index: 10;
        }
        footer{
            position: static;
            bottom: 0;
        }
    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-dark py-4">
            <div class="container">
                <a class="navbar-brand" href="/">Threads - By JV</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-flex align-items-center justify-content-center flex-wrap" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="/" aria-current="page">Home <span
                                    class="visually-hidden">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                    </ul>
                    <form class="d-flex my-2 my-lg-0">
                        <input class="form-control me-sm-2" type="text" placeholder="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    @if(session('uname'))
                        <b class="text-light ms-5">
                            <a href="/Profile/{{session('uid')}}" class="text-light"> {{ session('uname') }} </a>
                        </b>
                        <a href="/logout" class="btn btn-danger ms-3">Logout</a>
                    @else
                        <a class="btn btn-success text-light fw-bold ms-3" href="/login">Login</a>
                        <a class="btn btn-success text-light fw-bold ms-2" href="/reg">Register</a>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <main class="svg-bg">
