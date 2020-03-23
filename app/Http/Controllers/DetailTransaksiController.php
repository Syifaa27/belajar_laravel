<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailTransaksi_model;
use App\JenisCuci_model;
use Validator;
use Auth;


class DetailTransaksiController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->hak_akses=="petugas"){
        $validator=Validator::make($req->all(),
            [
                'id_transaksi'=>'required',
                'id_jenis'=>'required',
                'qty'=>'required'
            ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $harga = JenisCuci_model::where('id',$req->id_jenis)->first();
        $subtotal = @$harga->harga_per_kilo * $req->qty;

        $simpan=DetailTransaksi_model::create([
                'id_transaksi'=>$req->id_transaksi,
                'id_jenis'=>$req->id_jenis,
                'qty'=>$req->qty,
                'subtotal'=>$subtotal
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan petugas']);
        }
    }

    public function update($id,Request $req)
    {
        if(Auth::user()->hak_akses=="petugas"){
        $validator=Validator::make($req->all(),
        [
                'id_transaksi'=>'required',
                'id_jenis'=>'required',
                'qty'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $harga = JenisCuci_model::where('id',$req->id_jenis)->first();
        $subtotal = $harga->harga_per_kilo * $req->qty;

        $ubah=DetailTransaksi_model::where('id',$id)->update ([
            'id_transaksi'=>$req->id_transaksi,
            'id_jenis'=>$req->id_jenis,
            'qty'=>$req->qty,
            'subtotal'=>$subtotal
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan petugas']);
        }
    }
    public function destroy($id)
    {   
        if(Auth::user()->hak_akses=="petugas"){
        $hapus=DetailTransaksi_model::where('id',$id)->delete();
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan petugas']);
        }
    }

    public function tampil()

    {
        if(Auth::user()->hak_akses=="petugas"){
            $detail_transaksi=DetailTransaksi_model::get();
            return response()->json($detail_transaksi);
        }else{
            return response()->json(['status'=>'anda bukan petugas']);

        }
    }

}
