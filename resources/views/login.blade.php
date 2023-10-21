@extends('layout/main')

@section('main-content')
    <div class="container w-25" style="min-height:100vh; height:fit-content;">
        <form action="{{ route('login') }}" method="post" style="padding-top:15vh;">
            @csrf
            <h1 class="w-100 text-center text-light" class="padding-top:15vh;">Login</h1>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-3">
                <b><label for="uname" class="form-label text-light">Username or Email</label></b>
                <input type="text" class="form-control" name="uname" id="uname" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <b><label for="password" class="form-label text-light">Password</label></b>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="mb-3">
                <a href="\reg" class="text-light">New User ?</a>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
@endsection

