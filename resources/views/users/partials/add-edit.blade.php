<script>
    //função que carrega a imagem para a página
    function loadImage() {
        var preview = document.querySelector('img');
        var file    = document.querySelector('input[type=file]').files[0];
        var reader  = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    //piloto ou nao piloto
    function changeType() {
        var select = document.getElementById("inputTipoSocio");
        var selected = select.options[select.selectedIndex].value;
        if(selected !== "P") {
            document.getElementById("camposPiloto").style.display="none";
        } else {
            document.getElementById("camposPiloto").style.display="block";
        }
    }
</script>

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
@else
    <div class="form-group">
        <label for="inputTipoSocio">Tipo de sócio</label>
        <select name="tipo_socio" id="inputTipoSocio" class="form-control" onchange="changeType()">
            <option disabled selected> -- select an option -- </option>
            <option value="P" {{ old('type', $user->tipo_socio) == 'P' ? "selected" : "" }}>Piloto</option>
            <option value="NP" {{ old('type', $user->tipo_socio) == 'NP' ? "selected" : "" }}>Não Piloto</option>
            <option value="A" {{ old('type', $user->tipo_socio) == 'A' ? "selected" : "" }}>Aeromodelista</option>
        </select>
    </div>
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



@if ($user->num_socio == null)
    <div class="form-group">
        <label for="inputSexo">Sexo</label>
        <select name="sexo" id="inputSexo" class="form-control">
            <option disabled selected> -- select an option -- </option>
            <option value="F">Feminino</option>
            <option value="M">Masculino</option>
        </select>
    </div>
@else
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
@endif

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
    <label for="inputEmail">Email</label>
    <input
        type="email" class="form-control"
        name="email" id="inputEmail"
        placeholder="Email address" value="{{old('email',$user->email)}}"
        required
    />
</div>

<div class="form-group">
    <label id="userPhoto" for="inputImage">Profile Picture</label>
    <input
        type="file" class="form-control-file"
        name="image" id="inputImage"
        enctype='multipart/form-data'
        onchange='loadImage()'
    />
</div>

<div class="form-group">
    <div style="max-width: 100px;">
    @if ($user->foto_url != null)
    <img id="profilePicture" src="/storage/fotos/{{ $user->foto_url }}" alt="Profile Picture" width="100%">
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
        placeholder="Endereço" value="{{old('endereco',$user->endereco)}}"
        required
    />
</div>

@if ($user->num_socio != null)
    <label>Estado das quotas:</label><p>{{old('Quotas',$user->quota_paga) == 1 ? 'Em dia' : 'Não pagas'}}</p>
    <br>

    <label>Sócio Ativo?</label><p>{{old('Ativacao',$user->ativo) == 1 ? 'Sim' : 'Não'}}</p>
    <br>
@endif

@if ($user->num_socio == null)
    <div class="form-group">
        <label for="inputDirecao">Pertence á Direção?</label>
        <select name="direcao" id="inputDirecao" class="form-control">
            <option disabled selected> -- select an option -- </option>
            <option value="0">Não</option>
            <option value="1">Sim</option>
        </select>
    </div>
@else
    <label>Pertence á direção?</label><p>{{old('Direcao',$user->direcao) == 1 ? 'Sim' : 'Não'}}</p>
    <br>
@endif


@can('viewPiloto', Auth::user())
<div id="camposPiloto">
    <h5>Informação de Piloto</h5>

    @if (count($user->aeronaves) > 0)
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Aeronaves autorizadas para o piloto {{$user->name}}</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($user->aeronaves as $aeronave)
        <tr>
            <td>{{$aeronave->matricula}}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
    @else
    <div class="alert alert-secondary text-center" role="alert">
        Não existem aeronaves autorizadas para este piloto
    </div>
    @endif
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
        <select name="type" id="inputType" class="form-control">
            <option disabled selected> -- select an option -- </option>
            @foreach ($tipos_licencas as $tipo_licenca)
            <option value="{{ $tipo_licenca->code }}" {{ old('tipo_licenca', $user->tipo_licenca) == $tipo_licenca->code ? "selected" : ""}}>{{ $tipo_licenca->code }} - {{ $tipo_licenca->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Pode dar instrução?</label>
        <input
            type="text" class="form-control"
            value="{{ old('instrutor', $user->instrutor) == 1 ? 'Sim' : 'Não' }}" disabled
        />
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

    <div class="form-group">
        <label>Certificado confirmado?</label>
        <input
            type="text" class="form-control"
            value="{{ old('certificado_confirmado', $user->certificado_confirmado) == 1 ? 'Sim' : 'Não' }}"
            disabled
        />
    </div>

   
</div>
@endcan
