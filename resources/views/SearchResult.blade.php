@extends('layout/main')

@section('main-content')
    <div class="main h-100 pt flex-center flex-column text-light">

        <div class="card-group bg-dark text-light flex-center flex-column w-50 rounded-capsule">
            @php
                foreach ($UsersResultSet as $user) {                    
                    @endphp
                    <div class="card text-start bg-dark w-100">
                        <div class="card-body w-100 d-flex">
                            <a href="/Profile/{{$user->uid}}" class="text-light d-flex">
                                <i class="bi bi-person h3 me-3"></i>
                                <h4>@</h4><h4 class="card-title">{{$user->uname}}</h4>
                            </a>
                        </div>
                    </div>
                    @php
                }
                @endphp
        </div>
        <div class="card-group bg-dark text-light flex-center flex-column w-50 rounded-capsule">
            @php
                foreach ($ThreadResultSet as $Thread) {
                    echo $Thread;
                    @endphp
                        <div class='card bg-dark my-3 mx-2 border-light border-start-0 w-100' id='threadList'>
                            <h4 class='card-title'>@". $uname ."</h4>
                            <div class='card-body'>
                            <p class='card-text'>". $Thread->ttext ."</p>
                        </div>
                    @php
                }
            @endphp
        </div>
            @php
        @endphp
    </div>
@endsection