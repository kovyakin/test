@extends('dashboard')

@section('content')

    <div id="tasks">
        <tasks-form
                token ="VSsczfZKw6GZDWPEh8lytbWAIKxFYBhTI2hsBNPC5cfed5d3"
        ></tasks-form>
    </div>

@endsection
@vite([
 'resources/js/src/pages/tasks.js'
 ])
