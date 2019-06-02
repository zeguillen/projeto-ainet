<?php

namespace App\Http\Controllers;

use App\User;
use App\Aeronave;
use App\AeronavePiloto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AeronaveUpdateRequest;
use App\Http\Requests\AeronaveStorageRequest;
use Illuminate\Database\Eloquent\SoftDeletes;


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
        $this->authorize('view', Aeronave::class);
        $aeronave = new Aeronave;
        $aeronaves_valores = DB::table('aeronaves_valores')->select('matricula', 'unidade_conta_horas', 'minutos', 'preco')->get();
        return view('aeronaves.add', compact('aeronave', 'aeronaves_valores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AeronaveStorageRequest $request)
    {
        $this->authorize('create', User::class);

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
        $this->authorize('view', $aeronave);

        $aeronaves_valores = DB::table('aeronaves_valores')->select('matricula', 'unidade_conta_horas', 'minutos', 'preco')->paginate(10);

        return view('aeronaves.edit', compact('aeronave', 'aeronaves_valores'));
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
        $this->authorize('update', $aeronave);

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
        $this->authorize('delete', $aeronave);

        $movimentos = Aeronave::findOrFail($aeronave->matricula)->movimentosAeronave;

        if(count($movimentos) > 0){
            $aeronave->delete(); //soft delete
        }else{
            $aeronave->forceDelete(); // permanent delete
        }

        return redirect()->route('aeronaves.index')->with('success', 'Aeronave apagada com sucesso');
    }

    public function pilotosAutorizados(Request $request, User $socio)
    {
        $this->authorize('view', $socio);

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
