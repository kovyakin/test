@extends('dashboard')

@section('content')
    <div id="tags">
        <tags-form
                scrf="{{ csrf_token() }}"
        />
    </div>

@endsection
@vite([
 'resources/js/src/pages/tags.js'
 ])
