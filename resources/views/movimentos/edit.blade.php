@extends('layouts.master')
@section('title','Editar Movimentos')
@section('content')

@if ($errors->any())
    @include('common.errors')
@endif
<form action="{{route('movimentos.update',['id'=>$movimento->id])}}" method="post" class="form-group">
    @csrf
    @method('PUT')
    @include('movimentos.partials.add-edit')
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a href="{{route('movimentos.index')}}" class="btn btn-default">Cancel</a>
    </div>
</form>

@endsection