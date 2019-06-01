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
                    @can('updateAll', App\User::class)
                    @if(!$user->ativo)
                    <form action="{{route('reenviar.email', ['socio'=>$user->id])}}" method="post" class="form-group" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="ativacao">Reenviar Email de Ativação</button>
                        </div>
                    </form>
                    @endif 
                    @endcan
                    <br>
                    <form action="{{route('users.update',['id'=>$user->id])}}" method="post" class="form-group" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('users.partials.add-edit')
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="ok">Save</button>
                            <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>

                    <br>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
