@extends('layout/main')

@section('main-content')
@php
    use App\Models\vote;
    use App\Models\comment;
@endphp
<div class="main h-100 pt container flex-center text-light">
    <div class="card-group d-flex align-items-start flex-column p-5 my-3 w-75">
        <h1 class="text-center w-100 text-light">Threads by 
        </h1>
        <h1 class="text-center w-100 text-info">{{$uname = $user->uname}}@php if(session('uname') == $user->uname){echo " (you)";} @endphp </h1>
            @php

                if (!$Threads->isEmpty()) {
                    foreach ($Threads as $Thread) {
                        $voteCount = Vote::where('tid', $Thread->tid)->count() ?? 0;
                        $commentCount = Comment::where('tid', $Thread->tid)->count() ?? 0;
                        echo "
                        <div class='card bg-dark my-3 mx-2 border-light border-start-0 w-100' id='threadList'>";
                            echo "
                            <h4 class='card-title'>@". $uname ."</h4>
                            <div class='card-body'>
                                <p class='card-text'>". $Thread->ttext ."</p>
                            </div>
                        ";
                        if ($Thread->tmediapath) {
                            echo "<div><img class='card-img mb-3' src='" . url('/storage/' . $Thread->tmediapath) . "'></div>";
                        }
                        @endphp
                        <div class="actions px-3 h5 d-flex mt-3">
                            <hr>
                            @php
                                $vote = Vote::where('uid',session('uid'))->where('tid',$Thread->tid)->get();
                                if ($vote->isNotEmpty()) {
                                    echo '<div style="width:fit-content;">
                                            <a href="/Like/'.$Thread->tid.'" class="flex-center flex-column text-light text-decoration-none">
                                                <i class="bi bi-heart-fill text-info mx-2"></i>
                                                <p class="h6 px-3">'.$voteCount.'</p>
                                                </a>
                                        </div>';
                                }
                                else {
                                    echo '<div style="width:fit-content;">
                                            <a href="/Like/'.$Thread->tid.'" class="flex-center flex-column text-light text-decoration-none">
                                                <i class="bi bi-heart text-info mx-2"></i>
                                                <p class="h6 px-3">'.$voteCount.'</p>
                                                </a>
                                                </div>
                                                ';
                                            }
                                            
                                    echo '
                                        <div style="width:fit-content;">
                                            <a href="/Comment/'.$Thread->tid.'" class="flex-center flex-column text-light text-decoration-none">
                                                <i class="bi bi-chat-left-dots mx-2"></i>
                                                <p class="h6 px-3">'.$commentCount.'</p>
                                            </a>
                                        </div>
                                ';
                            @endphp
                            
                            <i class="bi bi-message-cloud mx-2"></i>
                            </div>
                            @php
                            echo '</div>';
                        }
                    @endphp
                    
                        <div class="h6 pagination flex-center w-100">
                            {{$Threads->links('pagination::bootstrap-4')}}
                        </div>
                    @php
                } else {
                    echo "<div class='card bg-dark my-3 mx-2 border-light border-start-0 w-100' id='threadList'>
                            <h3 class='text-center'>No threads from you<br>
                                <a href='/addThread' class='text-center text-light'>
                                    Start one!
                                </a>
                            </h3>
                        </div>";
                }
            @endphp
            {{-- <div class="card bg-dark my-3">
                <img class="card-img-top" src="holder.js/100x180/" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title">Title</h4>
                    <p class="card-text">Text</p>
                </div>
            </div> --}}
        </div>
    </div>
    <a id="add-thread" class="btn btn-success" href="/addThread" role="button"><h1>+</h1></a>

    @include('layout/footer')
@endsection