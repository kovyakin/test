@extends('dashboard')

@section('content')

    <div id="tasks">
        <tasks-form
                csrf="{{ csrf_token() }}"
        ></tasks-form>
    </div>

@endsection
@vite([
 'resources/js/src/pages/tasks.js'
 ])
