<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    //Obtener todos los usuarios
    public function index(Request $request){

        if ($request->isJson()){
            $users = User::all();
            return response()->json($users,200);
        }

        return response()->json(['error'=>'No Autorizado','hola'=>'hola mundo :V'],401,[]);

    }

    //Crear usuario
    public function createUser(Request $request){
        if ($request->isJson()){
            $data = $request->json()->all();
            $userAux= User::where('email',$data['email'])->first();

            if ($userAux==null){
            $user = User::create([
                'email'=>$data['email'],
                'name'=>$data['name'],
                'second_name'=>$data['second_name'],
                'phone'=>$data['phone'],
                'password'=>Hash::make($data['password']),
                'api_token'=>str_random(60)
            ]);
            return response()->json([$user],201);
            }
            else {
                return response()->json(['error'=>'Usuario ya se encuentra registrado'],401,[]);
            }
        }
        return response()->json(['error'=>'No Autorizado','hola'=>'hola mundo :V'],401,[]);
    }

    public function getToken(Request $request){
        if($request->isJson()){
            try {
                $data = $request->json()->all();

                $user = User::where('email',$data['email'])->first();

                if($user && Hash::check($data['password'],$user->password)){
                    return response()->json($user,200);
                } else {
                    response()->json(['error'=>'bad'],406);
                }
            }   catch (ModelNotFoundException $e){
                    return response()->json(['error'=>'No content'],406);
            }
        }

        return response()->json(['error'=>'No autorizado'],201);

    }

    public function destroy(Request $request){
        $user = User::findOrFail($request->id);
        $user->delete();
        return response()->json(['Estado'=>'Usuario Eliminado'],200);
    }

    public function update(Request $request){
        if ($request->isJson()){
        $user = User::findOrFail($request->id);
        $user->email=$request->email;
        $user->name=$request->name;
        $user->second_name=$request->second_name;
        $user->phone=$request->phone;
        $user->password=Hash::make($request->password);


        $user->save();
        return response()->json(['Estado'=>'Usuario Modificado'],200);
        }
        if (!User::findOrFail($request->id)){
            return response()->json(['error'=>'usuario no encontrado'],406);
        }
    }

}
