@extends('layouts.app')
@section('title','Assuntos Pendentes')
@section('content')

@if (count($movimentos) || count($users))
	
	<table class="table table-striped ">
    <thead>
    	<h2>Movimentos</h2>
        <tr>
			<th>Assunto</th>
			<th>Id do Movimento</th>
			<th>Data</th>
			<th>Número do serviço</th>
            <th>Piloto</th>
            <th>Aeronave</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
	@foreach ($movimentos as $movimento)
        <tr>
        	<td>Movimento por confirmar</td>
        	<td>{{$movimento->id}}</td>
        	<td>{{$movimento->data}}</td>
        	<td>{{$movimento->num_servico}}</td>
            <td>{{$movimento->piloto_id}}</td>
            <td>{{$movimento->aeronave}}</td>
            <td>
	            <a class="btn btn-primary" href="{{route('movimentos.edit',['movimento'=>$movimento->id])}}">
	                Ver Movimento
	            </a>
	        </td>
        </tr>
    @endforeach
	</tbody>
    </table>
    {{$movimentos->appends(['t1' => $movimentos->currentPage(), 't2' => $users->currentPage()])->links()}} 
    <!--Paginate-->

	<br>

	<table class="table table-striped ">
    <thead>
    	<h2>Licenças e certificados</h2>
        <tr>
			<th>Assunto</th>
            <th>Piloto</th>
            <th>Nome</th>
            <th>Número da Licença do Piloto</th>
            <th>Número do Certificado do Piloto</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>Licença por confirmar</td>
            <td>{{$user->id}}</td>
            <td>{{$user->nome_informal}}</td>
            <td>{{$user->num_licenca}}</td>
            <td>{{$user->num_certificado}}</td>
            <td>
            	<a class="btn btn-primary" href="{{route('users.edit',['socio'=>$user->id])}}">
                    Ver Piloto
                </a>
            </td>
        </tr>
    @endforeach
	</tbody>
	</table>
	{{$users->appends(['t1' => $movimentos->currentPage(), 't2' => $users->currentPage()])->links()}} 
	<!--Paginate-->
@else
    <h2>Não há assuntos pendentes</h2>
@endif

@endsection