<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisCuci_model;
use Validator;
use Auth;


class JenisCuciController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->hak_akses=="admin"){
        $validator=Validator::make($req->all(),
            [
                'nama_jenis'=>'required',
                'harga_per_kilo'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $simpan=JenisCuci_model::create([
                'nama_jenis'=>$req->nama_jenis,
                'harga_per_kilo'=>$req->harga_per_kilo
                
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan admin']);
        }
    }

    public function update($id,Request $req)
    {
        if(Auth::user()->hak_akses=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga_per_kilo'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=JenisCuci_model::where('id',$id)->update ([
                'nama_jenis'=>$req->nama_jenis,
                'harga_per_kilo'=>$req->harga_per_kilo
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function destroy($id)
    {   
        if(Auth::user()->hak_akses=="admin"){
        $hapus=JenisCuci_model::where('id',$id)->delete();
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan admin']);
        }
    }

    public function tampil()

    {
        if(Auth::user()->hak_akses=="admin"){
            $jenis_cuci=JenisCuci_model::get();
            return response()->json($jenis_cuci);
        }else{
            return response()->json(['status'=>'anda bukan admin']);

        }
    }

}
