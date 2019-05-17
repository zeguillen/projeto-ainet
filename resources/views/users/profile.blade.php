@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    <p>Nº Sócio: {{ Auth::user()->num_socio }}</p>
                    <p>Tipologia: {{ Auth::user()->tipo_socio }}</p>
                    <p>Nome Informal: {{ Auth::user()->nome_informal }}</p>
                    <p>Nome Complecto: {{ Auth::user()->name }}</p>
                    <p>Nome Complecto: {{ Auth::user()->sexo }}</p>
                    <p>Nome Complecto: {{ Auth::user()->data_nascimento }}</p>
                    <p>Nome Complecto: {{ Auth::user()->email }}</p>
                    <p>Nome Complecto: {{ Auth::user()->foto }}</p>
                    <p>Nome Complecto: {{ Auth::user()->nif }}</p>
                    <p>Nome Complecto: {{ Auth::user()->telefone }}</p>
                    <p>Endereço: {{ Auth::user()->endereco }}</p>
                    <p>Quotas em dia?: {{ Auth::user()->quota_paga }}</p>
                    <p>Sócio Ativo?: {{ Auth::user()->ativo }}</p>
                    <p>Pertence á direção?: {{ (Auth::user()->direcao == 1 ? 'Sim' : 'Não')}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
