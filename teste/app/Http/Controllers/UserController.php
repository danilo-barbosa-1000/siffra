<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
	private $users;

	public function __construct(User $users){
		$this->users=$users;
	}

    public function index(){
        return response()->json(['success'=>true,'data'=>$this->users->paginate(50)]);
    }

    public function login(){
        if(Auth::attempt(['email'=>request('email'),'password'=>request('password')])){ 
            $user=Auth::user();
            return response()->json(['success'=>true,'token'=>$user->createToken('Siffra')->accessToken]); 
        }else{ 
            return response()->json(['success'=>false,'error'=>'Usuário Inválido!'],401); 
        } 
    }

    public function logout(Request $request){ 
        $isUser=$request->user()->token()->revoke();
        if($isUser) return response()->json(['success'=>true]);
        else return response()->json(['success'=>false,'error'=>'Usuário Inválido!'],404);
    }

    public function show($id){
    	$user=$this->users->find($id);
    	if($user==null) return response()->json(['success'=>false,'error'=>"Usuário não encontrado!"],404);
    	return response()->json(['success'=>true,'data'=>$user]);
    }

    public function store(Request $resquest){
    	try{
            $validator = Validator::make($request->all(), [ 
                'name' => 'required', 
                'email' => 'required|email', 
                'password' => 'required', 
                'c_password' => 'required|same:password', 
            ]);
            if ($validator->fails()) return response()->json(['success'=>false,'error'=>$validator->errors()],401);
    		$this->users->create($resquest->all());
    		return response()->json(['success'=>true,'token'=>$user->createToken('Siffra')->accessToken,'msg'=>"Usuário Criado!"],201);
    	}catch(\Exception $e){
    		if(config('app.debug')) return response()->json(['success'=>false,'error'=>$e->getMessage()]);
    		return response()->json(['success'=>false,'error'=>"Falha ao Criar Usuário"]);
    	}
    }

    public function update(Request $resquest,$id){
    	try{
            $validator = Validator::make($request->all(), [ 
                'name' => 'required', 
                'email' => 'required|email', 
                'password' => 'required', 
                'c_password' => 'required|same:password', 
            ]);
            if ($validator->fails()) return response()->json(['success'=>false,'error'=>$validator->errors()],401);
            $user=$this->users->find($id);
            if($user==null) return response()->json(['success'=>false,'error'=>"Usuário não encontrado!"],404);
    		$user->update($resquest->all());
    		return response()->json(['success'=>true,'msg'=>"Usuário Atualizado!"],201);
    	}catch(\Exception $e){
    		if(config('app.debug')) return response()->json(['success'=>false,'error'=>$e->getMessage()]);
    		return response()->json(['success'=>false,'error'=>"Falha ao Atualizar Usuário"]);
    	}
    }

    public function delete($id){
    	try{
    		$user=$this->users->find($id);
    		if($user==null) return response()->json(['success'=>false,'error'=>"Usuário não encontrado!"],404);
    		$user->delete();
    		return response()->json(['success'=>true,'msg'=>"Usuário Removido!"],201);
    	}catch(\Exception $e){
    		if(config('app.debug')) return response()->json(['success'=>false,'error'=>$e->getMessage()]);
    		return response()->json(['success'=>false,'error'=>"Falha ao Remover Usuário!"]);
    	}
    }
}
