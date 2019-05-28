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
                            <label for="inputTipoInstrucao">Tipo de instrução</label>
                            <select name="type" id="inputTipoInstrucao" class="form-control">
                                <option disabled selected> -- select an option -- </option>
                                <option value="0" {{ old('tipo_instrucao', $movimento->tipo_instrucao) == 'D' ? "selected" : "" }}>Duplo Comando</option>
                                <option value="1" {{ old('tipo_instrucao', $movimento->tipo_instrucao) == 'S' ? "selected" : "" }}>Solo</option>
                            </select>
                        </div>
                            
                        <div class="form-group">
                            <label for="inputInstrutor">Instrutor</label>
                            <input
                                type="text" class="form-control"
                                name="instrutor" id="inputInstrutor"
                                value="{{ old('instrutor', $movimento->instrutor) }}"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="inputAdicionar">Adicionar</button>
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
