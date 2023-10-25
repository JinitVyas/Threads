@extends('layout/main')

@section('main-content')

@php
    use App\Models\thread;
    use App\Models\users;
    use App\Models\vote;
    use App\Models\comment;
    // $Threads = Thread::all();
    $Threads = Thread::orderBy('upload_datetime','desc')->paginate(10); 
@endphp

<div class="main h-100 pt container flex-center text-light">
    <div class="card-group d-flex align-items-start flex-column p-5 my-3 w-75 rounded">
            <h1 class="text-center w-100 text-info">Threads</h1>

                    @php
                if (isset($Threads)) {
                    foreach ($Threads as $Thread) {
                        $voteCount = Vote::where('tid', $Thread->tid)->count() ?? 0;
                        $commentCount = Comment::where('tid', $Thread->tid)->count() ?? 0;
                        echo "
                        <div class='card bg-dark my-3 mx-2 border-light border-start-0 w-100' id='threadList'>";
                            
                            echo "
                            <h4 class='card-title'> <a href='/Profile/".$Thread->uid."' class='text-light text-decoration-none'> @". users::where('uid',$Thread->uid)->get('uname')[0]->uname ."</a></h4>
                            <div class='card-body'>
                                <p class='card-text'>". $Thread->ttext ."</p>
                            </div>
                        ";
                        if ($Thread->tmediapath) {
                            echo "<div><img class='card-img' src='" . url('/storage/' . $Thread->tmediapath) . "'></div>";
                        }
                    @endphp
                        <div class="actions px-3 h5 d-flex">
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
                                            
                                echo '<a href="/Comment/'.$Thread->tid.'" class="flex-center flex-column text-light text-decoration-none">
                                            <i class="bi bi-chat-left-dots mx-2"></i>
                                            <p class="h6 px-3">'.$commentCount.'</p>
                                    </a>';
                                
                            @endphp
                            
                            <i class="bi bi-message-cloud mx-2"></i>
                        </div>
                            @php
                        echo '</div>';
                    }
                } else {
                    echo "No Threads are there, be the first to Start!";
                }
            @endphp
            <div class="h6 pagination flex-center w-100">
                {{$Threads->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
    <a name="" id="add-thread" class="btn btn-success" href="/addThread" role="button"><h1>+</h1></a>

    @include('layout/footer')
@endsection