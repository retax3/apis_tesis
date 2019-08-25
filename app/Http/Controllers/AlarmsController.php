<?php

namespace App\Http\Controllers;
use App\Alarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AlarmsController extends Controller
{
    //Obtener todos los usuarios
    public function index(Request $request){

        if ($request->isJson()){
            $alarms= DB::select("Select *
                                 From Alarms a
                                 where a.id_user=$request->id_user");

            return response()->json($alarms,200);
        }

        return response()->json(['error'=>'No Autorizado','hola'=>'hola mundo :V'],401,[]); 
      
    }

    //Crear alarma
    public function createAlarm(Request $request){
        if ($request->isJson()){
            $data = $request->json()->all();
            $alarm = Alarm::create([
                'id_alarm'=>$data['id_alarm'],
                'name'=>$data['name'],
                'state'=>$data['state'],
                'latitude'=>$data['latitude'],
                'longitude'=>$data['longitude'],
                'id_user'=>$data['id_user']
            ]);


            return response()->json([$alarm],201);
        }
        return response()->json(['error'=>'No Autorizado','hola'=>'hola mundo :V'],401,[]); 
    }

   
    public function destroy(Request $request){
        if ($request->isJson()){
            $alarm= Alarm::where('id',$request->id)->first();
            if ($alarm==null){
                return response()->json(['Estado'=>'Alarma no encontrada']);
            }
            $alarm->delete();
            
        return response()->json(['Estado'=>'Alarma Eliminada'],200);
    }
        return response()->json(['error'=>'no autorizado'],401,[]);
        
    }

    public function update(Request $request){
        if ($request->isJson()){
            $alarm=Alarm::findOrFail($request->id);
            $alarm->name=$request->name;
            $alarm->state=$request->state;
            $alarm->latitude=$request->latitude;
            $alarm->longitude=$request->longitude;
            $alarm->save();
            return response()->json(['Estado'=>'Alarma Modificada'],200);
        }return response()->json(['Estado'=>'Alarma no pudo modificarse']);
    }
}
    