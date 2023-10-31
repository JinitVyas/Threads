@extends('layout/main')

@section('main-content')
    @php
        use App\Models\Thread;
        use App\Models\Connect;
        use App\Models\Users;

        $ThreadsCount = Thread::where('uid', $uid)->count();
        // $ThreadsCount = $Threads->count();
    @endphp
    <style>
        input{
            width: 5em;
        }
    </style>
    <form action="Edit" method="post">
        @csrf
        <div class="main h-100 pt flex-center">
            <div class="w-75 flex-center" id="pages" style="position: relative;">
                <div class="bg-dark text-light flex-center p-5 my-4" style="border-radius: 20px; width:fit-content;">
                    <div class="container d-flex flex-column" style="justify-content: space-around">
                        <div id="div1" class="profile-divs"
                            style="display:flex;justify-content:space-between; align-items:start;">
                            <div class="w-100 d-flex justify-content-between">
                                <h1 class="text-light">
                                    <div id="Uname" class="flex-center">
                                        <i class="text-light bi bi-person-circle me-3"></i>
                                        <input type="text" value="{{ $uname }}" name="uname" class="border-0 border-bottom bg-transparent text-light h2 px-2" placeholder="Username">
                                        @error('uname')
                                            <div class="text-danger h6">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <select name="gender" class="bg-transparent h5 border-0 border-bottom text-light">
                                        {{-- @php
                                        if ($gender == 'M') {
                                            $gender = 'He/Him';
                                        } elseif ($gender == 'F') {
                                            $gender = 'She/Her';
                                        } else {
                                            $gender = 'It';
                                        }
                                        @endphp --}}
                                        <option class="text-light h6 bg-dark" value="M" <?= $gender == "M"?"Selected":" "?>><b>He/Him</b></option>
                                        <option class="text-light h6 bg-dark" value="F" <?= $gender == "F"?"Selected":" "?>><b>She/Her</b></option>
                                        <option class="text-light h6 bg-dark" value="O" <?= $gender == "O"?"Selected":" "?>><b>Other</b></option>
                                    </select>
                                </h1>
                            </div>
                        </div>
                        <div id="div2" class="d-flex justify-content-start mt-2">
                            <div class="w-100">
                                <h4 class="text-light">
                                    <input type="text" value="{{ old('fname') ?old('fname'):$fname }}" name="fname" class="bg-transparent h5 border-0 border-bottom text-light">
                                    @error('fname')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                    <input type="text" value="{{ $lname }}" name="lname" class="bg-transparent h5 border-0 border-bottom text-light">
                                    @error('lname')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
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
                                    <i class="bi bi-cake text-info me-2"></i> 
                                    <input type="date" name="dob" value="{{ $dob }}" max="{{date('Y-m-d', strtotime('-18 years'))}}" style="width: fit-content" class="bg-transparent text-light p-1 border-0 border-bottom">
                                    @error('dob')
                                        <div class="text-danger error">{{$message}}</div>
                                    @enderror
                                </h6>
                            </div>
                        </div>
                        <div id="div4" class="profile-divs d-flex justify-content-start">
                            <div class="mb-3 w-100 text-light">
                                <h6>
                                    <div class="mb-3">
                                        <b>
                                            <textarea class="form-control bg-transparent text-light" name="bio" rows="4">
                                                {!! $about !!}
                                            </textarea>
                                        </b>
                                    </div>
                                </h6>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                {{-- @include('MyThreads') --}}
            </div>
        </div>
    </form>


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