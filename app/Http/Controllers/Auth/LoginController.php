<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Permissions\UserPermission;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Hash;
use App\Users\Cargo;
use Cache;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    protected $username = 'username';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'home/page';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        $now = date('Y-m-d');
        if(Cache::has('day')) {
            if($now > Cache::get('day')) {
                Cache::flush();
            }
        } else {
            Cache::add('day',$now,(60*24));
        }
        // Dados de usuário
        $ilha = $user->ilha_id;
        $lgpd = $user->accept_lgpd;
        $cargo = $user->cargo_id;

        //Registra Log
        $log = new Logs();

        //Verifica se o usuário já fez login anteriormente
        $firstLogin = $log->firstLogin($user->id);
        $log->login($user->id, $ilha, $request->ip());

        // Pega permissões e grava em sessão
        $up = new UserPermission($user);
        $permissions = $up->getPermissionsIds();
        Session::put('permissionsIds',$permissions);

        // retorna view de registro aceite de LGPD
        if(is_null($lgpd)) {
            $title = 'Termo de aceitação de Politica de Privacidade - LiderBook';
            $lgpd = TRUE;
            return view('lgpd',compact('title','lgpd'));
        }

        if(in_array($cargo,[5,4,3])) {
            //materiais não lidos
            $countMat = $log->countNotRead($user,$ilha);
            if($countMat !== 0) {
                Session::put('countMaterials',$countMat[0]);
                Session::put('countVideo',$countMat[1][2]);
            }
        }

        $searchCargo = @Cargo::find($cargo);
        @Session::put('cargoUser',@$searchCargo->description);

        if($firstLogin === 0 || Hash::check(env("DEFAULT_PASSWORD"),$user->password)) {
            Session::put('pwIsDf',1);
            return redirect('profile/'.base64_encode($user))->with('errorAlert','Altere sua senha');
        }
    }
}
?>