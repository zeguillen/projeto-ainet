<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;
use DB;

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
        $movimentos = new Movimento;
        return view('movimentos.add', compact('movimentos'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Movimento $movimento)
    {
        //
    }

    public function edit(Movimento $movimento)
    {
        //
    }

    public function update(Request $request, Movimento $movimento)
    {
        //
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
