@extends('layouts.app')
@section('title','Listagem de Pilotos')
@section('content')

<div class="form-group">
    <a class="btn btn-primary" href="{{route('aeronaves.index')}}">Aeronaves</a>
</div>

<div class="form-group float-right mb-0">
    <form action="{{route('aeronaves.pilotos', ['aeronave'=>$matricula])}}" method="get" class="form-group">
        @csrf
        <div class="form-row form-inline  align-items-center">
            <div class="form-group form-check form-check-inline col-auto">
                <label class="mr-2">Mostrar Pilotos: </label>
                <input type="radio" name="autorizado" id="1" class="form-check-input" value="true"><label for="1" class="mr-2">Autorizados</label>
                <input type="radio" name="autorizado" id="2" class="form-check-input" value="false"><label for="2">Não Autorizados</label>
            </div>

            <div class="form-group col-auto">
                <button type="submit" class="btn btn-success">Filtrar</button>
            </div>
        </div>
    </form>
</div>
<h3>Aeronave: {{$matricula}}</h3>
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
            <td>{{$piloto->id}}</td>
            <td>{{$piloto->nome_informal}}</td>
            <td>{{$piloto->email}}</td>
            <td>{{$piloto->telefone}}</td>
            <td>{{$piloto->num_licenca}}</td>
            @if($aut)
                <td>
                    <form action="{{route('piloto.naoautorizar',['aeronave'=>$matricula, 'piloto'=>$piloto->id])}}" method="post" class="inline">
                        @csrf
                        @method('DELETE')
                        <input class="btn btn-danger btn-sm" type="submit" value="Não Autorizar"/>
                    </form>
                </td>
            @else
                <td>
                    <form action="{{route('piloto.autorizar',['aeronave'=>$matricula, 'piloto'=>$piloto->id])}}" method="post" class="inline">
                        @csrf
                        <input class="btn btn-success btn-sm" type="submit" value="Autorizar"/>
                    </form>
                </td>
            @endif
            
        </tr>
    @endforeach
    </table>
    {{$pilotos->links()}} <!--Paginate-->
@else
    <h2>Não foram encontrados pilotos</h2>
@endif

@endsection