@extends('layouts.app')

@section('title','Welcome to the Flight Club')

@section('content')

<div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <h1 class="card-header">@yield('title')</h1>
                    <div class="card-body">
                    <p class="card-text">Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</p>
                    <a href="{{route('login')}}" class="btn btn-lg btn-primary">Entrar na aplicação</a>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
