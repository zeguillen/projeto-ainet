
<div class="form-group">
    <label for="inputDataVoo">Data do voo</label>
    <input
        type="date" class="form-control"
        name="DataVoo" id="inputDataVoo"
        placeholder="Dia do voo" value="{{old('data',$movimento->data)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputHoraDescolagem">Hora descolagem</label>
    <input
        type="time" class="form-control"
        name="horaDescolagem" id="inputhoraDescolagem"
        value="{{old('hora_descolagem',$movimento->hora_descolagem)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputHoraAterragem">Hora aterragem</label>
    <input
        type="time" class="form-control"
        name="horaAterragem" id="inputhoraAterragem"
        value="{{old('hora_aterragem',$movimento->hora_aterragem)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputAeronave">Aeronave</label>
    <input
        type="text" class="form-control"
        name="aeronave" id="inputAeronave"
        value="{{old('aeronave',$movimento->aeronave)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumDiario">Nº diario</label>
    <input
        type="text" class="form-control"
        name="numDiario" id="inputNumDiario"
        value="{{old('num_diario',$movimento->num_diario)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumServico">Nº servico</label>
    <input
        type="text" class="form-control"
        name="numServico" id="inputNumServico"
        value="{{old('num_servico',$movimento->num_servico)}}"
        required
    />
</div>

<div class="form-group">
    <label for="InputPilotoId">Piloto</label>
    <input
        type="text" class="form-control"
        name="pilotoId" id="inputPilotoId"
        value="{{ Auth::user()->id }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNatureza">Natureza do voo</label>
    <select name="type" id="inputNatureza" class="form-control">
        <option disabled selected> -- select an option -- </option>
        <option value="0" {{ old('natureza', $movimento->natureza) == 'T' ? "selected" : "" }}>Treino</option>
        <option value="1" {{ old('natureza', $movimento->natureza) == 'I' ? "selected" : "" }}>Instrução</option>
        <option value="2" {{ old('natureza', $movimento->natureza) == 'E' ? "selected" : "" }}>Especial</option>
    </select>
</div>

<div class="form-group">
    <label for="inputAerodromoPartida">Aerodromo de Partida</label><br>
    @if ($movimento->id != null)
    <span>{{ old('aerodromo_partida', $movimento->aerodromoPartida->nome) }}</span>
    @endif
    <input
        type="text" class="form-control"
        name="aerodromoPartida" id="inputAerodromoPartida"
        value="{{ old('aerodromo_partida', $movimento->aerodromo_partida) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputAerodromoChegada">Aerodromo de Chegada</label><br>
    @if ($movimento->id != null)
    <span>{{ old('aerodromo_partida', $movimento->aerodromoChegada->nome) }}</span>
    @endif
    <input
        type="text" class="form-control"
        name="aerodromoChegada" id="inputAerodromoChegada"
        value="{{ old('aerodromo_chegada', $movimento->aerodromo_chegada) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumAterragens">Numero de aterragens</label>
    <input
        type="number" class="form-control"
        name="numAterragens" id="inputNumAterragens"
        value="{{ old('num_aterragens', $movimento->num_aterragens) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumDescolagens">Numero de descolagens</label>
    <input
        type="number" class="form-control"
        name="numDescolagens" id="inputNumDescolagens"
        value="{{ old('num_descolagens', $movimento->num_descolagens) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumPessoas">Numero de pessoas a bordo</label>
    <input
        type="number" class="form-control"
        name="numPessoas" id="inputNumPessoas"
        value="{{ old('num_pessoas', $movimento->num_pessoas) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputContaHorasInicial">Conta horas inicial</label>
    <input
        type="number" class="form-control"
        name="contaHorasInicial" id="inputContaHorasInicial"
        value="{{ old('conta_horas_inicio', $movimento->conta_horas_inicio) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputContaHorasFinal">Conta horas final</label>
    <input
        type="number" class="form-control"
        name="contaHorasFinal" id="inputContaHorasFinal"
        value="{{ old('conta_horas_fim', $movimento->conta_horas_fim) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputTempoVoo">Tempo de voo</label>
    <input
        type="number" class="form-control"
        name="tempoVoo" id="inputTempoVoo"
        value="{{ old('tempo_voo', $movimento->tempo_voo) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputPrecoVoo">Preco de voo</label>
    <input
        type="number" class="form-control"
        name="precoVoo" id="inputPrecoVoo"
        value="{{ old('preco_voo', $movimento->preco_voo) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputModoPagamento">Modo de pagamento</label>
    <select name="type" id="inputModoPagamento" class="form-control">
        <option disabled selected> -- selecione uma opção -- </option>
        <option value="0" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'N' ? "selected" : "" }}>Numerário</option>
        <option value="1" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'M' ? "selected" : "" }}>Multibanco</option>
        <option value="2" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'T' ? "selected" : "" }}>Transferência</option>
        <option value="3" {{ old('modo_pagamento', $movimento->modo_pagamento) == 'P' ? "selected" : "" }}>Pacote de horas</option>
    </select>
</div>

<div class="form-group">
    <label for="inputNumRecibo">Numero de recibo</label>
    <input
        type="number" class="form-control"
        name="numRecibo" id="inputNumRecibo"
        value="{{ old('num_recibo', $movimento->num_recibo) }}"
        required
    />
</div>

<div class="form-group">
    <label for="inputObs">Observações</label>
    <input
        type="textarea" class="form-control"
        name="obs" id="inputObs"
        value="{{ old('observacoes', $movimento->observacoes) }}"
    />
</div>











