@extends('layouts.app')
@section('title','List Aeronaves')
@section('content')

<div><a class="btn btn-primary" href="{{route('aeronaves.create')}}">Add aeroplane</a></div>
@if (count($aeronaves))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Nº de Lugares</th>
            <th>Total de horas</th>
            <th>Preço hora</th>
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
               <a class="btn btn-primary" href="{{route('aeronaves.pilotos', ['matricula'=>$aeronave->matricula])}}">Autorizados</a> 
            </td>
        </tr>
    @endforeach
    </table>
    {{$aeronaves->links()}} <!--Paginate-->
@else
    <h2>No aeroplane found</h2>
@endif

@endsection