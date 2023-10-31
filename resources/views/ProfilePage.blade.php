@extends('layout/main')

@section('main-content')
    @php
        use App\Models\Thread;
        use App\Models\Connect;
        use App\Models\Users;

        // Returns 1 if logged in user follows the profile on the screen
        echo $Follow_status = Connect::where('following_id', $uid)
            ->where('follower_id', session('uid'))
            ->first()
            ? 1
            : 0;

        $Threads = Thread::where('uid', $uid)->get();
        $ThreadsCount = $Threads->count();
    @endphp
    <div class="main h-100 pt flex-center">
        <div class="w-75 flex-center" id="pages" style="position: relative;">
            <div class="bg-dark text-light flex-center p-5" style="border-radius: 20px; width:fit-content;">
                <div class="container d-flex flex-column" style="justify-content: space-around">
                    <div id="div1" class="profile-divs"
                        style="display:flex;justify-content:space-between; align-items:start;">
                        <div class="w-100 d-flex justify-content-between">
                            <h1 class="text-light">
                                <div id="Uname" class="flex-center">
                                    <i class="text-light bi bi-person-circle me-3"></i>{{ $uname }}
                                </div>
                                @php
                                    if ($gender == 'M') {
                                        $gender = 'He/Him';
                                    } elseif ($gender == 'F') {
                                        $gender = 'She/Her';
                                    } else {
                                        $gender = 'It';
                                    }
                                @endphp
                                <b class="text-light h6">{{ $gender }}</b>
                            </h1>
                            <div id="right">
                                <h4 class="d-flex w-100 mx-5 d-flex align-items-center">
                                    <a href="/Threads/{{$uname}}" class="text-light text-decoration-none">
                                        <div id="Threads" class="mx-3 text-center">
                                            {{ $ThreadsCount }}<br>
                                            Threads
                                        </div>
                                    </a>
                                    <a href="" class="text-light text-decoration-none" data-bs-toggle="modal" data-bs-target="#FollowerList">
                                        <div id="followers" class="mx-3 text-center">
                                            {{ $followers }}<br>
                                            Followers
                                        </div>
                                    </a>
                                    <a href="#FollowingList" class="text-light text-decoration-none" data-bs-toggle="modal" data-bs-target="#FollowingList">
                                        <div id="followings" class="mx-3 text-center">
                                            {{ $followings }}<br>
                                            Following
                                        </div>
                                    </a>
                                </h4>
                                <div class="flex-center w-100">
                                    @php
                                        if ($uid != session('uid')) {
                                            if ($Follow_status == 0) {
                                                echo '<a href="/Follow/' . $uid . '" class="btn btn-primary w-75">Follow</a>';
                                            } else {
                                                echo '<a href="/Unfollow/' . $uid . '" class="btn btn-secondary border-light text-light w-75">Unollow</a>';
                                            }
                                        } else {
                                            echo '<a href="/Edit" class="btn border-primary btn-dark w-7 text-light w-75">Edit profile</a>';
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="div2" class="d-flex justify-content-start mt-2">
                        <div class="w-100">
                            <h4 class="text-light">
                                {{ $fname }} {{ $lname }}
                            </h4>
                        </div>
                    </div>
                    <div id="div3" class="profile-divs d-flex">
                        <div class="mb-4 w-100">
                            <h6 class="d-flex">
                                @php
                                    $dateTime = new DateTime($dob);
                                    $outputDate = $dateTime->format('d M, Y');
                                @endphp
                                <i class="bi bi-cake text-info me-2"></i> {{ $outputDate }}
                            </h6>
                        </div>
                    </div>
                    <div id="div4" class="profile-divs d-flex justify-content-start">
                        <div class="mb-3 w-100 text-light">
                            <h6>
                                <b>{{ $about }}</b>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @include('MyThreads') --}}
        </div>
    </div>

    <!-- Followers Modal -->
    <div class="modal fade" id="FollowerList" tabindex="-1" aria-labelledby="FollowerListLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content  bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title bg-dark text-light" id="FollowerListLabel">Followers</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  bg-dark text-light">
                    @php
                        $Followers = Connect::where('following_id',$uid)->get();
                        if (!$Followers->isEmpty()) {
                            foreach ($Followers as $Follower) {
                                $UserData = Users::where('uid',$Follower->follower_id)->first();
                                @endphp
                                <a href="/Profile/{{$UserData->uid}}" class="text-light d-flex">
                                    <i class="bi bi-person me-2"></i> {{$UserData->uname}}
                                </a>
                                <hr>
                                @php
                                // echo $Follower;
                            }
                        }
                        else {
                            echo "<b>".$uname."</b> does not have any followers!";
                        }
                    @endphp
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Following Modal -->
    <div class="modal fade" id="FollowingList" tabindex="-1" aria-labelledby="FollowingListLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content  bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title bg-dark text-light" id="FollowingListLabel">Followings</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  bg-dark text-light">
                    @php
                    // echo $uid;
                        $Followings = Connect::where('follower_id',$uid)->get();
                        if (!$Followings->isEmpty()) {
                            foreach ($Followings as $Following) {
                                $UserData = Users::where('uid',$Following->following_id)->first();
                                @endphp
                                <a href="/Profile/{{$UserData->uid}}" class="text-light d-flex">
                                    <i class="bi bi-person me-2"></i> {{$UserData->uname}}
                                </a>
                                <hr>
                                @php
                                // echo $Following;
                            }
                        }
                        else {
                            echo "<b>".$uname."</b> is not following any one!";
                        }
                    @endphp
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('layout/footer')
@endsection
