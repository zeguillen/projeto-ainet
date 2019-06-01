@extends('layouts.app')
@section('title','Editar Movimento')
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
                    <form action="{{route('movimentos.update',['movimento'=>$movimento->id])}}" method="post" class="form-group">
                        @csrf
                        @method('PUT')
                        @include('movimentos.partials.add-edit')
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="gravar" value="guardar">Guardar</button>
                            <button type="submit" class="btn btn-success" name="gravar" value="confirmar">Confirmar e Guardar</button>
                            <a href="{{route('movimentos.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection