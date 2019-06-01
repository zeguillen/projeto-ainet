@extends('layouts.app')
@section('title','List Users')
@section('content')

@if (session()->has('success'))
    @include('common.success')
@endif

<div class="action-buttons">
    @can('create', App\User::class)
    <a class="btn btn-primary mr-2 float-left" href="{{route('users.create')}}">Adicionar sócio</a>
    @endcan
    @can('updateAll', App\User::class)
    <form action="{{route('quotas.reset')}}" method="post" class="form-inline float-left mr-2">
            @csrf
            @method('PATCH')
            <input class="btn btn-danger" type="submit" value="Reset quotas"/>
    </form>
    <form action="{{route('users.desativar')}}" method="post" class="form-inline float-left mr-2">
            @csrf
            @method('PATCH')
            <input class="btn btn-danger" type="submit" value="Desativar sócios com quotas por pagar"/>
    </form>
    @endcan
</div>

@if (count($users))
    <div class="form-group float-right mb-0">
        <form action="{{route('users.index')}}" method="get" class="form-group">
            @csrf
            <div class="form-row form-inline  align-items-center">
                <div class="form-group col-auto">
                    <input type="text" name="num_socio" class="form-control" id="inputNumSocio" placeholder="Número de Sócio"/>
                </div>
                <div class="form-group col-auto">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email"/>
                </div>
                <div class="form-group col-auto">
                    <input type="text" name="nome_informal" class="form-control" id="inputNumSocio" placeholder="Nome Informal"/>
                </div>
                <div class="form-group col-auto mr-2">
                    <select name="tipo_socio" class="form-control" id="inputType">
                        <option value="none" disabled selected>Tipo de sócio</option>
                        <option value="piloto">Piloto</option>
                        <option value="nao_piloto">Não Piloto</option>
                        <option value="aeromodelista">Aeromodelista</option>
                    </select>
                </div>
                <div class="form-group form-check form-check-inline col-auto">
                    <label class="mr-2">Pertece á Direção?</label>
                    <input type="radio" name="direcao" class="form-check-input" id="inputEDirecaoSim" value="true"><label for="inputEDirecaoSim" class="mr-2">Sim</label>
                    <input type="radio" name="direcao" class="form-check-input" id="inputEDirecaoNao" value="false"><label for="inputEDirecaoNao">Não</label>
                </div>

                <div class="form-group col-auto">
                    <button type="submit" class="btn btn-success">Filtrar</button>
                </div>

            </div>
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
            <th>Membro da direção</th>
            <th>Profile Picture</th>
            <th></th>
            @can('updateAll', App\User::class)
            <th>Quotas</th>
            <th>Estado</th>
            @endcan

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
            <td>
                <div style="max-width: 100px;">
                @if ($user->foto_url != null)
                <img src="/storage/fotos/{{ $user->foto_url }}" alt="Profile Picture" width="100%">
                @else
                <img src="/storage/fotos/blank.jpg" alt="Empty Profile Picture" width="100%">
                @endif
                </div>
            </td>

            <td>
            <!-- fill with edit and delete actions -->
                @can('update', $user)
                    <a class="btn btn-primary btn-sm" href="{{route('users.edit',['id'=>$user->id])}}">
                        Editar
                    </a>
                @else
                    <span class="btn btn-secondary btn-sm disabled" >
                        Editar
                    </span>
                @endcan
                @can('delete', App\User::class)
                <form action="{{route('users.destroy',['id'=>$user->id])}}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-danger btn-sm" type="submit" value="Apagar"/>
                </form>
                @else
                    <span class="btn btn-secondary btn-sm disabled" >
                        Apagar
                    </span>
                @endcan
            </td>
            @can('updateAll', App\User::class)
            <td>
                <form  action=" {{route('quota.change', ['socio'=>$user->id])}} " method="post">
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
                <form  action=" {{route('ativo.change', ['socio'=>$user->id])}} " method="post">
                    @csrf
                    @method('PATCH')

                    @if ($user->ativo)
                        <input class="btn btn-success btn-sm" type="submit" value="Ativo"/>
                    @else
                        <input class="btn btn-danger btn-sm" type="submit" value="Não Ativo"/>
                    @endif
                </form>
            </td>
            @endcan
        </tr>
    @endforeach
    </table>
    {{$users->appends(request()->input())->links()}} <!--Paginate-->
@else
    <h2>No users found</h2>
@endif

@endsection
