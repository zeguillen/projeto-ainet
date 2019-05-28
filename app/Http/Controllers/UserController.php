<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(){
        // $this->middleware('auth')->except('changeAtivo'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if (auth()->user()->can('updateAll',User::class))
        $query = User::query();
        if($request->filled('num_socio')) {
            $query->where('num_socio', $request->num_socio);
        }
        if($request->filled('nome_informal')) {
            $query->where('nome_informal', 'LIKE', $request->nome_informal . '%');
        }
        if(($request->tipo_socio != "none") && ($request->filled('tipo_socio'))) {
            switch ($request->tipo_socio) {
                case 'piloto':
                    $type = "P";
                    break;
                case 'nao_piloto':
                    $type = "NP";
                    break;
                case 'aeromodelista':
                    $type = "A";
                    break;
            }
            $query->where('tipo_socio', $type);
        }
        if($request->filled('direcao')) {
            if($request->direcao == "true") {
                $query->where('direcao', 1);
            } else {
                $query->where('direcao', 0);
            }      
        }

        $users = $query->orderBy('id', 'asc')->paginate(5);
        return view('users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $user = new User;
        return view('users.add', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStorageRequest $request)
    {
        $this->authorize('create', User::class);
        $validated = $request->validated();

        $user = new User;
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();

        // Enviar email para activação
        Mail::to($request->user())->send(new UserActivation($num_socio));

        return redirect()->route('users.index')->with('success', "User successfully created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $socio)
    {
        $this->authorize('view', $socio);
        $user = $socio;
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $socio)
    {
        $this->authorize('update', $socio);
        $user = $socio;
        $user->fill($request->except('password'));
        $user->save();
         if($request->has("email")) {
            
        }
        return redirect()->route('users.index')->with('success',"User successfully updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $socio)
    {
        $socio->delete();
        return redirect()->route('users.index')->with('success',"User successfully deleted");
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        return view('users.changePassword', compact('user'));
    }

    public function savePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'password_old' => 'required|min:8',
            'password_confirmation' => 'required|min:8'
        ]);

        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            return response()->json(['errors' => ['Old password missmatch']], 400);
        }

        if ($request->password == $request->old_password ) {
            return response()->json(['errors' => ['You can not use the same password']], 400);
        }

        if ($request->password != $request->password_confirmation) {
            return response()->json(['errors' => ['Confirmation password missmatch']], 400);
        }

        Auth::user()->password = Hash::make($request->password);;
        Auth::user()->save(); 

        return redirect()->route('home')->with('success',"Password updated");
    }


    public function changeQuota(Request $user)
    {
        $user = User::findOrFail($user->id);

        switch($user->quota_paga) {
            case 1:
                $user->quota_paga = 0;
                break;
            case 0:
                $user->quota_paga = 1;
        }

        $user->save();
        
        return redirect()->route('users.index')->with('success',"Quota atualizada");
    }

    public function resetQuotas() {
        DB::table('users')->update(['quota_paga' => 0]);

        return redirect()->route('users.index')->with('success',"As quotas dos sócios encontram-se todas por pagar");
    }

    public function changeAtivo(Request $user)
    {
        $user = User::findOrFail($user->id);

        switch($user->ativo) {
            case 1:
                $user->ativo = 0;
                break;
            case 0:
                $user->ativo = 1;
        }

        $user->save();
        
        return redirect()->route('users.index')->with('success',"Estado atualizado");
    }

    public function desativarUsersSemQuotas() {
        DB::table('users')->where('quota_paga', '0')->update(['ativo' => 0]);

        return redirect()->route('users.index')->with('success',"Os sócios que tinham as quotas por pagar encontram-se agora desativos");
    }

    public function certificadoPiloto(Request $socio){
        $user = Auth::user();

        return view('ver.certificado', compact('user'));
    }
}