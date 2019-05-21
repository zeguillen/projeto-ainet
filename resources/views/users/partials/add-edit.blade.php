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

<!--       'num_socio', 'nome_informal', 'name', 'sexo', 'data_nascimento', 'email', 'foto', 'nif', 'telefone', 
        'endereco', 'tipo_socio', 'quota_paga', 'ativo', 'password_inicial', 'password','direcao'-->

<div class="form-group">
    <label for="inputNomeInformal">Nome Informal</label>
    <input
        type="text" class="form-control"
        name="nomeinformal" id="inputNomeInformal"
        placeholder="Nome Informal" value="{{old('nomeinformal',$user->nome_informal)}}"
        required
        pattern="^[a-zA-Z\s]*$"
        title="Fullname must only contain letters and numbers"
    />
</div>

<div class="form-group">
    <label for="inputFullname">Fullname</label>
    <input
        type="text" class="form-control"
        name="fullname" id="inputFullname"
        placeholder="Fullname" value="{{old('fullname',$user->name)}}"
        required
        pattern="^[a-zA-Z\s]*$"
        title="Fullname must only contain letters and numbers"
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

    @default
        Indiferenciado
    @endswitch
    </p>
<br>

<!--<div class="form-group">
    <label for="inputType">Type</label>
    <select name="type" id="inputType" class="form-control">
        <?=$user->type?>
        <option disabled selected> -- select an option -- </option>
        <option value="0" {{ old('type', $user->tipo_socio) == 0 ? "selected" : "" }}>Piloto</option>
        <option value="1" {{ old('type', $user->tipo_socio) == 1 ? "selected" : "" }}>Não Piloto</option>
        <option value="2" {{ old('type', $user->tipo_socio) == 2 ? "selected" : "" }}>Direcção</option>
    </select>
</div>-->


<div class="form-group">
    <label for="inputEmail">Email</label>
    <input
        type="email" class="form-control"
        name="email" id="inputEmail"
        placeholder="Email address" value="{{old('email',$user->email)}}"
        required
        pattern="^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$"
        title="Email must be valid"
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
    <img src="/storage/fotos/{{ $user->foto_url }}" alt="Profile Picture" width="10%">
</div>