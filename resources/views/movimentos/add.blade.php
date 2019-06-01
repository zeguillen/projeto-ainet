@extends('layouts.app')
@section('title','Adicionar movimento')
@section('content')

@if ($errors->any())
    @include('common.errors')
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@yield('title')</div>
                <div class="card-body">
                    <form action="{{route('movimentos.store')}}" method="post" class="form-group">
                        @csrf
                        @method('POST')
                        @include('movimentos.partials.add-edit')
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="inputAdicionar" value="add">Adicionar</button>
                            <button type="submit" class="btn btn-success" name="inputAdicionar" value="confirmar">Confirmar e Adicionar</button>
                            <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
                            <!-- <button type="submit" class="btn btn-default" name="cancel">Cancel</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
