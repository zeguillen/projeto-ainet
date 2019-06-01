<?php

namespace App\Http\Controllers;

use App\Aeronave;
use App\AeronavePiloto;
use Illuminate\Http\Request;
use App\Http\Requests\AeronaveUpdateRequest;
use App\Http\Requests\AeronaveStorageRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class AeronaveController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aeronaves = Aeronave::paginate(10);
        return view('aeronaves.list', compact('aeronaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aeronave = new Aeronave;
        return view('aeronaves.add', compact('aeronave'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AeronaveStorageRequest $request)
    {
        $aeronave = new Aeronave;

        $validated = $request->validated();
        
        $aeronave->fill($request->all());
        $aeronave->save();

        return redirect()->route('aeronaves.index')->with('success', 'Aeronave adicionada com sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aeronave  $aeronave
     * @return \Illuminate\Http\Response
     */
    public function edit(Aeronave $aeronave)
    {
        // authorize
        return view('aeronaves.edit', compact('aeronave'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aeronave  $aeronave
     * @return \Illuminate\Http\Response
     */
    public function update(AeronaveUpdateRequest $request, Aeronave $aeronave)
    {
        $validated = $request->validated();
 
        $aeronave->fill($request->all());
        $aeronave->save();

        return redirect()->route('aeronaves.index')->with('success', 'Aeronave atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aeronave  $aeronave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aeronave $aeronave)
    {
        // PERGUNTAR
        $movimentos = Aeronave::findOrFail($aeronave->matricula)->movimentos;

        if($movimentos > 0){
            $aeronave->delete(); //soft delete
        }else{
            $aeronave->forceDelete(); // permanent delete
        }

        return redirect()->route('aeronaves.index')->with('success', 'Aeronave apagada com sucesso');
    }

    public function pilotosAutorizados(Request $request) 
    {   
        $matricula = request()->route('aeronave');

        $autorizados = DB::table('aeronaves_pilotos')->select('piloto_id')->where('matricula', $matricula);
        $type = "P";
        $pilotos= DB::table('users')->where('tipo_socio', $type)->whereIn('id', $autorizados)->paginate(10);

        $aut = 1;
        
        if($request->filled('autorizado')) {
            if($request->autorizado == "false") {
                $autorizados = DB::table('aeronaves_pilotos')->select('piloto_id')->where('matricula', $matricula);
                $type = "P";
                $pilotos= DB::table('users')->where('tipo_socio', $type)->whereNotIn('id', $autorizados)->paginate(10);

                $aut = 0;
            }
        }

        return view('aeronaves.pilotosAutorizados', compact('pilotos', 'matricula', 'aut'));
    }
}
