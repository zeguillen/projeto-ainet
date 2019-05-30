@extends('layouts.app')
@section('title','Listar aeronaves')
@section('content')

@if (session()->has('success'))
    @include('common.success')
@endif

<div class="form-group"><a class="btn btn-primary" href="{{route('aeronaves.create')}}">Adicionar aeronave</a></div>
@if (count($aeronaves))
    <table class="table table-striped ">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Nº de Lugares</th>
            <th>Total de horas</th>
            <th>Preço hora</th>
            <th>Pilotos autorizados</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($aeronaves as $aeronave)
        <tr>
            <td>{{$aeronave->matricula}}</td>
            <td>{{$aeronave->marca}}</td>
            <td>{{$aeronave->modelo}}</td>
            <td>{{$aeronave->num_lugares}}</td>
            <td>{{$aeronave->conta_horas}}</td>
            <td>{{$aeronave->preco_hora}}</td>
            <td>
               <a class="btn btn-primary" href="{{route('aeronaves.pilotos', ['aeronave'=>$aeronave->matricula])}}">Pilotos Autorizados</a> 
            </td>
            <td>
                <a class="btn btn-primary btn-sm" href="{{route('aeronaves.edit', ['aeronave'=>$aeronave->matricula])}}">Editar</a>

                <form action="{{route('aeronaves.destroy', ['aeronave'=>$aeronave->matricula])}}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger btn-sm" value="Apagar" />
                </form>
            </td>
        </tr>
    @endforeach
    </table>
    {{$aeronaves->links()}} <!--Paginate-->
@else
    <h2>No aeroplane found</h2>
@endif

@endsection