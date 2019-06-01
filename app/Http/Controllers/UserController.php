<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\User;
use App\AeronavePiloto;
use App\Mail\UserActivation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserStorageRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserController extends Controller
{
    use SoftDeletes;

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

        $socio = new User;
        $foto = $request->file_foto;

        return var_dump($request->file_foto);
        if(is_null($foto) != true && $foto->isValid()){
            $path = Storage::putFileAs('public/fotos', $foto, $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension());
            $socio->foto_url = $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension();
        }

        $socio->fill($request->except('foto_url', 'password'));
        $socio->password = Hash::make($socio->password);

        if($request->filled('conf_licenca')) {
            if($request->conf_licenca == "true") {
                $socio->licenca_confirmada = 1;
            }
        }

        if($request->filled('conf_certificado')) {
            if($request->conf_certificado == "true") {
                $socio->certificado_confirmado = 1;
            }
        }

        $socio->save();

        // Enviar email para activação
        $socio->sendEmailVerificationNotification();

        return redirect()->route('users.index')->with('success', "Sócio criado com sucesso");
    }

    public function edit(User $socio)
    {
        $this->authorize('view', $socio);
        $user = $socio;

        $tipos_licencas = DB::table('tipos_licencas')->select('code', 'nome')->get();
        $classes_certificados = DB::table('classes_certificados')->select('code', 'nome')->get();

        return view('users.edit', compact('user', 'tipos_licencas', 'classes_certificados'));
    }

    public function update(UserUpdateRequest $request, User $socio)
    {
        $this->authorize('update', $socio, User::class);

        // Admin pode alterar tudo
        if(Auth::user()->direcao){
            $validated = $request->validated();

            $foto = $request->file_foto;

            if(is_null($foto) != true && $foto->isValid()){
                if (!is_null($socio->foto_url) && $request->hasFile('file_url')) {
                    Storage::disk('public')->delete('fotos/'.$socio->foto_url);
                }
                $path = Storage::putFileAs('public/fotos', $foto, $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension());
                $socio->foto_url = $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension();
            }

            $socio->fill($request->except('foto_url'));
            $socio->save();

        }

        // User qualquer
        if (Auth::user()->can('update', $socio, User::class)){
            $validated = $request->validated();

            $foto = $request->file_foto;

            if(is_null($foto) != true && $foto->isValid()){
                if (!is_null($socio->foto_url) && $request->hasFile('file_url')) {
                    Storage::disk('public')->delete('fotos/'.$socio->foto_url);
                }
                $path = Storage::putFileAs('public/fotos', $foto, $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension());
                $socio->foto_url = $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension();
            }

            $socio->fill($request->only('nome_informal', 'name', 'email', 'file_foto', 'data_nascimento', 'nif', 'telefone', 'endereco'));

            $socio->save();

        }

        // Um piloto
        if(Auth::user()->can('updatePiloto', $socio, User::class)){
            $validated = $request->validated();

            $foto = $request->file_foto;
            $certificado = $request->file_certificado;
            $licenca = $request->file_licenca;

            // Foto
            if(is_null($foto) != true && $foto->isValid()){
                if (!is_null($socio->foto_url) && $request->hasFile('file_url')) {
                    Storage::disk('public')->delete('fotos/'.$socio->foto_url);
                }
                $path = Storage::putFileAs('public/fotos', $foto, $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension());
                $socio->foto_url = $socio->id . '_' . 'profile_photo' . '.' . $foto->getClientOriginalExtension();
            }

            // Certificado
            if(is_null($certificado) != true && $certificado->isValid()){
                if (file_exists(storage_path('app/docs_piloto/certificado_'. $socio->id .'.pdf')) && $request->hasFile('file_url')) {
                    Storage::disk('local')->delete('docs_piloto', $certificado, 'certificado_'. $socio->id . '.' . $certificado->getClientOriginalExtension());
                }
                $path = Storage::putFileAs('docs_piloto', $certificado, 'certificado_'. $socio->id . '.' .  $certificado->getClientOriginalExtension());
            }

            // Licença
            if(is_null($licenca) != true && $licenca->isValid()){
                if (file_exists(storage_path('app/docs_piloto/licenca_'. $socio->id .'.pdf')) && $request->hasFile('file_url')) {
                    Storage::disk('local')->delete('docs_piloto', $licenca, 'licenca_'. $socio->id . '.' . $licenca->getClientOriginalExtension());
                }
                $path = Storage::putFileAs('docs_piloto', $licenca, 'licenca_'. $socio->id . '.' .  $licenca->getClientOriginalExtension());
            }

            // Validar Instrutor Aluno
            if(($request->instrutor == 1) && ($request->tipo_licenca === "ALUNO-PPL(A)" || $request->tipo_licenca === "ALUNO-PU")){
                return redirect()->back()->withErrors(['O sócio não pode ser instrutor e aluno']);
            }

            $socio->fill($request->only('nome_informal', 'name', 'email', 'file_foto', 'data_nascimento', 'nif', 'telefone', 'endereco', 'num_licenca', 'tipo_licenca', 'instrutor', 'file_licenca', 'num_certificado', 'classe_certficiado', 'validade_certificado', 'file_certificado'));

            $socio->nome_informal = $request->nome_informal;
            $socio->name = $request->name;
            $socio->email = $request->email;
            $socio->data_nascimento = $request->data_nascimento;
            $socio->nif = $request->nif;
            $socio->telefone = $request->telefone;
            $socio->endereco = $request->endereco;
            $socio->num_licenca = $request->num_licenca;
            $socio->tipo_licenca = $request->tipo_licenca;
            $socio->instrutor = $request->instrutor;
            $socio->num_certificado = $request->num_certificado;
            $socio->classe_certificado = $request->classe_certificado;
            $socio->validade_certificado = $request->validade_certificado;

            if($request->filled('num_licenca') || $request->filled('tipo_licenca') || $request->filled('instrutor')){
                $socio->licenca_confirmada = 0;
            }

            if($request->filled('num_certficado') || $request->filled('classe_certificado') || $request->filled('validade_certificado')){
                $socio->certificado_confirmado = 0;
            }


            //confirmar licenca e certificado manualmente: DIRECAO
            if($request->filled('conf_licenca')) {
                if($request->conf_licenca == "true") {
                    $socio->licenca_confirmada = 1;
                }
            }

            if($request->filled('conf_certificado')) {
                if($request->conf_certificado == "true") {
                    $socio->certificado_confirmado = 1;
                }
            }

            $socio->save();
        }


        return redirect()->route('users.index')->with('success',"Sócio atualizado com sucesso");

    }

    public function destroy(User $socio)
    {
        $this->authorize('delete', User::class);

        $socio->delete();

        return redirect()->route('users.index')->with('success',"Sócio eliminado com sucesso");
    }

    public function changePassword()
    {
        return view('users.changePassword');
    }

    public function savePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);

        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            return redirect()->back()->withErrors(['Password incorrecta']);
        }

        if ($request->password == $request->old_password ) {
            return redirect()->back()->withErrors(['Não pode reutilizar passwords']);
        }

        Auth::user()->password = Hash::make($request->password);
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

    public function certificadoPiloto(Request $request, $piloto){
        return response()->file(storage_path('app/docs_piloto/certificado_'. $piloto .'.pdf'));
    }

    public function licencaPiloto(Request $request, $piloto){
        return response()->file(storage_path('app/docs_piloto/licenca_'. $piloto .'.pdf'));
    }

    public function assuntosPendentes() {
        $this->authorize('acessoPendentes', User::class);

        $conflitos = DB::table('movimentos')->where('tipo_conflito', '!=', 'NULL');
        $movimentos = DB::table('movimentos')->where('confirmado', '0')->union($conflitos)->paginate(3, ['*'], 't1');

        $licencas = DB::table('users')->where('licenca_confirmada', '0');
        $users = DB::table('users')->where('certificado_confirmado', '0')->union($licencas)->paginate(3, ['*'], 't2');


        return view('users.pendentes', compact('movimentos', 'users'));
    }

    public function reenviarEmailAtivacao(User $socio) {
        $this->authorize('updateAll', User::class);

        if($socio->ativo) {
            return redirect()->route('users.index')->with('errors',"O Sócio já se encontra ativo");
        }

        $socio->sendEmailVerificationNotification();
        return redirect()->route('users.index')->with('success',"Email de ativação enviado");
    }

    public function naoAutorizarPiloto(Request $request)
    {
        $this->authorize('updateAll', User::class);

        $matricula = request()->route('aeronave');
        $piloto = request()->route('piloto');

        AeronavePiloto::where('matricula', $matricula)->where('piloto_id', $piloto)->delete();

        return redirect()->route('aeronaves.pilotos', compact('matricula'))->with('success',"Piloto eliminado");
    }

    public function autorizarPiloto(Request $request)
    {
        $this->authorize('updateAll', User::class);

        $matricula = request()->route('aeronave');
        $piloto = request()->route('piloto');

        $aeronavePiloto = new AeronavePiloto;

        $aeronavePiloto->timestamps = false;
        $aeronavePiloto->matricula = $matricula;
        $aeronavePiloto->piloto_id = $piloto;

        $aeronavePiloto->save();

        return redirect()->route('aeronaves.pilotos', compact('matricula'))->with('success',"Piloto adicionado");
    }

}
