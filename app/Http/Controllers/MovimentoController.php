<?php

namespace App\Http\Controllers;

use DB;
use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Khill\Lavacharts\Lavacharts;

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
        return view('movimentos.add', compact('movimento', 'aeronaves', 'aerodromos', 'aeronaves_pilotos'));
    }

    public function store(MovimentoStorageRequest $request)
    {
        $validated = $request->validated();

        $movimento = new Movimento;
        $movimento->fill($request->all());
        $movimento->save();

        return redirect()->route('movimentos.index')->with('success', "Movimento criado com sucesso");
    }

    public function edit(Movimento $movimento)
    {
        $this->authorize('view', $movimento);
        // $movimento = Movimento::findOrFail($movimento->id);

        $aeronaves = DB::table('aeronaves')->select('matricula', 'marca', 'modelo')->get();
        $aerodromos = DB::table('aerodromos')->select('code', 'nome')->get();

        return view('movimentos.edit', compact('movimento', 'aeronaves', 'aerodromos'));
    }

    public function update(Request $request, Movimento $movimento)
    {
        return redirect()->route('movimentos.index')->with('success', "Movimento successfully updated!");
    }

    public function destroy(Request $movimento)
    {
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

        if ($request->filled('ano')) {
            $aeronaves_mes_ano = DB::select('SELECT SUM(tempo_voo) AS "tempo", MONTH(data) AS "mes", aeronave FROM movimentos WHERE YEAR(data) = "'.$request->ano.'" GROUP BY aeronave, MONTH(data)');

            $ano = $request->ano;

            //chart ------------------------------------------------------------

            $lava = new Lavacharts; // See note below for Laravel

            $horasDeVoo = $lava->DataTable();

            $horasDeVoo->addStringColumn('Mês');

            $aeronaves = DB::select('SELECT DISTINCT aeronave FROM movimentos WHERE YEAR(data) = "'.$request->ano.'"');
            foreach ($aeronaves as $aeronave) {
                $horasDeVoo->addNumberColumn($aeronave->aeronave);
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
                array_push($data, $i);
                foreach ($aeronaves_mes_ano as $aeronave_mes_ano) {
                    if($aeronave_mes_ano->mes == $i) {
                        array_push($data, $aeronave_mes_ano->tempo);
                    }
                }
                $horasDeVoo->addRow($data);
                $data = [];
            }

            $lava->ColumnChart('HorasDeVoo', $horasDeVoo, [
                'title' => 'Horas de Voo',
                'titleTextStyle' => [
                    'color'    => '#eb6b2c',
                    'fontSize' => 14
                ]
            ]);

            //--------------------------------------------------------

            return view('movimentos.estatisticas', compact('years', 'aeronaves_mes_ano', 'ano'), ["lava"=>$lava]);
        }

        return view('movimentos.estatisticas', compact('years'));
    }
}
