@if ($user->num_socio != null)
<label>Número de Sócio:</label><p>{{old('>NumSocio',$user->num_socio)}}</p>
<br>

<label>Tipo de Sócio:</label>
    <p>
    @switch(old('TipoSocio',$user->tipo_socio))
    @case('P')
        Piloto
        @break

    @case('NP')
        Não Piloto
        @break

    @case('A')
        Aeromodelista
        @break
    @endswitch
    </p>
<br>
@endif
<div class="form-group">
    <label for="inputNomeInformal">Nome Informal</label>
    <input
        type="text" class="form-control"
        name="nome_informal" id="inputNomeInformal"
        placeholder="Nome Informal" value="{{old('nomeinformal',$user->nome_informal)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputFullname">Fullname</label>
    <input
        type="text" class="form-control"
        name="name" id="inputFullname"
        placeholder="Fullname" value="{{old('fullname',$user->name)}}"
        required
    />
</div>

<label>Sexo:</label>
    <p>
    @switch(old('Sexo',$user->sexo))
    @case('F')
        Feminino
        @break

    @case('M')
        Masculino
        @break
    @endswitch
    </p>
<br>

<div class="form-group">
    <label for="inputDataNascimento">Data Nascimento</label>
    <input
        type="date" class="form-control"
        name="data_nascimento" id="inputDataNascimento"
        placeholder="Data Nascimento" value="{{old('DataNascimento',$user->data_nascimento)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputType">Type</label>
    <select name="type" id="inputType" class="form-control">
        <?=$user->type?>
        <option disabled selected> -- select an option -- </option>
        <option value="0" {{ old('type', $user->tipo_socio) == 0 ? "selected" : "" }}>Piloto</option>
        <option value="1" {{ old('type', $user->tipo_socio) == 1 ? "selected" : "" }}>Não Piloto</option>
        <option value="2" {{ old('type', $user->tipo_socio) == 2 ? "selected" : "" }}>Direcção</option>
    </select>
</div>

<!--https://www.w3schools.com/tags/att_input_pattern.asp-->

<div class="form-group">
    <label for="inputEmail">Email</label>
    <input
        type="email" class="form-control"
        name="email" id="inputEmail"
        placeholder="Email address" value="{{old('email',$user->email)}}"
        required
    />
</div>


<div class="form-group">
    <label for="inputImage">Profile Picture</label>
    <input
        type="file" class="form-control"
        name="Image" id="inputImage"
    />
</div>

<div class="form-group">
    <div style="max-width: 100px;">
    @if ($user->foto_url != null)
    <img src="/storage/fotos/{{ $user->foto_url }}" alt="Profile Picture" width="100%">
    @else
    <img src="/storage/fotos/blank.jpg" alt="Empty Profile Picture" width="100%">
    @endif
    </div>
</div>

<div class="form-group">
    <label for="inputNIF">NIF</label>
    <input
        type="number" class="form-control"
        name="nif" id="inputNIF"
        placeholder="NIF" value="{{old('nif',$user->nif)}}"
        required
    />
</div>


<div class="form-group">
    <label for="inputTelefone">Telefone</label>
    <input
        type="tel" class="form-control"
        name="telefone" id="inputTelefone"
        placeholder="Telefone" value="{{old('telefone',$user->telefone)}}"
        required
        pattern="[0-9]{9}"
        title="Phone number must have 9 numbers"
    />
</div>

<div class="form-group">
    <label for="inputEndereco">Endereço</label>
    <input
        type="text" class="form-control"
        name="endereco" id="inputEndereco"
        placeholder="Endereço" value="{{old('endereco',$user->nome_informal)}}"
        required
    />
</div>

<label>Estado das quotas:</label><p>{{old('Quotas',$user->quota_paga) == 1 ? 'Em dia' : 'Não pagas'}}</p>
<br>

<label>Sócio Ativo?</label><p>{{old('Ativacao',$user->ativo) == 1 ? 'Sim' : 'Não'}}</p>
<br>

<label>Pertence á direção?</label><p>{{old('Direcao',$user->direcao) == 1 ? 'Sim' : 'Não'}}</p>
<br>

@can('viewPiloto', Auth::user())
<h5>Informação de Piloto</h5>
<label>Nº de licença</label><p>{{ old('num_licenca', $user->num_licenca) }}</p>
<label>Tipo de licença</label><p>{{ old('tipo_licenca', $user->tipo_licenca) }}</p>
<label>Pode dar instrução?</label><p>{{ old('instrutor', $user->instrutor) == 1 ? 'Sim' : 'Não' }}</p>

<h5>Certificado Médico</h5>
<label>Nº de certificado</label><p>{{ old('num_certificado', $user->num_certificado) }}</p>
<label>Classe de certificado</label><p>{{ old('classe_certificado', $user->classe_certificado) }}</p>
<label>Validade</label><p>{{ old('validade_certificado', $user->validade_certificado) }}</p>
<label>Certificado confirmado?</label><p>{{ old('certificado_confirmado', $user->certificado_confirmado) == 1 ? 'Sim' : 'Não' }}</p>
<label>Cópia Digital do Certificado</label>
<a class="btn btn-primary" href="{{route('ver.certificado', ['piloto'=>$user->id])}}">Ver certificado</a>
<a class="btn btn-primary" href="{{route('ver.certificado', ['piloto'=>$user->id])}}">Descarregar certificado</a>
@endcan