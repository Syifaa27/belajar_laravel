<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi_model extends Model
{
    protected $table="transaksi";
    protected $primaryKey="id";
    protected $fillable = [
       'id_pelanggan', 'id_petugas', 'tgl_transaksi','tgl_selesai'
    ];
}
