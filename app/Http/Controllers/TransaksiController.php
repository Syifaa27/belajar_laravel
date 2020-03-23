<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi_model;
use Validator;
use Auth;
use DB;


class TransaksiController extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->hak_akses=="petugas"){
        $validator=Validator::make($req->all(),
            [
                'id_pelanggan'=>'required',
                'id_petugas'=>'required',
                'tgl_transaksi'=>'required',
                'tgl_selesai'=>'required'
            ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $simpan=Transaksi_model::create([
                'id_pelanggan'=>$req->id_pelanggan,
                'id_petugas'=>$req->id_petugas,
                'tgl_transaksi'=>$req->tgl_transaksi,
                'tgl_selesai'=>$req->tgl_selesai                
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan petugas']);
        }
    }
    
    public function getTransaksi(Request $r){
        if(Auth::user()->hak_akses=="petugas"){
          $transaksi = DB::table('transaksi')
          ->join('pelanggan', 'pelanggan.id', '=', 'transaksi.id_pelanggan')
          ->join('petugas', 'petugas.id', '=', 'transaksi.id_petugas')
          ->where('tgl_transaksi', '>=', $r->tgl_transaksi)
          ->where('tgl_transaksi', '<=', $r->tgl_selesai)
          ->select('transaksi.tgl_transaksi', 'pelanggan.nama', 'pelanggan.alamat', 'pelanggan.telp',
                  'transaksi.tgl_selesai', 'transaksi.id')
          ->get();
    
          $hasil = array();
    
          foreach ($transaksi as $t){
            $grand = DB::table('detail_transaksi')
            ->where('id_transaksi', '=', $t->id)
            ->groupBy('id_transaksi')
            ->select(DB::raw('sum(subtotal) as grandtotal'))
            ->first();
    
            $detail = DB::table('detail_transaksi')
            ->join('jenis_cuci', 'jenis_cuci.id', '=', 'detail_transaksi.id_jenis')
            ->where('id_transaksi', '=', $t->id)
            ->select('detail_transaksi.*', 'jenis_cuci.*')
            ->get();
    
            $hasil2 = array();
    
            foreach ($detail as $d){
              $hasil2[] = array(
                'id transaksi' => $d->id_transaksi,
                'jenis cuci' => $d->nama_jenis,
                'qty' => $d->qty,
                'subtotal' => $d->subtotal
              );
            }
    
            $hasil[] = array(
              'tgl transaksi' => $t->tgl_transaksi,
              'nama' => $t->nama,
              'alamat' => $t->alamat,
              'telp' => $t->telp,
              'tgl selesai' => $t->tgl_selesai,
              'total transaksi' => $grand,
              'detail transaksi' => $hasil2,
            );
          }
    
          return response()->json(compact('hasil'));
    
        } else {
          echo "Hanya petugas yang bisa mengakses!";
        }
      }

    public function update($id,Request $req)
    {
        if(Auth::user()->hak_akses=="petugas"){
        $validator=Validator::make($req->all(),
        [
            'id_pelanggan'=>'required',
            'id_petugas'=>'required',
            'tgl_transaksi'=>'required',
            'tgl_selesai'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Transaksi_model::where('id',$id)->update ([
                'id_pelanggan'=>$req->id_pelanggan,
                'id_petugas'=>$req->id_petugas,
                'tgl_transaksi'=>$req->tgl_transaksi,
                'tgl_selesai'=>$req->tgl_selesai
        ]);
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan petugas']);
        }
    }
    public function destroy($id)
    {   
        if(Auth::user()->hak_akses=="petugas"){
        $hapus=Transaksi_model::where('id',$id)->delete();
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>'anda bukan petugas']);
        }
    }

    public function tampil()

    {
        if(Auth::user()->hak_akses=="petugas"){
            $dt_transaksi=Transaksi_model::get();
            return response()->json($dt_transaksi);
        }else{
            return response()->json(['status'=>'anda bukan petugas']);

        }
    }

}
