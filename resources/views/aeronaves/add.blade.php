@extends('layouts.app')
@section('title','Adicionar aeronave')
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
                    <form action="{{route('aeronaves.store')}}" method="post" class="form-group">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="inputMatricula">Matrícula</label>
                            <input 
                                type="text" class="form-control"
                                name="matricula" id="inputMatricula"
                                placeholder="Matricula" value="{{old('matricula', $aeronave->matricula)}}"
                                required
                            />
                        </div>
                        
                        @include('aeronaves.partials.add-edit')

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="ok">Add</button>
                            <a href="{{route('aeronaves.index')}}" class="btn btn-default">Cancel</a>
                            <!-- <button type="submit" class="btn btn-default" name="cancel">Cancel</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
