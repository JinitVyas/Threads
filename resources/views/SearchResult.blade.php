@extends('layout/main')

@section('main-content')
@php
    use App\Models\Users;
@endphp
    <div class="main h-100 pt flex-center flex-column text-light">
        <div class="card-group bg-dark text-light flex-center flex-column w-50 rounded-capsule">
            @foreach ($UsersResultSet as $user)    
                <div class="card text-start bg-dark w-100">
                    <div class="card-body w-100 d-flex">
                        <a href="/Profile/{{$user->uid}}" class="text-light d-flex">
                            <i class="bi bi-person h3 me-3"></i>
                            <h4>@</h4><h4 class="card-title"> {{$user->uname}}</h4>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card-group bg-transparent text-light flex-center flex-column w-75 rounded">
            @foreach ($ThreadResultSet as $Thread)
                @php
                    $uname = Users::where('uid',$Thread->uid)->first();
                @endphp
                <div class='card bg-dark my-3 mx-2 border-light border-start-0 w-50' id='threadList'>
                    <a href="/Profile/{{$uname->uid}}" class="text-light d-flex h4">
                        @<h4 class='card-title' >{{$uname->uname}}</h4>
                    </a>
                    <div class='card-body'>
                        <p class='card-text'> {{$Thread->ttext}} </p>
                    </div>
                </div>
            @endforeach
    </div>
@endsection