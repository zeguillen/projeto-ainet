@extends('layouts.app')
@section('title','List Movimentos')
@section('content')

<script type="text/javascript">
    function ocultarEstatistica(div) {
        var div = document.getElementById(div);
        if (div.style.display === "none") {
            div.style.display = "block";
        } else {
            div.style.display = "none";
        }
    }
</script>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@yield('title')</div>
                    <div class="card-body">
                        <form action="{{route('movimentos.estatisticas')}}" method="get" class="form-group">
                            <div class="form-row form-inline">
                                <div class="form-group col-auto">
                                    <label for="inputAno" class="mr-2">Ano</label>
                                    <select name="ano" id="inputAno" class="form-control" >
                                        <option disabled selected> -- select an option -- </option>
                                        @foreach ($years as $year)
                                            <option value="{{$year->year}}">{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                    @if(isset($piloto)) 
                                        <input type="hidden" name="piloto" value="{{$piloto}}">
                                    @endif
                                    @if(isset($pilotoTotal)) 
                                        <input type="hidden" name="pilotoTotal" value="{{$pilotoTotal}}">
                                    @endif
                                </div>
                                <div class="form-group col-auto">
                                    <button type="submit" class="btn btn-success">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                        <button onclick="ocultarEstatistica('SectionAeronaveMesAno')">Aeronaves por Mês e Ano</button>
                        <br><br>
                        <div id="SectionAeronaveMesAno">               
                            @if (isset($ano))
                                <h2>{{$ano}}</h2>
                                <table class="table table-striped">
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
                                    </tbody>                          
                                </table>
                                <div id="AeronaveMesAno"></div>
                                <?=\Lava::render("ColumnChart", "HorasAeronaveMesAno", "AeronaveMesAno");?>
                            @endif
                        </div>
                        <button onclick="ocultarEstatistica('SectionAeronaveAno')">Aeronaves por Ano</button>
                        <br><br>
                        <div id="SectionAeronaveAno">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Ano</th>
                                        <?php
                                            $lastAeronave = "";
                                            foreach ($aeronaves_ano as $aeronave_ano) {
                                                if ($lastAeronave != $aeronave_ano->aeronave) {
                                                    $lastAeronave = $aeronave_ano->aeronave;
                                                    echo "<th>$aeronave_ano->aeronave</th>";
                                                }
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php 
                                        $maxYear = 0;
                                        $minYear = date("Y");
                                       
                                        foreach ($aeronaves_ano as $aeronave_ano) {
                                            if($aeronave_ano->ano > $maxYear) {
                                                $maxYear = $aeronave_ano->ano;                 
                                            }
                                            if($aeronave_ano->ano < $minYear) {
                                                $minYear = $aeronave_ano->ano;         
                                            }     
                                        }

                                        for ($i = $maxYear; $i >= $minYear; $i--) {
                                            echo "<tr>";
                                            echo "<td>$i</td> ";
                                            foreach ($aeronaves_ano as $aeronave_ano) {
                                                if($aeronave_ano->ano == $i) {
                                                    echo "<td>$aeronave_ano->tempo horas</td> ";
                                                }     
                                            }  
                                            echo "</tr>";         
                                        }
                                    ?> 
                                </tbody>       
                            </table>
                            <div id="AeronaveAno"></div>
                            <?=\Lava::render("ColumnChart", "HorasAeronaveAno", "AeronaveAno");?>
                        </div>
                        <button onclick="ocultarEstatistica('SectionPilotosMesAno')">Pilotos por Mês e Ano</button>
                        <br><br>
                        <div id="SectionPilotosMesAno">
                            @if(isset($ano)) 
                                <form action="{{route('movimentos.estatisticas')}}" method="get" class="form-group">
                                        <div class="form-row form-inline">
                                        <div class="form-group col-auto">
                                            <label for="inputPilotos" class="mr-2">Pilotos</label>
                                            <select name="piloto" id="inputPilotos" class="form-control" >
                                                <option disabled selected> -- select an option -- </option>
                                                @foreach ($pilotos as $namePiloto)
                                                    <option value="{{$namePiloto->name}}">{{$namePiloto->name}}</option>
                                                @endforeach
                                            </select>
                                            @if(isset($ano)) 
                                                <input type="hidden" name="ano" value="{{$ano}}">
                                            @endif
                                            @if(isset($pilotoTotal)) 
                                                <input type="hidden" name="pilotoTotal" value="{{$pilotoTotal}}">
                                            @endif
                                        </div>

                                        <div class="form-group col-auto">
                                            <button type="submit" class="btn btn-success">Pesquisar</button>
                                        </div>
                                    </div>
                                </form>         
                            @endif
                            @if (isset($pilotos_mes_ano)and isset($ano)and isset($piloto))      
                                <h2>{{$ano}}</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mês</th>
                                            <th>Valor menor</th>
                                            <th>{{$piloto}}</th>
                                            <th>Valor maior</th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php 
                                            foreach ($pilotos_mes_ano as $piloto_mes_ano) {
                                                echo "<tr>";
                                                echo '<th>'.$piloto_mes_ano["mes"].'</th>';
                                                echo '<th>'.$piloto_mes_ano["menor"].'</th>';
                                                echo '<th>'.$piloto_mes_ano["tempo"].'</th>';
                                                echo '<th>'.$piloto_mes_ano["maior"].'</th>';
                                                echo "</tr>";    
                                            } 
                                        ?>   
                                    </tbody>                          
                                </table>
                                <div id="PilotoMesAno"></div>
                                <?=\Lava::render("ColumnChart", "HorasPilotoMesAno", "PilotoMesAno");?>
                            @endif
                        </div>
                    <button onclick="ocultarEstatistica('SectionPilotosAno')">Pilotos por Ano</button>
                        <br><br>
                        <div id="SectionPilotosAno">
                            <form action="{{route('movimentos.estatisticas')}}" method="get" class="form-group">
                                    <div class="form-row form-inline">
                                    <div class="form-group col-auto">
                                        <label for="inputPilotoTotal" class="mr-2">Pilotos Todos</label>
                                        <select name="pilotoTotal" id="inputPilotoTotal" class="form-control" >
                                            <option disabled selected> -- select an option -- </option>
                                            @foreach ($pilotosTotal as $namePilotoTotal)
                                                <option value="{{$namePilotoTotal->name}}">{{$namePilotoTotal->name}}</option>
                                            @endforeach
                                        </select>
                                        @if(isset($ano)) 
                                            <input type="hidden" name="ano" value="{{$ano}}">
                                        @endif
                                        @if(isset($piloto)) 
                                            <input type="hidden" name="piloto" value="{{$piloto}}">
                                        @endif
                                    </div>
                                    <div class="form-group col-auto">
                                        <button type="submit" class="btn btn-success">Pesquisar</button>
                                    </div>
                                </div>
                            </form>  
                            @if (isset($pilotos_ano)and isset($pilotoTotal)) 
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ano</th>
                                            <th>Valor menor</th>
                                            <th>{{$pilotoTotal}}</th>
                                            <th>Valor maior</th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php 
                                            foreach (array_reverse($pilotos_ano) as $piloto_ano) {
                                                echo "<tr>";
                                                echo '<th>'.$piloto_ano["ano"].'</th>';
                                                echo '<th>'.$piloto_ano["menor"].'</th>';
                                                echo '<th>'.$piloto_ano["tempo"].'</th>';
                                                echo '<th>'.$piloto_ano["maior"].'</th>';
                                                echo "</tr>";    
                                            } 
                                        ?>   
                                    </tbody>                          
                                </table>
                                <div id="PilotoAno"></div>
                                <?=\Lava::render("ColumnChart", "HorasPilotoAno", "PilotoAno");?>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection