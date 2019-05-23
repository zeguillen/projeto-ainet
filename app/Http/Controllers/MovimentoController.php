<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    public function index()
    {
        $movimentos = Movimento::with('user', 'aeronave')->Paginate(5);
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

    public function destroy(Movimento $movimento)
    {
        //
    }
}
