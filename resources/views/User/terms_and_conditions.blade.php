@extends('User.layout')
@section('title')
    Terms And Conditions
@endsection
@section('content')
    <main class="h-100 container " style="min-height:80vh; height:auto">

        <div class="container">
            {!! $content !!}
        </div>
    </main>
    @push('js')
    @endpush
@endsection
