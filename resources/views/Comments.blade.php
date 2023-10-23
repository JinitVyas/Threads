@extends('layout/main')

@section('main-content')
@php
    use App\Models\users;
    use App\Models\vote;
    use App\Models\comment;
@endphp
    <div class="main h-100 pt container flex-center text-light flex-column">
        @php
            $voteCount = Vote::where('tid', $Thread->tid)->count() ?? 0;
            $commentCount = Comment::where('tid', $Thread->tid)->count() ?? 0;
        @endphp
        <div class='card bg-dark my-3 mx-2 border-light border-start-0 w-100' id='threadList'>
            @php
            echo "
            <h4 class='card-title'>@". users::where('uid',$Thread->uid)->get('uname')[0]->uname ."</h4>
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
                
                echo '<a href="/Comment/'.$Thread->tid.'">
                        <i class="bi bi-chat-left-dots mx-2"></i>
                    </a>';
                
                @endphp
                
                <i class="bi bi-message-cloud mx-2"></i>
            </div>
        </div>


        <div class="card-group flex-center flex-column w-100">
            @php
                $comments = Comment::where('tid',$Thread->tid)->get();
            @endphp
            @foreach ($comments as $comment)
                @php
                    $commenter = Users::where('uid',$comment->uid)->first('uname','uid');
                @endphp
                <div class="card w-75 my-3 bg-darker text-light align-self-start">
                    <div class="card-body">
                        <h4 class="card-title">
                            @<a href="/Profile/{{$commenter->uid}}" class="text-light text-decoration-none">{{$commenter->uname}}</a>
                        </h4>
                        <p class="card-text">{{$comment->ctext}}</p>
                    </div>
                    <img class="card-img-top" src="holder.js/100x180/" alt="Card image cap">
                </div>
            @endforeach
            
        </div>
        

        <a name="" id="add-thread" class="btn btn-success" href="/addComment" role="button"><h1>+</h1></a>
    </div>
@endsection