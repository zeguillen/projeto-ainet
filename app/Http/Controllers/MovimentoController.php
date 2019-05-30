<?php

namespace App\Http\Controllers;

use DB;
use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $aeronaves_pilotos = DB::table('aeronaves_pilotos')->select('matricula', 'piloto')->get();
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
        $movimento = Movimento::findOrFail($movimento->id);
        $aeronaves = DB::table('aeronaves')->select('matricula', 'marca', 'modelo')->get();
        $aerodromos = DB::table('aerodromos')->select('code', 'nome')->get();
        $pilotos = DB::table('aeronaves_pilotos');
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
            return redirect()->route('movimentos.index')->with('errors',"Movimento já confirmado! Não é possivel eliminar");
        }
        
        $movimento->delete();
        return redirect()->route('movimentos.index')->with('success',"Movimento eliminado com sucesso");
    }
}
