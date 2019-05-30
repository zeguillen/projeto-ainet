@extends('layouts.app')
@section('title','List Movimentos')
@section('content')
    <form action="{{route('movimentos.estatisticas')}}" method="get" class="form-group">
        <div class="form-group">
            <label for="inputAno">Ano</label>
            <select name="ano" id="inputAno" class="form-control" >
                <option disabled selected> -- select an option -- </option>
                @foreach ($years as $year)
                    <option value="{{$year->year}}">{{$year->year}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Pesquisar</button>
        </div>
    </form>
    @if (isset($ano))
        <h2>{{$ano}}</h2>
        <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Mês</th>
                <?php
                    $lastAeronave = "";
                    foreach ($aeronaves_mes_ano as $aeronave_mes_ano) {
                        if ($lastAeronave != $aeronave_mes_ano->aeronave) {
                            $lastAeronave = $aeronave_mes_ano->aeronave;
                            echo "<th>$aeronave_mes_ano->aeronave</th>";
                        }
                    }
                ?>
            </tr>
        </thead>
        <tbody>   
            <?php 
                $maxMonth = 0;
                $minMonth = 12;
                foreach ($aeronaves_mes_ano as $aeronave_mes_ano) {
                    if($aeronave_mes_ano->mes > $maxMonth) {
                        $maxMonth = $aeronave_mes_ano->mes;
                    }
                    if($aeronave_mes_ano->mes < $minMonth) {
                        $minMonth = $aeronave_mes_ano->mes;
                    }     
                }
                
                for ($i = $minMonth; $i <= $maxMonth; $i++) {
                    echo "<tr>";
                    $mes = date("F", mktime(0, 0, 0, $i, 10));
                    echo "<td>$mes</td> ";
                    foreach ($aeronaves_mes_ano as $aeronave_mes_ano) {
                        if($aeronave_mes_ano->mes == $i) {
                            echo "<td>$aeronave_mes_ano->tempo horas</td> ";
                        }     
                    }  
                    echo "</tr>";         
                }
            ?>        
        </table>

        <div id="chart"></div>
        <?=$lava->render("ColumnChart", "HorasDeVoo", "chart");?>

    @endif

@endsection