<?php

namespace App\Http\Controllers;
use App\Movement;
use App\Alarm;
use Illuminate\Http\Request;



class MovementsController extends Controller
{
    //Obtener todos los usuarios
    public function index(Request $request){

        if ($request->isJson()){
            $movements = Movement::all();
            return response()->json($movements,200);
        }

        return response()->json(['error'=>'No Autorizado','hola'=>'hola mundo :V'],401,[]); 
      
    }

    //Crear Movementa
    public function createMovement(Request $request){
        $alarm=Alarm::where('id_alarm','=',$request->id_alarm)->first();
    
        
        if ($alarm==null){
            return response()->json(['error'=>'Alarma no encontrada'],404,[]);
        }
        else if ($request->isJson()){
            $data = $request->json()->all();
            $Movement = Movement::create([
                'id_alarm'=>$data['id_alarm'],
                'latitude'=>$data['latitude'],
                'longitude'=>$data['longitude']
            ]);
            return response()->json([$Movement],201);
        }return response()->json(['error'=>'No Autorizado','hola'=>'hola mundo :V'],401,[]); 
        
    }


   
    public function destroy(Request $request){
        $Movement = Movement::findOrFail($request->id_Movement);
        $Movement->delete();
        return response()->json(['Estado'=>'Movemento Eliminado'],200);
    }

    public function modificar(Request $request){
        $Movement = Movement::findOrFail($request->id_Movement);
        $Movement->save();
        return response()->json(['Estado'=>'Movemento Modificado'],200);
    }
}
    