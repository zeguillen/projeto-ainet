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
                <div class="card-header">Editar perfil</div>
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 