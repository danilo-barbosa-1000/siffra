<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public function login(Request $request){
    	$credencials=request(['email','password']);
    	if(!Auth::attempt($credencials)) return response()->json(['success'=>false,'error'=>'Usuário Inválido!'],401); 
    	$usuario=$request->user();
    	$resposta['success']=true;
    	$resposta['name']=$usuario->name;
    	$resposta['email']=$usuario->email;
    	$resposta['token']=$usuario->createToken('token')->accessToken;
    	return response()->json($resposta);
    }

    public function logout(Request $request){
    	$isUser=$request->user()->token()->revoke();
    	if($isUser) return response()->json(['success'=>true]);
    	else return response()->json(['success'=>false,'error'=>'Usuário Inválido!'],404);
    }
}
