@extends('layout/main')

@section('main-content')
    <div class="container h-100 pt">
        <form action="" method="post" enctype="multipart/form-data" class="d-flex flex-column align-items-center justify-content-center text-light bg-dark">
            @csrf
            <div class="flex-center text-light">
                <h1>Start a <b class="text-info">new thread!</b></h1>
            </div>
            <div class="mb-3 w-100 flex-center">
                <textarea name="ThreadThought" id="ThreadThought" placeholder="Write something..." class="w-75 border rounded p-2 text-light bg-dark" rows="5" required wrap=""></textarea>
            </div>
            <div class="mb-3 w-100 flex-center">
                <input type="file" class="form-control bg-dark text-light w-75" name="ThreadMedia" id="ThreadMedia" aria-describedby="fileHelpId">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Start</button>
            </div>
        </form>
    </div>
@endsection