@extends('dashboard')

@section('content')
    <div id="tags">
        <tags-form
                csrf="{{ csrf_token() }}"
        ></tags-form>
    </div>

@endsection
@vite([
 'resources/js/src/pages/tags.js'
 ])
