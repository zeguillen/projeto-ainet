@extends('layouts.master')
@section('title','Add User')
@section('content')

@if ($errors->any())
    @include('common.errors')
@endif
<form action="{{route('movimentos.store')}}" method="post" class="form-group">
    @csrf
    @method('POST')
    @include('users.partials.add-edit')
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
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
        <!-- <button type="submit" class="btn btn-default" name="cancel">Cancel</button> -->
    </div>
</form>

@endsection
