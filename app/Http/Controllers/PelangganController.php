<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan_model;
use Validator;
use Auth;


class PelangganController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->hak_akses=="admin"){
        $validator=Validator::make($req->all(),
            [
                'nama'=>'required',
                'alamat'=>'required',
                'telp'=>'required'

        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $simpan=Pelanggan_model::create([
                'nama'=>$req->nama,
                'alamat'=>$req->alamat,
                'telp'=>$req->telp
                
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
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Pelanggan_model::where('id',$id)->update ([
            'nama'=>$req->nama,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function destroy($id)
    {   
        if(Auth::user()->hak_akses=="admin"){
        $hapus=Pelanggan_model::where('id',$id)->delete();
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan admin']);
        }
    }

    public function tampil()

    {
        if(Auth::user()->hak_akses=="admin"){
            $pelanggan=Pelanggan_model::get();
            return response()->json($pelanggan);
        }else{
            return response()->json(['status'=>'anda bukan admin']);

        }
    }

}
