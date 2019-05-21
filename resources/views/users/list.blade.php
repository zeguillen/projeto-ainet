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
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Email</th>
            <th>Fullname</th>
            <th>Registered At</th>
            <th>Type</th>
            <th>Actions</th>
            <th>Quotas</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td> {{$user->email}}</td>
            <td> {{$user->name}} </td>
            <td> {{$user->created_at}} </td>
            <td> {{$user->typeToStr()}} </td>
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
    {{$users->links()}} <!--Paginate-->
@else
    <h2>No users found</h2>
@endif

@endsection