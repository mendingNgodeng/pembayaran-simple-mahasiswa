<!-- Modal Edit -->
<div x-show="openEdit" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div @click.away="openEdit = false" class="bg-white p-6 rounded shadow w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Edit Pembayaran</h2>
        <form id="form-edit">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" x-model="editData.id">
            <div class="mb-4">
                <label class="block">Mahasiswa</label>
                <select name="mahasiswa_id" class="w-full border rounded p-2" x-model="editData.mahasiswa_id" >
                    @foreach($mahasiswa as $m)
                    <option value="{{ $m->id }}">{{ $m->mhsw_nim }} - {{ $m->mhsw_nama }}</option>
                    @endforeach
                </select>
                 <span id="edit-error-mahasiswa_id" class="text-red-500 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_bayar" class="w-full border rounded p-2" x-model="editData.tanggal_bayar" >
                 <span id="edit-error-tanggal_bayar" class="text-red-500 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block">Jumlah</label>
                <input type="number" name="jumlah" class="w-full border rounded p-2" x-model="editData.jumlah" >
                 <span id="edit-error-jumlah" class="text-red-500 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded p-2" x-model="editData.keterangan"></textarea>
                 <span id="edit-error-keterangan" class="text-red-500 text-sm"></span>
            </div>

            <div class="flex justify-end">
                <button type="button" @click="openEdit = false" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Perbarui</button>
            </div>
        </form>
    </div>
</div>
