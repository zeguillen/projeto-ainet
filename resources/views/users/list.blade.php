@extends('layouts.master')
@section('title','List Users')
@section('content')

<div>
    <a class="btn btn-primary" href="{{route('users.create')}}">Add user</a>
    <form action="{{route('quotas.reset')}}" method="post" class="inline">
            @csrf
            @method('PATCH')
            <input class="btn btn-danger" type="submit" value="Reset quotas"/>
    </form>
    <form action="{{route('users.desativar')}}" method="post" class="inline">
            @csrf
            @method('PATCH')
            <input class="btn btn-danger" type="submit" value="Desativar sócios com quotas por pagar"/>
    </form>
</div>

@if (count($users))
    <div class="form-group">
        <form action="{{route('users.index')}}" method="get" class="form-group">
            @csrf
            <input type="text" name="num_socio" id="inputNumSocio" placeholder="Número de Sócio"/>
            <input type="text" name="nome_informal" id="inputNumSocio" placeholder="Nome Informal"/>
            <select name="tipo_socio" id="inputType">
              <option value="none"></option>  
              <option value="piloto">Piloto</option>
              <option value="nao_piloto">Não Piloto</option>
              <option value="aeromodelista">Aeromodelista</option>
            </select>
            <label>Pertece á Direção?</label>
            <input type="radio" name="direcao" value="true">Sim
            <input type="radio" name="direcao" value="false">Não
            <button type="submit" class="btn btn-success">Filtrar</button>
        </form>
    </div>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Número Sócio</th>
            <th>Nome Informal</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Tipo de Sócio</th>
            <th>Número Licença</th>
            <td>Membro da direção</td>
            <th>Profile Picture</th>
            <th></th>
            <th>Quotas</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{$user->num_socio}}</td>
            <td>{{$user->nome_informal}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->telefone}}</td>
            <td>{{$user->typeToStr()}}</td>
            @if ($user->typeToStr() == "Piloto")
                <td>{{$user->num_licenca}}</td>
            @else
                <td>Sem licença</td>
            @endif
            <td>{{$user->direcao == 1 ? 'Sim' : 'Não'}}</td>
            <td><img src="/storage/fotos/{{ $user->foto_url }}" alt="Profile Picture" width="100%"></td>
            <td>
            <!-- fill with edit and delete actions -->
                <a class="btn btn-primary btn-sm" href="{{route('users.edit',['id'=>$user->id])}}">
                    Edit
                </a>
                <form action="{{route('users.destroy',['id'=>$user->id])}}" method="post" class="inline">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-danger btn-sm" type="submit" value="Delete"/>
                </form>
            </td>

            <td> 
                <form  action=" {{route('quota.change', ['id'=>$user->id])}} " method="post">
                    @csrf
                    @method('PATCH')

                    @if ($user->quota_paga)
                        <input class="btn btn-success btn-sm" type="submit" value="Pagas"/>
                    @else
                        <input class="btn btn-danger btn-sm" type="submit" value="Por pagar"/>
                    @endif
                </form>
            </td>

            <td> 
                <form  action=" {{route('ativo.change', ['id'=>$user->id])}} " method="post">
                    @csrf
                    @method('PATCH')

                    @if ($user->ativo)
                        <input class="btn btn-success btn-sm" type="submit" value="Ativo"/>
                    @else
                        <input class="btn btn-danger btn-sm" type="submit" value="Não Ativo"/>
                    @endif
                </form>
            </td>
        </tr>
    @endforeach
    </table>
    {{$users->appends(request()->input())->links()}} <!--Paginate-->
@else
    <h2>No users found</h2>
@endif

@endsection