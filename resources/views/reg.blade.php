@extends('layout/main')

@section('main-content')
    <form class="py-5" action="/reg" method="post">
        @csrf
        <div class="container w-50 d-flex align-item-center flex-column">
            <h1 class="w-100 text-center text-light">Register</h1>
            <div class="formparts d-flex justify-content-around">
                <div class="left d-flex flex-column">
                    <div class="mb-3">
                        <b><label for="uname" class="form-label">Enter a unique Username</label></b>
                        <input type="text" class="form-control" name="uname" id="uname">
                        @error('uname')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <b><label for="fname" class="form-label">Enter your first name</label></b>
                        <input type="text" class="form-control" name="fname" id="fname">
                        @error('fname')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <b><label for="lname" class="form-label">Enter your last name</label></b>
                        <input type="text" class="form-control" name="lname" id="lname">
                        @error('lname')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <b><label for="about" class="form-label">About me</label></b>
                        <br>
                        <textarea name="about" id="about" rows="4" wrap></textarea>
                        @error('about')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gender_male"><b>Gender</b></label><br>
                        <select name="gender" id="gender">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Others</option>
                        </select>
                        @error('gender')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="right  d-flex flex-column">
                    <div class="mb-3">
                        <label for="dob" class="form-label"><b>Date of birth</b></label>
                        <input type="date" name="dob" id="dob" class="form-control" max="{{date('Y-m-d', strtotime('-18 years'))}}">
                        @error('dob')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <b><label for="email" class="form-label">Enter your email id</label></b>
                        <input type="email" class="form-control" name="email" id="email">
                        @error('email')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <b><label for="passwd" class="form-label">Set a Password</label></b>
                        <input type="password" class="form-control" name="passwd" id="passwd">
                        @error('passwd')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <b><label for="conf_passwd" class="form-label">Confirm your Password</label></b>
                        <input type="password" class="form-control" name="conf_passwd" id="conf_passwd">
                        @error('conf_passwd')
                            <div class="text-danger error">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3 mx-auto">
                <a href="\login" class="text-light">Already have an account ?</a>
            </div>
            <button type="submit" class="btn btn-primary align-self-center">Register</button>
        </div>
    </form>
@endsection