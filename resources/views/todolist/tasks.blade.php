@extends('dashboard')

@section('content')

    <div id="tasks">
        <tasks-form></tasks-form>
    </div>

@endsection
@vite([
 'resources/js/src/pages/tasks.js'
 ])
