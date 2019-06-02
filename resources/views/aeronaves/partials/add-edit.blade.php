<div class="form-group">
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Matricula</th>
            <th>Unidade do conta-horas</th>
            <th>Minutos</th>
            <th>Preço</th>
        </tr>
    </thead>
    <tbody>
        @foreach($aeronaves_valores as $aeronave_valor)
        <tr>
            <td>{{$aeronave_valor->matricula}}</td>
            <td>{{$aeronave_valor->unidade_conta_horas}}</td>
            <td>{{$aeronave_valor->minutos}}</td>
            <td>{{$aeronave_valor->preco}}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
    {{$aeronaves_valores->links()}}
</div>
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
        type="number" class="form-control"
        name="num_lugares" id="inputNumLugares"
         min="1"
        placeholder="Nº de lugares" value="{{old('num_lugares', $aeronave->num_lugares)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputContaHoras">Conta Horas</label>
    <input
        type="number" class="form-control"
        name="conta_horas" id="inputContaHoras"
        min="0"
        placeholder="Conta Horas" value="{{old('conta_horas', $aeronave->conta_horas)}}"
        required
    />
</div>

<div class="form-group">
    <label for="inputPrecoHora">Preco por hora</label>
    <input
        type="number" class="form-control"
        name="preco_hora" id="inputPrecoHora"
        min="0" step="0.10"
        placeholder="Preco por hora" value="{{old('preco_hora', $aeronave->preco_hora)}}"
        required
    />
</div>
