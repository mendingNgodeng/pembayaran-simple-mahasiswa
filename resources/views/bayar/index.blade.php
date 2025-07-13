<x-app-layout>
       <div x-data="{ openAdd: false, openEdit: false, editData: {} }"
      @close-add-modal.window="openAdd = false"
      @open-edit-modal.window="openEdit = true"
      >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">

             <div class="flex justify-between p-3">
          
    <a href="/bayar/export/pdf" class="bg-yellow-400 text-white p-3 rounded-md"><i class="fa fa-download"></i> Export Semua </a>

            <button @click="openAdd = true" class="text-white hover:underline bg-green-600 p-3 rounded-md"> <i class="fas fa-plus"></i> Tambah Data</button>
            </div>
                <div class=" text-gray-900">
                 <table id="dataTables">
        <thead class="w-full table-auto bg-gray-100 text-left text-xs font-medium text-gray-700 uppercase">
            <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">NIM</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Alamat</th>
                <th class="px-6 py-3">Keterangan</th>
                <th class="px-6 py-3">Jumlah</th>
                <th class="px-6 py-3">Dibuat pada</th>
                <th class="px-6 py-3">Diperbaharui pada</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="">
            @php 
            $no=1; 
            @endphp
            @foreach ($bayar as $mhs)
                <tr data-id="{{$mhs->id}}">
                    <td class="px-6 py-3">{{ $no++ }}</td>
                    <td class="px-6 py-3">{{ $mhs->mahasiswa->mhsw_nim }}</td>
                    <td class="px-6 py-3">{{ $mhs->mahasiswa->mhsw_nama }}</td>
                    @if(isset($mhs->mahasiswa->mhsw_alamat))
                    <td class="px-6 py-3">{{ $mhs->mahasiswa->mhsw_alamat }}</td>
                    @else
                    <td class="bg-red-400 rounded-md p-1 text-center"> <span class=" ">Tidak diInput</span></td>
                    @endif
                    <td class="px-6 py-3">{{ $mhs->keterangan }}</td>
                    <td class="px-7 py-3">Rp.{{ $mhs->jumlah }}</td>
                    <td class="px-6 py-3">{{ $mhs->created_at }}</td>
                    <td class="px-6 py-3">{{ $mhs->updated_at }}</td>

                    <td class="px-6 py-3">
                        <div class="flex gap-3 justify-center">
                            <a href="/bayar/export/pdf/{{ $mhs->id }}" class="bg-yellow-400 text-white p-3 rounded"> <i class="fa fa-download"></i></a>
                            <a href="#" 
                            @click.prevent='openEdit = true; editData = {{ $mhs }};
                             $nextTick(() => {
                                document.querySelectorAll("#form-edit span[id^=edit-error-]").forEach(el => el.textContent = "");
                            });'
                            class="bg-blue-500 text-white p-3 rounded">
                               <i class="fa fa-edit"></i>
                            </a>

                            <a href="#" class="text-white hover:underline bg-red-500 p-3 rounded-md btn-delete" data-id='{{$mhs->id}}'><i class="fa fa-trash"></i></a> 
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('bayar.add')
    @include('bayar.edit')

                </div>
            </div>
        </div>
    </div>
    </div>

      <script>
$(document).ready(function () {
    // Submit form tambah
    $('#form-tambah').submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();

        $.ajax({
            url: '{{ route('bayar.store') }}',
            method: 'POST',
            data: formData,
            success: function (res) {
    if (res.status === 'success') {
        const data = res.data;
        const no = $('#dataTables tbody tr').length + 1;
        // Tambahkan ke DOM
        const newRow = `
            <tr data-id=${data.id}>
                <td class="px-6 py-3">${no}</td>
                <td class="px-6 py-3">${data.mahasiswa.mhsw_nim}</td>
                <td class="px-6 py-3">${data.mahasiswa.mhsw_nama}</td>
                <td class="px-6 py-3">${data.mahasiswa.mhsw_alamat}</td>
                <td class="px-6 py-3">${data.keterangan}</td>
                <td class="px-7 py-3">Rp. ${data.jumlah}</td>
                <td class="px-6 py-3">${new Date(data.created_at).toLocaleString('id-ID')}</td>
                <td class="px-6 py-3">${new Date(data.created_at).toLocaleString('id-ID')}</td>
                <td class="px-6 py-3">
                    <div class="flex gap-3 justify-center">
                    <a href="/bayar/export/pdf/${data.id}" class="bg-yellow-400 text-white p-3 rounded">  <i class="fa fa-download"></i></a>
                        <a href="#" @click.prevent='openEdit = true; editData = ${JSON.stringify(data)}' class="bg-blue-500 text-white p-3 rounded">  <i class="fa fa-edit"></i></a>
                           <a href="#" class="text-white hover:underline bg-red-500 p-3 rounded-md btn-delete" data-id=${data.id}><i class="fa fa-trash"></i></a> 
                    </div>
                </td>
            </tr>
        `;
        $('#dataTables tbody').append(newRow);

        // Reset dan tutup modal
        $('#form-tambah')[0].reset();
        window.dispatchEvent(new CustomEvent('close-add-modal'));

        // Tampilkan sweet alert
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: res.message,
            timer: 1500,
            showConfirmButton: false
        });
    }
}
,
            error: function (err) {
    // Clear previous error messages
    $('#form-tambah span[id^="error-"]').text('');

    if (err.status === 422) {
        let errors = err.responseJSON.errors;

        // Loop through the fields and display messages
        for (let field in errors) {
            $(`#error-${field}`).text(errors[field][0]);
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal Memasukkan data.',
        });
    }
}
        });
    });
});

// updatto
// Submit form edit from modal EDIT OF COURSE
$('#form-edit').submit(function (e) {
    e.preventDefault();

    const form = $(this);
    const formData = form.serialize();
    const id = form.find('input[name="id"]').val(); // id value
    const updated = "Updated"
    $.ajax({
        url: `/bayar/${id}`, // route update
        method: 'POST',
        data: formData,
        success: function (res) {
            if (res.status === 'success') {
                const data = res.data;

                // Update row di DOM
                const row = $(`#dataTables tbody tr[data-id="${data.id}"]`);

                row.replaceWith(`
            <tr data-id=${data.id}>
                <td class="px-6 py-3">${updated}</td>
                <td class="px-6 py-3">${data.mahasiswa.mhsw_nim}</td>
                <td class="px-6 py-3">${data.mahasiswa.mhsw_nama}</td>
                <td class="px-6 py-3">${data.mahasiswa.mhsw_alamat}</td>
                <td class="px-6 py-3">${data.keterangan}</td>
                <td class="px-7 py-3">Rp. ${data.jumlah}</td>
                <td class="px-6 py-3">${new Date(data.created_at).toLocaleString('id-ID')}</td>
                <td class="px-6 py-3">${new Date(data.created_at).toLocaleString('id-ID')}</td>
                <td class="px-6 py-3">
                    <div class="flex gap-3 justify-center">
                        <a href="/bayar/export/pdf/${data.id}" class="bg-yellow-400 text-white p-3 rounded">  <i class="fa fa-download"></i></a>
                        <a href="#" @click.prevent='openEdit = true; editData = ${JSON.stringify(data)}' class="bg-blue-500 text-white p-3 rounded">  <i class="fa fa-edit"></i></a>
                           <a href="#" class="text-white hover:underline bg-red-500 p-3 rounded-md btn-delete" data-id=${data.id}>  <i class="fa fa-trash"></i></a> 
                    </div>
                </td>
            </tr>
                `);

                // Tutup modal edit
                window.dispatchEvent(new CustomEvent('close-edit-modal'));

                // SweetAlert sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        },
        error: function (err) {
    // Clear previous error messages
    $('#form-edit span[id^="edit-error-"]').text('');

    if (err.status === 422) {
        let errors = err.responseJSON.errors;

        // Loop through the fields alllllllll
        for (let field in errors) {
            $(`#edit-error-${field}`).text(errors[field][0]);
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal memperbarui data.',
        });
    }
}
    });
});

// delete tation

$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    const id = $(this).data('id');

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data akan hilang secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/bayar/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    if (res.status === 'success') {
                        // Remove the row
                       $(`#dataTables tbody tr[data-id="${id}"]`).remove();

                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (err) {
                    console.log(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal menghapus data.',
                    });
                }
            });
        }
    });
});

</script>
</x-app-layout>
