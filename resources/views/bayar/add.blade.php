<!-- Jangan gunakan x-data di sini karena sudah ada di luar -->
<div x-show="openAdd" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div @click.away="openAdd = false" class="bg-white p-6 rounded shadow w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Tambah Data Pembayaran</h2>
        <form id="form-tambah">
            @csrf
            <div class="mb-4 ">
                <label class="block">Mahasiswa</label>
                <select name="mahasiswa_id"  id="" class="w-full border rounded p-2">
                    @foreach($mahasiswa as $m)
                    <option value="{{ $m->id }}">{{$m->mhsw_nim }} - {{$m->mhsw_nama}}</option>
                    @endforeach
                </select>
                 <span id="error-mahasiswa_id" class="text-red-500 text-sm"></span>

                
            </div>
            <div class="mb-4">
                <label class="block">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_bayar" class="w-full border rounded p-2" >
                 <span id="error-tanggal_bayar" class="text-red-500 text-sm"></span>

            </div>
            <div class="mb-4">
                <label class="block">Jumlah</label>
                <input type="number" name="jumlah" class="w-full border rounded p-2" >
                 <span id="error-jumlah" class="text-red-500 text-sm"></span>

            </div>
            <div class="mb-4">
                <label class="block">Keterangan</label>
                <textarea name="keterangan" row="20" class="w-full border rounded p-2"></textarea>
                 <span id="error-keterangan" class="text-red-500 text-sm"></span>

            </div>
            <div class="flex justify-end">
                <button type="button" @click="openAdd = false;$nextTick(() => { 
    document.getElementById('form-tambah').reset();
    document.querySelectorAll('#form-tambah span[id^=error-]').forEach(el => el.textContent = '');
})" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
