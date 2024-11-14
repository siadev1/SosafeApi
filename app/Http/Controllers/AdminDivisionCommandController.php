<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\soSafeCorpsBiodata;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminDivisionCommandController extends Controller
{
    public function getSoSafeCorpsBiodata(){
        $area = JWTAuth::user()->Area;
        $SoSafeCorpsBiodata = soSafeCorpsBiodata::where('division_command_id',$area)->with('divisionArea')->get();
        return response()->json(['data'=>$SoSafeCorpsBiodata,'area'=>$area], 200);
    }

    public function storeSoSafeCorpsBiodata(Request $request){
        $validate = $request->all();

        $rules = [
            'image'=>['required'],
            'title' =>['string','required'],
            'description' =>['string','required'],
            'badge' =>['string','required'],
            'date' =>['string','required'],
            'content' =>['string','required'],
            'author' =>['string','required']

        ];

        $validator=Validator::make($validate,$rules);

        if($validator->fails()){
            $errors = $validator->messages()->all();
            return response()->json(['errors' => $errors]);
        }
        $SoSafeCorpsBiodata = SoSafeCorpsBiodata::create($validate);
        return response()->json(['message'=> 'success']);
    }

    public function editSoSafeCorpsBiodata(Request $request,$id){
        $validate = $request->all();

        $rules = [
            'image'=>['required'],
            'title' =>['string','required'],
            'description' =>['string','required'],
            'badge' =>['string','required'],
            'date' =>['string','required'],
            'content' =>['string','required'],
            'author' =>['string','required']

        ];

        $validator=Validator::make($validate,$rules);

        if($validator->fails()){
            $errors = $validator->messages()->all();
            return response()->json(['errors' => $errors]);
        }
        try {
            $SoSafeCorpsBiodata = SoSafeCorpsBiodata::findOrFail($id);
            $SoSafeCorpsBiodata->update($request->all());
        } catch (ModelNotFoundException $exception) {
            return response(["Status"=>"Error",
            "Message"=>"SoSafeCorpsBiodata with id {$id} not found"]);
        } 

    }
    public function deleteSoSafeCorpsBiodata($id){
        try {
        $SoSafeCorpsBiodata = SoSafeCorpsBiodata::findOrFail($id);
        $SoSafeCorpsBiodata->status = 0;
        $SoSafeCorpsBiodata->update();
    } catch (ModelNotFoundException $exception) {
        return response(["Status"=>"Error",
        "Message"=>"SoSafeCorpsBiodata with id {$id} not found"]);
    }
}
}
