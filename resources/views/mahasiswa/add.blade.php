<!-- Jangan gunakan x-data di sini karena sudah ada di luar -->
<div x-show="openAdd" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div @click.away="openAdd = false" class="bg-white p-6 rounded shadow w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Tambah Mahasiswa</h2>
        <form id="form-tambah">
            @csrf
            <div class="mb-4">
                <label class="block">NIM</label>
                <input type="text" name="mhsw_nim" class="w-full border rounded p-2">
                 <span id="error-mhsw_nim" class="text-red-500 text-sm"></span>

            </div>
            <div class="mb-4">
                <label class="block">Nama</label>
                <input type="text" name="mhsw_nama" class="w-full border rounded p-2">
                 <span id="error-mhsw_nama" class="text-red-500 text-sm"></span>

            </div>
            <div class="mb-4">
                <label class="block">Alamat</label>
                <textarea name="mhsw_alamat" class="w-full border rounded p-2"></textarea>
                <span id="error-mhsw_alamat" class="text-red-500 text-sm"></span>
            </div>
            <div class="flex justify-end">
                <!-- reset errors message -->
                <button type="button" @click="openAdd = false;
    $nextTick(() => { 
    document.getElementById('form-tambah').reset();
    document.querySelectorAll('#form-tambah span[id^=error-]').forEach(el => el.textContent = '');
})" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Batal</button>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
