<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Aeronave;
use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MovimentoUpdateRequest;
use App\Http\Requests\MovimentoStorageRequest;

class MovimentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimento::query();
        if($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if($request->filled('aeronave')) {
            $query->where('aeronave', $request->aeronave);
        }
        if($request->filled('piloto')) {
            $ids = DB::table('users')->where('nome_informal', 'LIKE', $request->piloto . '%')->pluck('id');
            $query->whereIn('piloto_id', $ids);
        }
        if($request->filled('instrutor')) {
            $ids = DB::table('users')->where('instrutor', 'LIKE', $request->instrutor . '%')->pluck('id');
            $query->whereIn('instrutor_id', $ids);
        }
        if(($request->filled('data_inf')) && ($request->filled('data_sup')))  {
            $query->where('data', '>=', $request->data_inf)->where('data', '<=', $request->data_sup);
        }
        if(!($request->filled('data_inf')) && ($request->filled('data_sup')))  {
            $query->where('data', '<=', $request->data_sup);
        }
        if(($request->filled('data_inf')) && !($request->filled('data_sup')))  {
            $query->where('data', '>=', $request->data_inf);
        }
        if($request->filled('confirmado')) {
            if($request->confirmado == "true") {
                $query->where('confirmado', 1);
            } else {
                $query->where('confirmado', 0);
            }
        }
        if($request->filled('meu')) {
            if($request->meu == "true") {
                $query->where('piloto_id', Auth::user()->id)->orWhere('instrutor_id', Auth::user()->id);
            }
        }
        if(($request->natureza != "none") && ($request->filled('natureza'))) {
            switch ($request->natureza) {
                case 'treino':
                    $type = "T";
                    break;
                case 'instrucao':
                    $type = "I";
                    break;
                case 'especial':
                    $type = "E";
                    break;
            }
            $query->where('natureza', $type);
        }

        $movimentos = $query->orderBy('id', 'asc')->paginate(5);

        return view('movimentos.list', compact('movimentos'));
    }

    public function create()
    {
        $movimento = new Movimento;
        $aeronaves = DB::table('aeronaves')->select('matricula', 'marca', 'modelo')->get();
        $aerodromos = DB::table('aerodromos')->select('code', 'nome')->get();
        $aeronaves_pilotos = DB::table('aeronaves_pilotos')->select('matricula', 'piloto_id')->get();
        $pilotos = DB::table('users')->select('id', 'nome_informal', 'tipo_licenca')->where('tipo_socio', 'P')->get();

        return view('movimentos.add', compact('movimento', 'aeronaves', 'aerodromos', 'aeronaves_pilotos', 'pilotos'));
    }

    public function store(MovimentoStorageRequest $request, User $socio)
    {
        $this->authorize('create', $socio);

        $validated = $request->validated();
        $piloto = User::findOrFail($request->piloto_id);

        // Se houver instrutor
        if($request->natureza == 'I'){
            $instrutor = User::findOrFail($request->instrutor_id);
        }

        // Verificar piloto e instrutor
        if($request->piloto_id == $request->instrutor_id){
            return redirect()->back()->withErrors(['O instrutor e o piloto não podem ser iguais']);
        }

        // Verificar se o piloto esta autorizado para a aeronave
        foreach($piloto->aeronavesPiloto as $aeronavePiloto){
            if(($request->aeronave != $aeronavePiloto->pivot->matricula) && ($piloto->id != $aeronavePiloto->pivot->piloto_id)){
                return redirect()->back()->withErrors(['O piloto selecionado não se encontra autorizado para pilotar a aeronave selecionada']);
            }
        }

        if($request->instrutor_id != null){
            $instrutor = User::find($request->instrutor_id);

            // Verifica se o instrutor esta autorizado
            foreach($instrutor->aeronavesPiloto as $aeronavePiloto){
                if(($request->aeronave != $aeronavePiloto->pivot->matricula) && ($piloto->id != $aeronavePiloto->pivot->piloto_id)){
                    return redirect()->back()->withErrors(['O instrutor selecionado não se encontra autorizado para pilotar a aeronave selecionada']);
                }
            }
        }

        $movimento = new Movimento;

        $movimento->fill($request->except('preco_voo', 'hora_aterragem', 'hora_descolagem', 'num_licenca_piloto', 'tipo_licenca_piloto', 'validade_certificado_piloto', 'classe_certificado_piloto', 'validade_certificado_piloto', 'confirmado'));

        //guardar sem confirmar o movimento OU guardar e confirmar o movimento
        switch($request->input('inputAdicionar')) {
            case 'add':
                $movimento->confirmado = 0;
                break;
            case 'confirmar':
                $movimento->confirmado = 1;
                break;
        }

        $aeronaves_valores = DB::select('select * from aeronaves_valores where matricula = :matricula', ['matricula' => $request->aeronave]);
        $total_horas = $request->conta_horas_fim - $request->conta_horas_inicio;

        foreach($aeronaves_valores as $aeronave_valor){
            if($aeronave_valor->unidade_conta_horas >= $total_horas){
                $movimento->preco_voo = $aeronave_valor->preco;
            }
        }

        $movimento->hora_descolagem = date('Y-m-d H:i', strtotime($request->data .' '.$request->hora_descolagem));
        $movimento->hora_aterragem = date('Y-m-d H:i', strtotime($request->data .' '.$request->hora_aterragem));

        $movimento->num_licenca_piloto = $piloto->num_licenca;
        $movimento->tipo_licenca_piloto = $piloto->tipo_licenca;
        $movimento->validade_licenca_piloto = $piloto->validade_licenca;
        $movimento->num_certificado_piloto = $piloto->num_certificado;
        $movimento->classe_certificado_piloto = $piloto->classe_certificado;
        $movimento->validade_certificado_piloto = $piloto->validade_certificado;


        $movimento->save();

        return redirect()->route('movimentos.index')->with('success', "Movimento criado com sucesso");
    }

    public function edit(Movimento $movimento)
    {
        $this->authorize('view', $movimento);
        // $movimento = Movimento::findOrFail($movimento->id);

        $aeronaves = DB::table('aeronaves')->select('matricula', 'marca', 'modelo')->get();
        $aerodromos = DB::table('aerodromos')->select('code', 'nome')->get();
        $pilotos = DB::table('users')->select('id', 'nome_informal', 'tipo_licenca')->where('tipo_socio', 'P')->get();

        return view('movimentos.edit', compact('movimento', 'aeronaves', 'aerodromos', 'pilotos'));
    }

    public function update(MovimentoUpdateRequest $request, Movimento $movimento)
    {
        $this->authorize('update', Auth::user(), $movimento);

        $validated = $request->validated();

        if($request->aeronave != null){
            $aeronave = Aeronave::findOrFail($request->aeronave);
        }


        // IMPLEMENTAR NO CREATE
        // Validar piloto e instrutor
        if($request->piloto_id == $request->instrutor_id){
            return redirect()->back()->withErrors(['O instrutor e o piloto não podem ser iguais']);
        }

        if($request->piloto_id != null){
            $piloto = User::findOrFail($request->piloto_id);

            // Verificar se o piloto esta autorizado para a aeronave
            foreach($piloto->aeronavesPiloto as $aeronavePiloto){
                if(($request->aeronave != $aeronavePiloto->pivot->matricula) && ($request->piloto_id != $aeronavePiloto->pivot->piloto_id)){
                    return redirect()->back()->withErrors(['O piloto selecionado não se encontra autorizado para pilotar a aeronave selecionada.']);
                }
            }
        }


        if($request->instrutor_id != null){
            $instrutor = User::find($request->instrutor_id);

            // Verifica se o instrutor esta autorizado
            foreach($instrutor->aeronavesPiloto as $aeronavePiloto){
                if(($request->aeronave != $aeronavePiloto->pivot->matricula) && ($piloto->id != $aeronavePiloto->pivot->piloto_id)){
                    return redirect()->back()->withErrors(['O piloto selecionado não se encontra autorizado para pilotar a aeronave selecionada']);
                }
            }
        }

        //guardar sem confirmar o movimento OU guardar e confirmar o movimento
        switch($request->input('gravar')) {
            case 'guardar':
                $movimento->fill($request->except('hora_descolagem', 'hora_aterragem', 'preco_voo'));
                break;
            case 'confirmar':
                $movimento->fill($request->except('hora_descolagem', 'hora_aterragem', 'preco_voo', 'confirmado'));
                $movimento->confirmado = 1;
                break;
        }

        $movimento->hora_descolagem = date('Y-m-d H:i', strtotime($request->data .' '.$request->hora_descolagem));
        $movimento->hora_aterragem = date('Y-m-d H:i', strtotime($request->data .' '.$request->hora_aterragem));

        $aeronaves_valores = DB::select('select * from aeronaves_valores where matricula = :matricula', ['matricula' => $request->aeronave]);

        $total_horas = $request->conta_horas_fim - $request->conta_horas_inicio;

        foreach($aeronaves_valores as $aeronave_valor){
            if($aeronave_valor->unidade_conta_horas >= $total_horas){
                $movimento->preco_voo = $aeronave_valor->preco;
            }
        }


        $movimento->save();

        return redirect()->route('movimentos.index')->with('success', "Movimento autalizado com sucesso!");
    }

    public function destroy(Movimento $movimento)
    {
        $this->authorize('delete', Auth::user(), $movimento);

        $movimento = Movimento::findOrFail($movimento->id);

        if($movimento->confirmado) {
            return redirect()->route('movimentos.index')->with('errors',"Movimento já confirmado return ($movimento->confirmado == 0) && ($movimento->piloto_id == $user->id || $movimento->instrutor_id == $user->id);view! Não é possivel eliminar");
        }

        $movimento->delete();
        return redirect()->route('movimentos.index')->with('success',"Movimento eliminado com sucesso");
    }

    public function estatisticas(Request $request)
    {
        $years = DB::select('SELECT DISTINCT YEAR(data) AS "year" FROM movimentos ORDER BY YEAR(data) DESC');
        $pilotosTotal = DB::select('SELECT DISTINCT users.name FROM movimentos JOIN users ON movimentos.piloto_id = users.id');

        //primeiro aeronave mes ano

        if ($request->filled('ano')) {
            $aeronaves_mes_ano = DB::select('SELECT SUM(tempo_voo) AS "tempo", MONTH(data) AS "mes", aeronave FROM movimentos WHERE YEAR(data) = "'.$request->ano.'" GROUP BY aeronave, MONTH(data)');

            $ano = $request->ano;

            //chart ------------------------------------------------------------

            $horasAeronaveMesAno = \Lava::DataTable();

            $horasAeronaveMesAno->addStringColumn('Mês');

            $aeronaves = DB::select('SELECT DISTINCT aeronave FROM movimentos WHERE YEAR(data) = "'.$request->ano.'"');
            foreach ($aeronaves as $aeronave) {
                $horasAeronaveMesAno->addNumberColumn($aeronave->aeronave);
            }

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

            $data = [];
            for ($i = $minMonth; $i <= $maxMonth; $i++) {
                array_push($data, date("F", mktime(0, 0, 0, $i, 10)));
                foreach ($aeronaves_mes_ano as $aeronave_mes_ano) {
                    if($aeronave_mes_ano->mes == $i) {
                        array_push($data, $aeronave_mes_ano->tempo);
                    }
                }
                $horasAeronaveMesAno->addRow($data);
                $data = [];
            }

            \Lava::ColumnChart('HorasAeronaveMesAno', $horasAeronaveMesAno, [
                'title' => 'Horas de Voo',
                'titleTextStyle' => [
                    'color'    => '#eb6b2c',
                    'fontSize' => 14
                ]
            ]);

            //--------------------------------------------------------
        }

        //segundo aeronave ano
        $aeronaves_ano = DB::select('SELECT SUM(tempo_voo) AS "tempo", YEAR(data) AS "ano", aeronave FROM movimentos GROUP BY aeronave, YEAR(data)');

        //chart ------------------------------------------------------------

        $horasAeronaveAno = \Lava::DataTable();

        $horasAeronaveAno->addStringColumn('Ano');

        $aeronaves = DB::select('SELECT DISTINCT aeronave FROM movimentos');
        foreach ($aeronaves as $aeronave) {
            $horasAeronaveAno->addNumberColumn($aeronave->aeronave);
        }

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

        $data = [];
        for ($i = $minYear; $i <= $maxYear; $i++) {
            array_push($data, $i);
            foreach ($aeronaves_ano as $aeronave_ano) {
                if($aeronave_ano->ano == $i) {
                    array_push($data, $aeronave_ano->tempo);
                }
            }
            $horasAeronaveAno->addRow($data);
            $data = [];
        }

        \Lava::ColumnChart('HorasAeronaveAno', $horasAeronaveAno, [
            'title' => 'Horas de Voo',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

        //--------------------------------------------------------

        //terceiro piloto mes ano

        if ($request->filled('ano', 'piloto')) {
            $ano = $request->ano;
            $id_piloto = DB::select("SELECT id FROM users WHERE name = '".$request->piloto."' LIMIT 1");
            $mesesDoPiloto = DB::select('SELECT DISTINCT MONTH(data) AS "mes" FROM movimentos WHERE piloto_id = '.$id_piloto[0]->id.' AND YEAR(data) = "'.$ano.'" ORDER BY mes');

            //chart ------------------------------------------------------------
            $horasPilotoMesAno = \Lava::DataTable();
            $horasPilotoMesAno->addStringColumn('Mês');
            $horasPilotoMesAno->addNumberColumn("Tempo Menor");
            $horasPilotoMesAno->addNumberColumn($request->piloto);
            $horasPilotoMesAno->addNumberColumn("Tempo Maior");

            $pilotos_mes_ano = [];
            foreach ($mesesDoPiloto as $meses) {
                $mes = $meses->mes;
                $tempo_menor = DB::select("SELECT SUM(tempo_voo) AS tempo FROM movimentos WHERE MONTH(data) = ".$mes." AND YEAR(data) = ".$ano." GROUP BY piloto_id ORDER BY tempo limit 1");
                $tempo_maior = DB::select("SELECT SUM(tempo_voo) AS tempo FROM movimentos WHERE MONTH(data) = ".$mes." AND YEAR(data) = ".$ano." GROUP BY piloto_id ORDER BY tempo DESC limit 1");
                $tempo_piloto = DB::select("SELECT SUM(tempo_voo) AS tempo FROM movimentos WHERE MONTH(data) = ".$mes." AND YEAR(data) = ".$ano." AND piloto_id = ".$id_piloto[0]->id." GROUP BY piloto_id");


                $horasPilotoMesAno->addRow([date("F", mktime(0, 0, 0, $mes, 10)), $tempo_menor[0]->tempo, $tempo_piloto[0]->tempo, $tempo_maior[0]->tempo]);

                array_push($pilotos_mes_ano, ["mes" => $mes, "menor" => $tempo_menor[0]->tempo, "tempo" => $tempo_piloto[0]->tempo, "maior" => $tempo_maior[0]->tempo]);

            }

            \Lava::ColumnChart('HorasPilotoMesAno', $horasPilotoMesAno, [
                'title' => 'Horas de Voo',
                'titleTextStyle' => [
                    'color'    => '#eb6b2c',
                    'fontSize' => 14
                ]
            ]);

            //--------------------------------------------------------

        }

        //quarto piloto ano

        if ($request->filled('pilotoTotal')) {
            $id_piloto = DB::select("SELECT id FROM users WHERE name = '".$request->pilotoTotal."' LIMIT 1");
            $anosDoPiloto = DB::select('SELECT DISTINCT YEAR(data) AS "ano" FROM movimentos WHERE piloto_id = '.$id_piloto[0]->id.' ORDER BY ano');

            //chart ------------------------------------------------------------
            $horasPilotoAno = \Lava::DataTable();
            $horasPilotoAno->addStringColumn('Ano');
            $horasPilotoAno->addNumberColumn("Tempo Menor");
            $horasPilotoAno->addNumberColumn($request->pilotoTotal);
            $horasPilotoAno->addNumberColumn("Tempo Maior");

            $pilotos_ano = [];
            foreach ($anosDoPiloto as $anos) {
                $ano = $anos->ano;
                $tempo_menor = DB::select("SELECT SUM(tempo_voo) AS tempo FROM movimentos WHERE YEAR(data) = ".$ano." GROUP BY piloto_id ORDER BY tempo limit 1");
                $tempo_maior = DB::select("SELECT SUM(tempo_voo) AS tempo FROM movimentos WHERE YEAR(data) = ".$ano." GROUP BY piloto_id ORDER BY tempo DESC limit 1");
                $tempo_piloto = DB::select("SELECT SUM(tempo_voo) AS tempo FROM movimentos WHERE YEAR(data) = ".$ano." AND piloto_id = ".$id_piloto[0]->id." GROUP BY piloto_id");

                $horasPilotoAno->addRow([$ano, $tempo_menor[0]->tempo, $tempo_piloto[0]->tempo, $tempo_maior[0]->tempo]);

                array_push($pilotos_ano, ["ano" => $ano, "menor" => $tempo_menor[0]->tempo, "tempo" => $tempo_piloto[0]->tempo, "maior" => $tempo_maior[0]->tempo]);

            }

            \Lava::ColumnChart('HorasPilotoAno', $horasPilotoAno, [
                'title' => 'Horas de Voo',
                'titleTextStyle' => [
                    'color'    => '#eb6b2c',
                    'fontSize' => 14
                ]
            ]);

            //--------------------------------------------------------

        }


        if ($request->filled('ano')) {
            $pilotos = DB::select('SELECT DISTINCT users.name FROM movimentos JOIN users ON movimentos.piloto_id = users.id WHERE YEAR(movimentos.data) = "'.$request->ano.'"');
        }

        if ($request->filled('piloto') && $request->filled('ano') && $request->filled('pilotoTotal')) {
            $piloto = $request->piloto;
            $pilotoTotal = $request->pilotoTotal;

            return view('movimentos.estatisticas', compact('years', 'pilotosTotal', 'ano', 'aeronaves_mes_ano', 'aeronaves_ano', 'pilotos', 'pilotos_mes_ano', 'piloto', 'pilotoTotal', 'pilotos_ano'));
        }

        if ($request->filled('piloto') && $request->filled('ano')) {
            $piloto = $request->piloto;

            return view('movimentos.estatisticas', compact('years', 'pilotosTotal', 'ano', 'aeronaves_mes_ano', 'aeronaves_ano', 'pilotos', 'pilotos_mes_ano', 'piloto'));
        }

        if ($request->filled('pilotoTotal') && $request->filled('ano')) {
            $piloto = $request->piloto;
            $pilotoTotal = $request->pilotoTotal;

            return view('movimentos.estatisticas', compact('years', 'pilotosTotal', 'ano', 'aeronaves_mes_ano', 'aeronaves_ano', 'pilotos', 'pilotos_ano', 'pilotoTotal'));
        }

        if ($request->filled('pilotoTotal')) {
            $pilotoTotal = $request->pilotoTotal;
            return view('movimentos.estatisticas', compact('years','pilotosTotal', 'aeronaves_ano', 'pilotoTotal', 'pilotos_ano'));
        }

        if ($request->filled('ano')) {
            return view('movimentos.estatisticas', compact('years','pilotosTotal', 'ano', 'aeronaves_mes_ano', 'aeronaves_ano', 'pilotos'));
        }

        return view('movimentos.estatisticas', compact('years','pilotosTotal', 'aeronaves_ano'));
    }
}
