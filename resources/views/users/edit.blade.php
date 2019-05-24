@extends('layouts.master')
@section('title','Edit User')
@section('content')

@if ($errors->any())
    @include('common.errors')
@endif
<form action="{{route('users.update',['id'=>$user->id])}}" method="post" class="form-group" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('users.partials.add-edit')
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
    </div>
</form>

@endsection 