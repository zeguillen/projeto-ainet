<?php

namespace App\Http\Controllers;

use App\Aeronave;
use App\AeronavePiloto;
use Illuminate\Http\Request;


class AeronaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aeronaves = Aeronave::paginate(5);
        return view('aeronaves.list', compact('aeronaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aeronaves = new Aeronave;
        return view('aeronaves.add', compact('aeronaves'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aeronave  $aeronave
     * @return \Illuminate\Http\Response
     */
    public function show(Aeronave $aeronave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aeronave  $aeronave
     * @return \Illuminate\Http\Response
     */
    public function edit(Aeronave $aeronave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aeronave  $aeronave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aeronave $aeronave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aeronave  $aeronave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aeronave $aeronave)
    {
        //
    }

    public function pilotosAutorizados(Request $request) 
    {   
        $matricula = request()->route('matricula');

        $pilotos = AeronavePiloto::where('matricula', $matricula)->paginate(10);

        return view('aeronaves.pilotosAutorizados', compact('pilotos'));
    }

    public function naoAutorizarPiloto(Request $request){
        $matricula = request()->route('matricula');
        $piloto = request()->route('piloto');

        AeronavePiloto::where('matricula', $matricula)->where('piloto_id', $piloto)->delete();

        return redirect()->route('aeronaves.pilotos', compact('matricula'))->with('success',"Piloto eliminado");
    }
}
