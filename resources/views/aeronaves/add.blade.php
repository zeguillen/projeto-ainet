@extends('layouts.master')
@section('title','Add User')
@section('content')

@if ($errors->any())
    @include('common.errors')
@endif
<form action="{{route('users.store')}}" method="post" class="form-group">
    @csrf
    @method('POST')
    @include('users.partials.add-edit')
    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input
            type="password" class="form-control"
            name="password" id="inputPassword"
            value="{{old('password',$user->password)}}"
            required
            minlength="8"
        />
    </div>
    <div class="form-group">
        <label for="inputPasswordConfirmation">Password confirmation</label>
        <input
            type="password" class="form-control"
            name="password_confirmation" id="inputPasswordConfirmation"
            required
            minlength="8"
        />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
        <!-- <button type="submit" class="btn btn-default" name="cancel">Cancel</button> -->
    </div>
</form>

@endsection