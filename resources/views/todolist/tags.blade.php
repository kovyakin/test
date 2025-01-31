@extends('dashboard')

@section('content')

    <div id="tags">
        <tags-form
           token ="VSsczfZKw6GZDWPEh8lytbWAIKxFYBhTI2hsBNPC5cfed5d3"
        >

        </tags-form>
    </div>

@endsection
@vite([
 'resources/js/src/pages/tags.js'
 ])
