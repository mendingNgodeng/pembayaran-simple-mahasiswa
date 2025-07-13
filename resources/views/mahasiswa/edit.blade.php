<div x-show="openEdit" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div @click.away="openEdit = false" class="bg-white p-6 rounded shadow w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Edit Mahasiswa</h2>
        <form id="form-edit">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" x-model="editData.id">

            <div class="mb-4">
                <label class="block">NIM</label>
                <input type="text" name="mhsw_nim" class="w-full border rounded p-2" x-model="editData.mhsw_nim">
                 <span id="edit-error-mhsw_nim" class="text-red-500 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block">Nama</label>
                <input type="text" name="mhsw_nama" class="w-full border rounded p-2" x-model="editData.mhsw_nama">
                 <span id="edit-error-mhsw_nama" class="text-red-500 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block">Alamat</label>
                <textarea name="mhsw_alamat" class="w-full border rounded p-2" x-model="editData.mhsw_alamat"></textarea>
                <span id="edit-error-mhsw_alamat" class="text-red-500 text-sm"></span>

            </div>

            <div class="flex justify-end">
                <button type="button" @click="openEdit = false" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Perbarui</button>
            </div></form></div></div>
