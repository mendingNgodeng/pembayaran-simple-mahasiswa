<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::orderBy('created_at','desc')->get();
        return view('mahasiswa.index',compact('mahasiswa'));
    } 

    public function store(Request $request)
    {
    $request->validate([
        'mhsw_nim' => 'required|unique:mahasiswas,mhsw_nim',
        'mhsw_nama' => 'required',
        'mhsw_alamat' => 'nullable',
    ],
    [
        'mhsw_nim.required' => 'NIM wajib diisi.',
        'mhsw_nim.unique'   => 'NIM sudah terdaftar, gunakan NIM lain.',
        'mhsw_nama.required' => 'Nama mahasiswa wajib diisi.',
    ]);

    $mhs = Mahasiswa::create([
        'mhsw_nim' => $request->mhsw_nim,
        'mhsw_nama' => $request->mhsw_nama,
        'mhsw_alamat' => $request->mhsw_alamat,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Data berhasil ditambahkan.',
        'data' => $mhs
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
       'mhsw_nim' => [
        'required',
        Rule::unique('mahasiswas', 'mhsw_nim')->ignore($id),
    ],
        'mhsw_nama' => 'required',
        'mhsw_alamat' => 'nullable',
    ], [
        'mhsw_nim.required' => 'NIM tidak boleh kosong.',
        'mhsw_nim.unique'   => 'NIM ini sudah digunakan oleh mahasiswa lain.',
        'mhsw_nama.required' => 'Nama mahasiswa wajib diisi.',
    ]);

    $mahasiswa = Mahasiswa::findOrFail($id);

    $mahasiswa->update([
        'mhsw_nim' => $request->mhsw_nim,
        'mhsw_nama' => $request->mhsw_nama,
        'mhsw_alamat' => $request->mhsw_alamat,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Data berhasil diperbarui!',
        'data' => $mahasiswa->fresh()
    ]);
}


public function destroy($id)
{
    $mahasiswa = Mahasiswa::find($id);

    if (!$mahasiswa) {
        return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
    }
    
    $mahasiswa->delete();
    return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
}

 protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }

}
