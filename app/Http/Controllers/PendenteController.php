<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendenteController extends Controller
{
    public function index()
    {
    	
    	$conflitos = DB::table('movimentos')->where('tipo_conflito', '!=', 'NULL');
    	$movimentos = DB::table('movimentos')->where('confirmado', '0')->union($conflitos)->paginate(3, ['*'], 't1');

    	$licencas = DB::table('users')->where('licenca_confirmada', '0');
    	$users = DB::table('users')->where('certificado_confirmado', '0')->union($licencas)->paginate(3, ['*'], 't2');	

        return view('pendentes.list', compact('movimentos', 'users'));
    }
}
