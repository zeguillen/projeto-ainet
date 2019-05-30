@if ($aeronave->matricula != null)
<div class="form-group">
    <label>Matricula</label>
    <input type="text" class="form-control disabled" disabled value="{{old('matricula', $aeronave->matricula)}}">
</div>
@endif
<div class="form-group">
    <label for="inputMarca">Marca</label>
    <input 
        type="text" class="form-control"
        name="marca" id="inputMarca"
        placeholder="Marca" value="{{old('marca', $aeronave->marca)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputModelo">Modelo</label>
    <input 
        type="text" class="form-control"
        name="modelo" id="inputModelo"
        placeholder="Modelo" value="{{old('modelo', $aeronave->modelo)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputNumLugares">Nº de lugares</label>
    <input 
        type="text" class="form-control"
        name="num_lugares" id="inputNumLugares"
        placeholder="Nº de lugares" value="{{old('num_lugares', $aeronave->num_lugares)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputContaHoras">Conta Horas</label>
    <input 
        type="text" class="form-control"
        name="conta_horas" id="inputContaHoras"
        placeholder="Conta Horas" value="{{old('conta_horas', $aeronave->conta_horas)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputPrecoHora">Preco por hora</label>
    <input 
        type="text" class="form-control"
        name="preco_hora" id="inputPrecoHora"
        placeholder="Preco por hora" value="{{old('preco_hora', $aeronave->preco_hora)}}"
        required
    />
</div>