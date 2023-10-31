<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ****************************************************
// included manually
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\users;
use App\Models\log;
use App\Models\thread;
use App\Models\connect;
// ****************************************************

class usersController extends Controller
{
    
    function signup(Request $req){
        // logic for signup


        #Print the request data
        echo "<pre>";
        print_r($req->input());
        echo "</pre>";

        // defining validation rules and error messages
        // ******************************************************************
            // define rules for validation
            $rules = [
                'uname'=>'required|string|max:10|unique:users',
                'fname'=>'required|string|max:20',
                'lname'=>'required|string|max:20',
                'email'=>'required|email|max:50|unique:users',
                'about'=>'nullable|string|max:200',
                'dob' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $dob = \Carbon\Carbon::parse($value);
                        $age = $dob->age;
            
                        if ($age < 18) {
                            $fail('You must be at least 18 years old.');
                        }
                    },
                ],
                'gender' => ['required', Rule::in( ['M', 'F', 'O'] ) ],
                'passwd'=>'required|string',
                'conf_passwd'=>'required|string|same:passwd',
            ];
            
            // define messages for validation
            $err_msg = [
                'dob.age_18'=>'You must be atleast 18 years old.',
            ];
        // ******************************************************************

        // finally gather it all (validate data)
        $validatedData = $req->validate($rules,$err_msg);

        // Encrypt password
        $hashedPw = Hash::make($validatedData['passwd']);

        // creating new object for user data insertion
        $NewUser = new Users;


        // asigning user defined values to the object
        $NewUser->uname = $req->input('uname');
        $NewUser->fname = $req->input('fname');
        $NewUser->lname = $req->input('lname');
        $NewUser->email = $req->input('email');
        $NewUser->about = $req->input('about');
        $NewUser->dob = $req->input('dob');
        $NewUser->password = $hashedPw;
        $NewUser->gender = $req->input('gender');

        // echo "<pre>";
        // print_r($NewUser);
        // echo "</pre>";

        // saving the data to the database
        if($NewUser->save())
        {
            return redirect('/');
        }
    }
    
    function login(Request $req){
        // logic for login

        // Validate the login data
        $req->validate([
            'uname' => 'required|string',
            'password' => 'required|string',
        ]);

        // check if the given uname is username or email
        $field = filter_var($req->input('uname'), FILTER_VALIDATE_EMAIL) ? 'email' : 'uname';

        // echo "<pre>";
        // print_r($req->input());
        // echo "</pre>";

        $Founduser =Users::where($field,$req->input('uname'))->first();

        // User not found
        if (!$Founduser) {
            // User not found
            echo "user not found";
            return redirect('/login')->with('error', 'User '. $req->input("uname") .' does not exist.');
        }

        // User found check passord
        if(Hash::check($req->input('password'), $Founduser->password)){
            // echo "<br>Correct credentials";

            Session::put('uid', $Founduser->uid);
            Session::put('uname', $Founduser->uname);
            // Auth::login($Founduser);

            // LOG CODE HERE
            $log = new Log();
            $log->uid = $Founduser->uid;
            $log->login_time = now();
            $log->save();

            
            return redirect()->intended("/home");
        }
        else // WHEN THE UNAME IS CORRECT BUT THE PASSWORD IS INCORRCT
        {
            return redirect()->intended("/login")->with('error', 'Incorrect password');
            // echo "<br>pasword incorrect";
        }
    }

    function logout(){
        session()->flush();
        return redirect()->intended("/")->with('status', 'Logged out successfully!');
    }

    function getProfile(Request $r, $id){
        // echo $id;

        // $userData = Users::where('uid',$id)->get();
        $userData = Users::where('uid',$id)->first();

        if ($userData) {
            // Access the user's attributes
            $uid = $userData->uid;
            $uname = $userData->uname;
            $email = $userData->email;
            $fname = $userData->fname;
            $lname = $userData->lname;
            $about = $userData->about;
            $dob = $userData->dob;
            $gender = $userData->gender;
            $reg_date = $userData->reg_date;
            $followers = $userData->followers;
            $followings = $userData->followings;

                // Compact the user data and pass it to the view
            return view('/ProfilePage', compact('uid','uname', 'email', 'fname', 'lname', 'about', 'dob', 'gender', 'reg_date', 'followers', 'followings'));
        }
        else
        {
            
        }
    }

    function followProfile(Request $r, $id){
        // Create object for new connection 
        $connObj = new Connect();

        $follower = Users::where('uid',session('uid'))->first();
        $following = Users::where('uid',$id)->first();

        // Fetch data for cols 
        $follower_id = session('uid');
        $following_id = $id;

        // Assign data to columns 
        $connObj->follower_id = $follower_id;
        $connObj->following_id = $following_id;

        // Insert query 
        $follower->followings += 1;
        $following->followers += 1;
        
        $follower->save();
        $following->save();
        $connObj->save();


        // windup
        return redirect('/Profile/'.$following_id);
    }

    function unfollowProfile(Request $r, $id){
        $followRecord = Connect::where('follower_id',session('uid'))->where('following_id',$id)->first();


        $follower = Users::where('uid',session('uid'))->first();
        $following = Users::where('uid',$id)->first();

        // adjust counts
        $follower->followings -= 1;
        $following->followers -= 1;

        // make changes in db
        $follower->save();
        $following->save();
        $followRecord->delete();

        // wrap up
        return redirect('/Profile/'.$id);
    }

    function editProfile(){

        $userData = Users::where('uid',session('uid'))->first();
        if ($userData) {
            // Access the user's attributes
            $uid = $userData->uid;
            $uname = $userData->uname;
            $fname = $userData->fname;
            $lname = $userData->lname;
            $about = $userData->about;
            $dob = $userData->dob;
            $gender = $userData->gender;

                // Compact the user data and pass it to the view
            return view('/EditProfile', compact('uid','uname','fname', 'lname', 'about', 'dob', 'gender'));
        }
    }

    function updateProfile(Request $r){
        
        $rules = [
            'uname' => [
                'required',
                'string',
                'max:10',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('uname', '!=', session('uname'));
                }),
            ],
            'fname'=>'required|string|max:20',
            'lname'=>'required|string|max:20',
            'bio'=>'nullable|string|max:200',
            'dob'=>['required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $dob = \Carbon\Carbon::parse($value);
                        $age = $dob->age;
            
                        if ($age < 18) {
                            $fail('You must be at least 18 years old.');
                        }
                    },
                ],
            'gender'=>['required', Rule::in( ['M', 'F', 'O'] ) ],
        ];

        $err_msg = [
            'uname.required'=>'Username can\' be blank',
            'fname.required'=>'First name can\' be blank',
            'lname.required'=>'Username can\' be blank',

            'uname.max'=>'Username can\'t be greater than 10 characters',
            'dob.age_18'=>'You must be atleast 18 years old.',
            'uname.unique'=>'username already taken, try anotherone',
        ];

        $validatedData = $r->validate($rules,$err_msg);


        echo "<br>".$uname = $r->input('uname');
        echo "<br>".$gender = $r->input('gender');
        echo "<br>".$fname = $r->input('fname');
        echo "<br>".$lname = $r->input('lname');
        echo "<br>".$dob = $r->input('dob');
        echo "<br>".$bio = $r->input('bio');

        $CurrentUser = Users::where('uid',session('uid'))->first();

        $CurrentUser->uname = $uname;
        $CurrentUser->fname = $fname;
        $CurrentUser->lname = $lname;
        $CurrentUser->gender = $gender;
        $CurrentUser->dob = $dob;
        $CurrentUser->about = $bio;

        $CurrentUser->save();
        session(['uname'=>$uname]);
        return redirect('/Profile/'.session('uid'));
    }
    
}