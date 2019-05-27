@extends('layouts.app')
@section('title','List Movimentos')
@section('content')

<div class="mb-3"><a class="btn btn-primary" href="{{route('movimentos.create')}}">Add movimento</a></div>
@if (count($movimentos))
    <div class="form">
        <form action="{{route('movimentos.index')}}" method="get">
            @csrf
            <div class="form-row align-items-center">
                <div class="form-group col-auto">
                    <input class="form-control" type="text" name="id" id="inputId" placeholder="ID do movimento"/>
                </div>
                <div class="form-group col-auto">
                    <input class="form-control" type="text" name="aeronave" id="inputAeronave" placeholder="Matricula da Aeronave"/>
                </div>
                <div class="form-group col-auto">
                    <input class="form-control" type="text" name="piloto" id="inputPiloto" placeholder="Nome do piloto"/>
                </div>
                <div class="form-group col-auto">
                    <input class="form-control" type="text" name="instrutor" id="inputInstrutor" placeholder="Nome do instrutor"/>
                </div>

                <div class="form-group form-inline col-auto">
                    <label for="inputDataInicio" class="mr-1">Data entre</label>
                    <input class="form-control mr-1" type="date" name="data_inf" id="inputDataInicio" placeholder="Data Inicio"/>
                    <input class="form-control mr-1" type="date" name="data_sup" id="inputDataFim" placeholder="Data Fim"/>
                </div>
                <div class="form-group col-auto">
                    <select class="form-control" name="natureza" id="inputType">
                        <option value="none" disabled selected>Tipo de voo</option>  
                        <option value="treino">Treino</option>
                        <option value="instrucao">Instrução</option>
                        <option value="especial">Especial</option>
                    </select>
                </div>
            </div>
            <div class="form-row align-items-center">
                <div class="form-group form-check form-check-inline col-auto">
                    <label class="mr-2">Confirmados:</label>
                    <input class="form-check-input" type="radio" name="confirmado" value="true" id="confirmadoSim"><label class="form-check-label mr-2" for="confirmadoSim">Sim</label>
                    <input class="form-check-input" type="radio" name="confirmado" value="false" id="confirmadoNao"><label class="form-check-label" for="confirmadoNao">Não</label>
                </div>
                <div class="form-group col-auto">
                    <button type="submit" class="btn btn-success">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped table-responsive">
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
            <td>
                @if($movimento->confirmado)
                    <a class="btn btn-secondary btn-sm" href="{{route('movimentos.edit',['id'=>$movimento->id])}}" disabled>
                        Edit
                    </a>
                @else
                    <a class="btn btn-primary btn-sm" href="{{route('movimentos.edit',['id'=>$movimento->id])}}">
                        Edit
                    </a>
                @endif
            </td>
            <td>    
                <form action="{{route('movimentos.destroy',['id'=>$movimento->id])}}" method="post" class="inline">
                    @csrf
                    @method('DELETE')
                    @if($movimento->confirmado)
                        <input class="btn btn-secondary btn-sm" type="submit" value="Delete" disabled/>
                    @else
                        <input class="btn btn-danger btn-sm" type="submit" value="Delete"/>
                    @endif
                </form>
            </td>
        </tr>
    @endforeach
    </table>
    {{$movimentos->appends(request()->input())->links()}} <!--Paginate-->
@else
    <h2>No aeroplane found</h2>
@endif

@endsection