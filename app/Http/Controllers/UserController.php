<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\UserActivation;
use Mail;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStorageRequest;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
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

    public function create()
    {
        $this->authorize('create', User::class);
        $user = new User;
        $tipos_licencas = DB::table('tipos_licencas')->select('code', 'nome')->get();
        $classes_certificados = DB::table('classes_certificados')->select('code', 'nome')->get();
        return view('users.add', compact('user', 'tipos_licencas', 'classes_certificados'));
    }

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

    public function edit(User $socio)
    {
        $this->authorize('view', $socio);
        $user = $socio;
        $tipos_licencas = DB::table('tipos_licencas')->select('code', 'nome')->get();
        $classes_certificados = DB::table('classes_certificados')->select('code', 'nome')->get();
        return view('users.edit', compact('user', 'tipos_licencas', 'classes_certificados'));
    }

    public function update(Request $request, User $socio)
    {
        
        if(Auth::user()->direcao) {
            //posso alterar todos os campos
            return 1;
            return redirect()->route('users.index')->with('success',"User successfully updated");
        }
        if($this->authorize('update', $socio)) {
            $socio->nome_informal = $request->nome_informal;
            $socio->name = $request->name;
            $oldEmail = $socio->email;
            $socio->email = $request->email;
            //foto
            $socio->data_nascimento = $request->data_nascimento;
            $socio->nif = $request->nif;
            $socio->telefone = $request->telefone;
            $socio->endereco = $request->endereco;
            $socio->save();
            if($oldEmail != $socio->email) {
                //todo 
                Mail::to($request->user())->send(new UserActivation($socio->id));
            }
            return redirect()->route('users.index')->with('success',"User successfully updated");
        }
        if($this->authorize('update', $socio)) {
            return 3;
            return redirect()->route('users.index')->with('success',"User successfully updated");
        }

        return 0;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $socio)
    {
        $this->authorize('delete', User::class);
        $socio->delete();
        return redirect()->route('users.index')->with('success',"User successfully deleted");
    }

    public function changePassword()
    {
        return view('users.changePassword');
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


    public function changeQuota(User $socio)
    {
        $this->authorize('updateAll', User::class);
        $user = User::findOrFail($socio->id);

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
        $this->authorize('updateAll', User::class);
        DB::table('users')->update(['quota_paga' => 0]);

        return redirect()->route('users.index')->with('success',"As quotas dos sócios encontram-se todas por pagar");
    }

    public function changeAtivo(User $socio)
    {
        $this->authorize('updateAll', User::class);
        $user = User::findOrFail($socio->id);

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
        $this->authorize('updateAll', User::class);
        DB::table('users')->where('quota_paga', '0')->update(['ativo' => 0]);

        return redirect()->route('users.index')->with('success',"Os sócios que tinham as quotas por pagar encontram-se agora desativos");
    }

    public function verCertificadoPiloto($piloto){
        return response()->file(storage_path('app/docs_piloto/certificado_'. $piloto .'.pdf'));
    }

    public function verLicencaPiloto($piloto){
        return response()->file(storage_path('app/docs_piloto/licenca_'. $piloto .'.pdf'));
    }
}