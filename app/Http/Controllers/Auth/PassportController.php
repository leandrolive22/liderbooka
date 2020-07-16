<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credenciais = [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1
        ];

        if(!Auth::attempt($credenciais))
            return response()->json([
                'res' => 'Acesso negado'
            ], 401);

        $user = $request->user();
        $token = $user->createToken('Token de acesso')->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'res' => 'Deslogado com sucesso'
        ]);
    }

    public function appToken($id,$name,$action = 'encrypt',$string)
    {
        if($action == 'encrypt') {
            $hash = base64_encode($id. ';' . $name . ';' . date('YmdHi'));
            $n = strlen($hash);

            for($i = 0; $i < $n; $i++) {
               $asc += $this->strAsciiConvert($hash,$i);
            }

            $value1 = substr($asc,0,1);
            $value2 = substr($asc,-1,1);
            $value3 = substr($asc,2,1);

            return base64_encode($hash.'$'.$value1.$value2.$value3);

        } else if($action == 'decrypt') {
            $n = strlen($string);

            for($i = 0; $i < $n; $i++) {
               $asc += $this->strAsciiConvert($string,$i);
            }

            $value1 = substr($asc,-3,1);
            $value2 = substr($asc,-2,1);
            $value3 = substr($asc,-1,1);

        }

        return FALSE;
    }

    public function strAsciiConvert($string,$start,$action = 'encrypt',$length = 1)
    {
        if($action == 'encrypt') {
            return ord(substr($string,$start,$length));
        } else if($action == 'decrypt') {
            return chr(substr($string,$start,$length));
        }

    }

    //Criptografia criada por Alexandre - Token
    function criptografia($action, $string,$n)
    {
        $tituloSite = ['LiderBook','sms'];

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = $tituloSite[$n].'_key';
        $secret_iv = $tituloSite[$n].'_iv';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if($action == 'encrypt' )
        {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        }
        else if($action == 'decrypt' )
        {$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);}
        return $output;
    }
}
