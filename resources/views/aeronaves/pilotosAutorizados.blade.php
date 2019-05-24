@extends('layouts.master')
@section('title','Listagem de Pilotos')
@section('content')

<a class="btn btn-primary" href="{{route('aeronaves.index')}}">Aeronaves</a>
<h3>Aeronave: {{$pilotos[0]->matricula}}</h3>
@if (count($pilotos))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Número Sócio</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Número Licença</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($pilotos as $piloto)
        <tr>
            <td>{{$piloto->user->id}}</td>
            <td>{{$piloto->user->nome_informal}}</td>
            <td>{{$piloto->user->email}}</td>
            <td>{{$piloto->user->telefone}}</td>
            <td>{{$piloto->user->num_licenca}}</td>
            <td>
                <form action="{{route('piloto.naoautorizar',['matricula'=>$piloto->matricula, 'piloto'=>$piloto->user->id])}}" method="post" class="inline">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-danger btn-sm" type="submit" value="Não Autorizar"/>
                </form>
            </td>
            
        </tr>
    @endforeach
    </table>
    {{$pilotos->links()}} <!--Paginate-->
@else
    <h2>Não foram encontrados pilotos</h2>
@endif

@endsection