<?php

namespace App\Http\Controllers;

use App\Models\thread;
use App\Models\users;
use App\Models\vote;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;


class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        echo '<pre>';
        print_r($req->input());
        echo '</pre>';
        

        // Make object for threrad
        $thread = new Thread();
        
        // Define the protocol (Set of rules)
        $req->validate([
            'ThreadThought' => 'required|string',
            'ThreadMedia' => 'file|mimes:jpeg,png',
        ]);
        
        // Assign the text and uid after validation
        echo $ThreadThought = $req->input('ThreadThought');
        $thread->ttext = $ThreadThought;
        $thread->uid = session('uid');

        // Get user data from the form
        if ($req->hasFile('ThreadMedia')) {
            $file = $req->file('ThreadMedia');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/threadUploads', $fileName); // Adjust the storage path as needed
            $fileUrl = 'threadUploads/' . $fileName;
            
            // Assign the path here because it is optional
            $thread->tmediapath = $fileUrl;
            
            echo $fileName;
            echo '<br>';
        }
        
        //  Finally save the data to the threads.thread table
        $thread->save();

        //  Wrap up and go to next page
        return redirect('/Threads/'.session('uname'));

    }

    public function MyThreads()
    {
        $Threads = Thread::where( 'uid', session('uid') ) -> orderBy('upload_datetime','desc') -> get();
        $Uname = Users::where('uid',session('uid'))->value('uname');
        return view('Mythreads', [ 'Threads' => $Threads,'Uname' => $Uname]);
    }



    public function voteThread(Request $r,$tid){

        $existingLike = Vote::where('uid',session('uid'))->where('tid',$tid)->first();

        if(!is_null($existingLike))
        {
            $existingLike->delete();
            return redirect('/');
            die;
        }

        echo $liker = session('uid');

        $newVote = new Vote();
        $newVote->tid = $tid;
        $newVote->uid = $liker;

        $newVote->save();

        return redirect('/');

    }

    public function showThread(Request $r, $name){
        $userProfileData = Users::where('uname',$name)->first();
        // echo $userProfileData;

        $Threads = Thread::where('uid',$userProfileData->uid)->orderBy('upload_datetime','desc')->paginate(10);

        return view('/MyThreads',['user'=>$userProfileData,'Threads'=>$Threads]);
    }

    public function commentThread(Request $r, $id){
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(thread $thread, Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(thread $thread)
    {
        //
    }
}
