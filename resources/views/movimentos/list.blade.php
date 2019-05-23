@extends('layouts.master')
@section('title','List Movimentos')
@section('content')

<div><a class="btn btn-primary" href="{{route('movimentos.create')}}">Add movimento</a></div>
@if (count($movimentos))
    <div class="form-group">
        <form action="{{route('movimentos.index')}}" method="get" class="form-group">
            @csrf
            <input type="text" name="id" id="inputId" placeholder="ID do movimento"/>
            <input type="text" name="aeronave" id="inputAeronave" placeholder="Matricula da Aeronave"/>
            <input type="text" name="piloto" id="inputPiloto" placeholder="Nome do piloto"/>
            <input type="text" name="instrutor" id="inputInstrutor" placeholder="Nome do instrutor"/>
            <label>Data entre:</label>
            <input type="date" name="data_inf" id="inputDataInicio" placeholder="Data Inicio"/>
            <input type="date" name="data_sup" id="inputDataFim" placeholder="Data Fim"/>
            <select name="natureza" id="inputType">
              <option value="none"></option>  
              <option value="treino">Treino</option>
              <option value="instrucao">Instrução</option>
              <option value="especial">Especial</option>
            </select>
            <label>Confirmados:</label>
            <input type="radio" name="confirmado" value="true">Sim
            <input type="radio" name="confirmado" value="false">Não
            <button type="submit" class="btn btn-success">Filtrar</button>
        </form>
    </div>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>ID do Movimento</th>
            <th>Aeronave</th>
            <th>Data</th>
            <th>Hora Descolagem</th>
            <th>Hora Aterragem</th>
            <th>Tempo Voo</th>
            <th>Natureza</th>
            <th>Piloto</th>
            <th>Aerodromo Partida</th>
            <th>Aerodromo Chegada</th>
            <th>Num Aterragens</th>
            <th>Num Descolagens</th>
            <th>Num Diario</th>
            <th>Num Servico</th>
            <th>Conta Horas Inicio</th>
            <th>Conta Horas Fim</th>
            <th>Num Pessoas</th>
            <th>Tipo Instrucao</th>
            <th>Instrutor</th>
            <th>Confirmado</th>
            <th>Observações</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($movimentos as $movimento)
        <tr>
            <td>{{$movimento->id}}</td>
            <td>{{$movimento->aeronave}}</td>
            <td>{{$movimento->data}}</td>
            <td>{{$movimento->hora_descolagem}}</td>
            <td>{{$movimento->hora_aterragem}}</td>
            <td>{{$movimento->tempo_voo}}</td>
            <td>{{$movimento->naturezaToStr()}}</td>
            <td>{{$movimento->user->nome_informal}}</td>
            <td>{{$movimento->aerodromo_partida}}</td>
            <td>{{$movimento->aerodromo_chegada}}</td>
            <td>{{$movimento->num_aterragens}}</td>
            <td>{{$movimento->num_descolagens}}</td>
            <td>{{$movimento->num_diario}}</td>
            <td>{{$movimento->num_servico}}</td>
            <td>{{$movimento->conta_horas_inicio}}</td>
            <td>{{$movimento->conta_horas_fim}}</td>
            <td>{{$movimento->num_pessoas}}</td>
            <td>{{$movimento->tipo_instrucao}}</td>
            <td>{{$movimento->instrutor_id}}</td>
            <td>{{$movimento->confirmado}}</td>
            <td>{{$movimento->observacoes}}</td>
        </tr>
    @endforeach
    </table>
    {{$movimentos->appends(request()->input())->links()}} <!--Paginate-->
@else
    <h2>No aeroplane found</h2>
@endif

@endsection