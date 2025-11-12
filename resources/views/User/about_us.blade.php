@extends('User.layout')
@section('title')
    About Us
@endsection
@section('content')
    <main class="h-100" style="min-height:80vh; height:auto">

        <div class="">
            {!! $content !!}
        </div>

    </main>
@endsection