<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi_model extends Model
{
    protected $table="detail_transaksi";
    protected $primaryKey="id";
    protected $fillable = [
       'id_transaksi', 'id_jenis','qty', 'subtotal'
    ];
}
