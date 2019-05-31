@extends('layouts.app')
@section('title','Edit User')
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
                    <form action="{{route('users.update',['id'=>$user->id])}}" method="post" class="form-group" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('users.partials.add-edit')
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="ok">Save</button>
                            <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                    <div class="form-group">
        <label>Cópia Digital da Licença</label><br>

        @if(file_exists(storage_path('app/docs_piloto/licenca_'. $user->id .'.pdf')))
        <form action="{{route('licenca.piloto', ['piloto'=>$user->id])}}" method="get" class="form-group">
            
            @method('GET')
            <button class="btn btn-primary" name="licenca" value="verLicenca">Ver licença</button>
            <button class="btn btn-primary" name="licenca" value="transferirLicenca">Transferir licença</button>
        @else
        <button class="btn btn-primary disabled">Ver licença</button>
        <button class="btn btn-primary disabled">Transferir licença</button>
        @endif

    </div>

    <div class="form-group">
        <label>Cópia Digital do Certificado</label><br>

        @if(file_exists(storage_path('app/docs_piloto/certificado_'. $user->id .'.pdf')))
        <form action="{{route('certificado.piloto', ['piloto'=>$user->id])}}" method="get" class="form-group">
            <button class="btn btn-primary" name="certificado" value="verCertificado">Ver certificado</button>
            <button class="btn btn-primary" name="certificado" value="transferirCertificado">Transferir certificado</button>
        </form>
        @else
        <button class="btn btn-primary disabled">Ver certificado</button>
        <button class="btn btn-primary disabled">Transferir certificado</button>
        @endif

    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 