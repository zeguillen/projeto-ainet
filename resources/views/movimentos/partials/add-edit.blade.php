<script>
    function changeType() {
        var select = document.getElementById("inputNatureza");
        var selected = select.options[select.selectedIndex].value;
        if(selected !== "I") {
            document.getElementById("camposInstrucao").style.display="none";
        } else {
            document.getElementById("camposInstrucao").style.display="block";
        }
    }
</script>

<div class="form-group">
    <label for="inputDataVoo">Data do voo</label>
    <input
        type="date" class="form-control"
        name="data" id="inputDataVoo"
        placeholder="Dia do voo" value="{{old('data',$movimento->data)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputHoraDescolagem">Hora descolagem</label>
    <input
        type="time" class="form-control"
        name="hora_descolagem" id="inputhoraDescolagem"
        value="{{ date('H:i', strtotime(old('hora_descolagem',$movimento->hora_descolagem))) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputHoraAterragem">Hora aterragem</label>
    <input
        type="time" class="form-control"
        name="hora_aterragem" id="inputhoraAterragem"
        value="{{ date('H:i', strtotime(old('hora_aterragem',$movimento->hora_aterragem))) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputAeronave">Aeronave</label>
    <select name="aeronave" id="inputAeronave" class="form-control" required>
        <option disabled selected>-- sele an option --</option>
        @foreach ($aeronaves as $aeronave)
        <option value="{{ $aeronave->matricula }}" {{ old('aeronave', $movimento->aeronave) == $aeronave->matricula ? "selected" : ""}}>{{ $aeronave->matricula }}</option>
        @endforeach
    </select>

</div>

<div class="form-group">
    <label for="inputNumDiario">Nº diario</label>
    <input
        type="number" class="form-control"
        name="num_diario" id="inputNumDiario"
        min="1"
        value="{{old('num_diario',$movimento->num_diario)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumServico">Nº servico</label>
    <input
        type="number" class="form-control"
        name="num_servico" id="inputNumServico"
        min="1"
        value="{{old('num_servico',$movimento->num_servico)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputPilotoId">Piloto</label>
    <select name="piloto_id" id="inputPilotoId" class="form-control">
        <option disabled selected> -- select an option -- </option>
        @if($movimento->piloto_id == null || $movimento->piloto_id)
        <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->nome_informal }}</option>
        @endif

        @foreach ($pilotos as $piloto)
        @unless($piloto->id == Auth::user()->id)
        <option value="{{ $piloto->id }}" {{ old('piloto', $movimento->piloto_id) == $piloto->id ? "selected" : "" }}>{{ $piloto->nome_informal }}</option>
        @endunless
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="inputNatureza">Natureza do voo</label>
    <select name="natureza" id="inputNatureza" class="form-control" onchange="changeType()">
        <option disabled selected> -- select an option -- </option>
        <option value="T" {{ old('natureza', $movimento->natureza) == 'T' ? "selected" : "" }}>Treino</option>
        <option value="I" {{ old('natureza', $movimento->natureza) == 'I' ? "selected" : "" }}>Instrução</option>
        <option value="E" {{ old('natureza', $movimento->natureza) == 'E' ? "selected" : "" }}>Especial</option>
    </select>
</div>

<div id="camposInstrucao">
    <div class="form-group">
        <label for="inputTipoInstrucao">Tipo de Instrução</label>
            <select name="tipo_instrucao" id="inputTipoInstrucao" class="form-control">
            <option disabled selected value> -- select an option -- </option>
            <option value="D" {{ old('tipo_instrucao', $movimento->tipo_instrucao) == 'D' ? "selected" : "" }}>Duplo Comando</option>
            <option value="S" {{ old('tipo_instrucao', $movimento->tipo_instrucao) == 'S' ? "selected" : "" }}>Solo</option>
        </select>
    </div>

    <div class="form-group">
        <label for="inputInstrutor">Instrutor</label>
        <select name="instrutor_id" id="inputInstrutor" class="form-control">
            <option disabled selected> -- select an option -- </option>
            @foreach ($pilotos as $piloto)
            @if ($piloto->tipo_licenca != 'ALUNO-PPL(A)' || $piloto->tipo_licenca != 'ALUNO-PU')
            <option value="{{ $piloto->id }}" {{ old('instrutor', $movimento->instrutor_id) == $piloto->id ? "selected" : "" }}>{{ $piloto->nome_informal }}</option>
            @endif
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="inputAerodromoPartida">Aerodromo de Partida</label>
    <select name="aerodromo_partida" id="inputAerodromoPartida" class="form-control" required>
        <option disabled selected>-- select an option --</option>
        @foreach ($aerodromos as $aerodromo)
        <option value="{{ $aerodromo->code }}" {{ old('aerodromo_partida', $movimento->aerodromo_partida) == $aerodromo->code ? "selected" : ""}}>{{ $aerodromo->code }} - {{ $aerodromo->nome }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="inputAerodromoChegada">Aerodromo de Chegada</label>
    <select name="aerodromo_chegada" id="inputAerodromoChegada" class="form-control" required>
        <option disabled selected>-- select an option --</option>
        @foreach ($aerodromos as $aerodromo)
        <option value="{{ $aerodromo->code }}" {{ old('aerodromo_chegada', $movimento->aerodromo_chegada) == $aerodromo->code ? "selected" : ""}}>{{ $aerodromo->code }} - {{ $aerodromo->nome }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="inputNumAterragens">Numero de aterragens</label>
    <input
        type="number" class="form-control"
        name="num_aterragens" id="inputNumAterragens"
        min="1"
        value="{{ old('num_aterragens', $movimento->num_aterragens) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumDescolagens">Numero de descolagens</label>
    <input
        type="number" class="form-control"
        name="num_descolagens" id="inputNumDescolagens"
        min="1"
        value="{{ old('num_descolagens', $movimento->num_descolagens) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumPessoas">Numero de pessoas a bordo</label>
    <input
        type="number" class="form-control"
        name="num_pessoas" id="inputNumPessoas"
        min="1"
        value="{{ old('num_pessoas', $movimento->num_pessoas) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputContaHorasInicial">Conta horas inicial</label>
    <input
        type="number" class="form-control"
        name="conta_horas_inicio" id="inputContaHorasInicial"
        min="1"
        value="{{ old('conta_horas_inicio', $movimento->conta_horas_inicio) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputContaHorasFinal">Conta horas final</label>
    <input
        type="number" class="form-control"
        name="conta_horas_fim" id="inputContaHorasFinal"
        min="1"
        value="{{ old('conta_horas_fim', $movimento->conta_horas_fim) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputTempoVoo">Tempo de voo</label>
    <input
        type="number" class="form-control"
        name="tempo_voo" id="inputTempoVoo"
        min="1"
        value="{{ old('tempo_voo', $movimento->tempo_voo) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputPrecoVoo">Preco do voo</label>
    <input
        type="number" class="form-control disabled"
        name="preco_voo" id="inputPrecoVoo"
        min="0" step="0.1"
        value="{{ old('preco_voo', $movimento->preco_voo) }}"
        disabled
    />
</div>

<div class="form-group">
    <label for="inputModoPagamento">Modo de pagamento</label>
    <select name="modo_pagamento" id="inputModoPagamento" class="form-control">
        <option disabled selected> -- selecione uma opção -- </option>
        <option value="N" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'N' ? "selected" : "" }}>Numerário</option>
        <option value="M" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'M' ? "selected" : "" }}>Multibanco</option>
        <option value="T" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'T' ? "selected" : "" }}>Transferência</option>
        <option value="P" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'P' ? "selected" : "" }}>Pacote de horas</option>
    </select>
</div>

<div class="form-group">
    <label for="inputNumRecibo">Numero de recibo</label>
    <input
        type="number" class="form-control"
        name="num_recibo" id="inputNumRecibo"
        min="1"
        value="{{ old('num_recibo', $movimento->num_recibo) }}"
        required
    />
</div>

<div class="alert alert-danger">
    <h6 class="alert-heading" style="font-weight: bold;">Aviso importante</h6>
    <hr>
    <p>Podem haver conflitos no conta-horas inicial e final. Certifique-se de que os valores estejam corretos. Caso o conflito persista, selecione seu tipo e justifique.</p>
</div>

<div class="form-group">
    <label for="inputTipoConflito">Tipo de Conflito</label>
    <select name="tipo_conflito" id="inputTipoConflito" class="form-control">
        <option disabled value selected>-- selecione uma opção --</option>
        <option value="S" {{ old('tipo_conflito', $movimento->tipo_conflito) == 'S' ? 'selected' : '' }}>Sobreposição</option>
        <option value="B" {{ old('tipo_conflito', $movimento->tipo_conflito) == 'B' ? 'selected' : '' }}>Buraco</option>
    </select>
</div>

<div class="form-group">
    <label for="inputJustificacao">Justificação</label>
<textarea name="justificacao_conflito" id="inputJustificacao" class="form-control" cols="30" rows="10">{{ old('justificacao_conflito', $movimento->justificacao_conflito)}}</textarea>
</div>
