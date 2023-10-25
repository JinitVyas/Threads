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


        {{-- Display the clicked thread --}}
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
        </div>

        {{-- Form to add new comment --}}
        <div class="card flex-center bg-dark flex-column w-100 mt-4 mb-2" id="AddCommentForm">
            <form action="/addComment" method="post" class="flex-center w-75">
                @csrf
                <input type="hidden" class="form-control" name="tid" value="{{$Thread->tid}}">
                <div class="m-3 w-75">
                    <textarea class="form-control w-100" name="NewComment" id="NewComment" placeholder="Add comment!" rows="1"></textarea>
                    @error('NewComment')
                        <div class="text-danger">The comment can not be empty</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success m-3"> <i class="bi bi-send"></i> </button>
            </form>
        </div>

        {{-- Display All Comments --}}
        <div class="card-group flex-center flex-column w-100 mb-3">
            @php
                $comments = Comment::where('tid',$Thread->tid)->orderBy('cid','desc')->get();
            @endphp
            @foreach ($comments as $comment)
                @php
                    $commenter = Users::where('uid',$comment->uid)->first('uname','uid');
                @endphp
                <div class="card w-75 my-1 bg-dark text-light align-self-start">
                    <div class="card-body">
                        <h4 class="card-title">
                            @<a href="/Profile/{{$commenter->uid}}" class="text-light text-decoration-none">{{$commenter->uname}}</a>
                        </h4>
                        <p class="card-text">{{$comment->ctext}}</p>
                    </div>
                    {{-- <img class="card-img-top" src="holder.js/100x180/" alt="Card image cap"> --}}
                </div>
            @endforeach
            
        </div>
        

        <a name="" id="add-thread" class="btn btn-success flex-center" href="/addComment/{{$Thread->tid}}" role="button">
            <h3 class="flex-center">
                <i class="bi bi-chat-left-dots"></i>
            </h3>
        </a>
    </div>
@endsection