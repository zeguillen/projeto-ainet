@extends('layouts.app')
@section('title','Adicionar sócio')
@section('content')

@if ($errors->any())
    @include('common.errors')
@endif

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@yield('title')</div>
                <div class="card-body">
                    <form action="{{route('users.store')}}" method="post" class="form-group">
                        @csrf
                        @method('POST')
                        @include('users.partials.add-edit')

                        @if($user->id == null)
                        <div id="camposPiloto" style="display: none">
                            <h5>Informação de Piloto</h5>

                            <div class="form-group">
                                <label for="inputNumLicenca">Nº de licença</label>
                                <input
                                    type="number" class="form-control"
                                    name="num_licenca" id="inputNumLicenca"
                                    placeholder="Número da licença" value="{{ old('num_licenca', $user->num_licenca) }}"
                                />

                            </div>

                            <div class="form-group">
                                <label>Tipo de licença</label>
                                <select name="tipo_licenca" id="inputTipoLicenca" class="form-control">
                                    <option disabled selected> -- select an option -- </option>
                                    @foreach ($tipos_licencas as $tipo_licenca)
                                    <option value="{{ $tipo_licenca->code }}" {{ old('tipo_licenca', $user->tipo_licenca) == $tipo_licenca->code ? "selected" : ""}}>{{ $tipo_licenca->code }} - {{ $tipo_licenca->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pode dar instrução?</label>
                                <select name="instrutor" id="inputInstrutor" class="form-control">
                                    <option disabled selected> -- selecione uma opção --</option>
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>

                            </div>

                            <h5>Certificado Médico</h5>
                            <div class="form-group">
                                <label for="inputNumCertificado">Nº do certificado</label>
                                <input
                                    type="text" class="form-control"
                                    name="num_certificado" id="inputNumCertificado"
                                    placeholder="Número do certificado" value="{{ old('num_certificado', $user->num_certificado) }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="inputClasseCertificado">Classe de certificado</label>
                                <select name="classe_certificado" id="inputClasseCertificado" class="form-control">
                                <option disabled selected> -- select an option -- </option>
                                @foreach ($classes_certificados as $classe_certificado)
                                <option value="{{ $classe_certificado->code }}" {{ old('classe_certificado', $user->classe_certificado) == $classe_certificado->code ? "selected" : ""}}>{{ $classe_certificado->code }} - {{ $classe_certificado->nome }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputValidadeCertificado">Validade</label>
                                <input
                                    type="date" class="form-control"
                                    name="validade_certificado" id="inputValidadeCertificado"
                                    placeholder="Validade do certificado" value="{{ old('validade_certificado', $user->validade_certificado) }}"
                                />
                            </div>

                        </div>
                        @endif
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input
                                type="password" class="form-control"
                                name="password" id="inputPassword"
                                value="{{old('password',$user->password)}}"
                                required
                                minlength="8"
                            />
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordConfirmation">Password confirmation</label>
                            <input
                                type="password" class="form-control"
                                name="password_confirmation" id="inputPasswordConfirmation"
                                required
                                minlength="8"
                            />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" name="ok">Adicionar sócio</button>
                            <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
                            <!-- <button type="submit" class="btn btn-default" name="cancel">Cancel</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
