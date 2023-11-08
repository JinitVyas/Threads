<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function getSearchResults(Request $r){
        $SearchText = $_GET['searchText'];
        $ThreadResultSet = Thread::where('ttext','like','%'.$SearchText.'%')->get();
        $UsersResultSet = Users::where('uname','like','%'.$SearchText.'%')->get();
        return view('SearchResult', [ 'SearchText' => $SearchText , 'ThreadResultSet' => $ThreadResultSet , 'UsersResultSet' => $UsersResultSet ] );
    }
}
