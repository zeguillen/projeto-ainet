@extends('layouts.master')
@section('title','List Movimentos')
@section('content')

<div><a class="btn btn-primary" href="{{route('movimentos.create')}}">Add movimento</a></div>
@if (count($movimentos))
    <table class="table table-striped">
    <thead>
        <tr>
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
    {{$movimentos->links()}} <!--Paginate-->
@else
    <h2>No aeroplane found</h2>
@endif

@endsection