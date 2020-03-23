<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');

Route::post('detail_transaksi', 'DetailTransaksiController@store')->middleware('jwt.verify');
Route::put('detail_edit/{id}', 'DetailTransaksiController@update')->middleware('jwt.verify');
Route::get('tampil_detail', 'DetailTransaksiController@tampil')->middleware('jwt.verify');
Route::delete('hapus_detail/{id}', 'DetailTransaksiController@destroy')->middleware('jwt.verify');

Route::post('jenis_cuci', 'JenisCuciController@store')->middleware('jwt.verify');
Route::put('jenis_edit/{id}', 'JenisCuciController@update')->middleware('jwt.verify');
Route::get('tampil_jenis', 'JenisCuciController@tampil')->middleware('jwt.verify');
Route::delete('hapus_jenis/{id}', 'JenisCuciController@destroy')->middleware('jwt.verify');

Route::post('pelanggan', 'PelangganController@store')->middleware('jwt.verify');
Route::put('pelanggan_edit/{id}', 'PelangganController@update')->middleware('jwt.verify');
Route::get('tampil_pelanggan', 'PelangganController@tampil')->middleware('jwt.verify');
Route::delete('hapus_pelanggan/{id}', 'PelangganController@destroy')->middleware('jwt.verify');

Route::post('transaksi', 'TransaksiController@store')->middleware('jwt.verify');
Route::put('transaksi_edit/{id}', 'TransaksiController@update')->middleware('jwt.verify');
Route::get('tampil_transaksi/{tgl_transaksi}/{tgl_selesai}', 'TransaksiController@getTransaksi')->middleware('jwt.verify');
Route::delete('hapus_transaksi/{id}', 'TransaksiController@destroy')->middleware('jwt.verify');


