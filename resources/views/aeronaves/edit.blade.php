@extends('layouts.app')
@section('title','Editar aeronave')
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
                    <form action="{{route('aeronaves.update',['aeronave'=>$aeronave->matricula])}}" method="post" class="form-group">
                        @csrf
                        @method('PUT')
                        @include('aeronaves.partials.add-edit')
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="ok">Save</button>
                            <a href="{{route('aeronaves.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection