<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use App\Models\Mahasiswa;
use App\Models\Pembayaran;

class BayarController extends Controller
{

    public function index()
    {
        $bayar = Pembayaran::with('mahasiswa')->orderBy('created_at','desc')->get();
        $mahasiswa = Mahasiswa::all();
        return view('bayar.index',compact('bayar','mahasiswa'));
    } 

    public function store(Request $request)
{
    $request->validate([
        'mahasiswa_id' => 'required',
        'tanggal_bayar' => 'required',
        'jumlah' => 'required|numeric',
        'keterangan' => 'required'
    ],[
        'mahasiswa_id.required'   => 'Mahasiswa wajib dipilih.',
        'tanggal_bayar.required'  => 'Tanggal pembayaran wajib diisi.',
        'jumlah.required'         => 'Jumlah pembayaran wajib diisi.',
        'jumlah.numeric'          => 'Jumlah pembayaran harus berupa angka.',
        'keterangan.required'     => 'Keterangan wajib diisi.'
    ]);

    $bayar = Pembayaran::create([
        'mahasiswa_id' => $request->mahasiswa_id,
        'tanggal_bayar' => $request->tanggal_bayar,
        'jumlah' => $request->jumlah,
        'keterangan' => $request->keterangan,
    ]);

        $bayar = Pembayaran::with('mahasiswa')->find($bayar->id);

    return response()->json([
        'status' => 'success',
        'message' => 'Data berhasil ditambahkan.',
        'data' => $bayar,
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'mahasiswa_id' => 'required',
        'tanggal_bayar' => 'required',
        'jumlah' => 'required|numeric',
        'keterangan' => 'required'
    ],[
        'mahasiswa_id.required'   => 'Mahasiswa wajib dipilih.',
        'tanggal_bayar.required'  => 'Tanggal pembayaran wajib diisi.',
        'jumlah.required'         => 'Jumlah pembayaran wajib diisi.',
        'jumlah.numeric'          => 'Jumlah pembayaran harus berupa angka.',
        'keterangan.required'     => 'Keterangan wajib diisi.'
    ]);

    $bayar = Pembayaran::findOrFail($id);
    $bayar->update([
        'mahasiswa_id' => $request->mahasiswa_id,
        'tanggal_bayar' => $request->tanggal_bayar,
        'jumlah' => $request->jumlah,
        'keterangan' => $request->keterangan,
    ]);

    // i forghot
      $bayar->load('mahasiswa');
    return response()->json([
        'status' => 'success',
        'message' => 'Data berhasil diperbarui.',
        'data' => $bayar
    ]);
}


public function destroy($id)
{
    $bayar = Pembayaran::find($id);

    if (!$bayar) {
        return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
    }

    $bayar->delete();
    return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
}

}
