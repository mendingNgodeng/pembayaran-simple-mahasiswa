<x-app-layout>
    <div x-data="{ openAdd: false, openEdit: false, editData: {} }"
      @close-add-modal.window="openAdd = false"
      @open-edit-modal.window="openEdit = true"
      >
    <x-slot name="header">
    <!--  -->
        <div class="flex justify-between">
            <div class="">
                <h2 class="mt-2 font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Data Mahasiswa') }}
                </h2>
            </div>
        </div>
    </x-slot>
   
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
            <div class="flex justify-between p-3">
            <h1 class="mt-2 font-semibold text-xl text-gray-800 leading-tight">Tabel Data Input</h1>
            <button @click="openAdd = true" class="text-white hover:underline bg-green-500 p-3 rounded-md"><i class="fa fa-plus"></i> Tambah Data</button>
            </div>

        <div class=" text-gray-900 flex">
    <table id="dataTables">
        <thead class="w-full bg-gray-100 text-left text-xs font-medium text-gray-700 uppercase">
            <tr>
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">NIM</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Alamat</th>
                <th class="px-6 py-3">Dibuat pada</th>
                <th class="px-6 py-3">Diperbaharui pada</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="">
            @foreach ($mahasiswa as $mhs)
                <tr>
                    <td class="px-6 py-3">{{ $mhs->id }}</td>
                    <td class="px-6 py-3">{{ $mhs->mhsw_nim }}</td>
                    <td class="px-6 py-3">{{ $mhs->mhsw_nama }}</td>
                    @if(isset($mhs->mhsw_alamat))
                    <td class="px-6 py-3">{{ Str::limit($mhs->mhsw_alamat, 50) }}</td>
                    @else
                    <td class="bg-red-400 rounded-md p-1 text-center"> <span class=" ">Tidak diInput</span></td>
                    @endif
                    <td class="px-6 py-3">{{ $mhs->created_at }}</td>
                    <td class="px-6 py-3">{{ $mhs->updated_at }}</td>
                    <td class="px-6 py-3">
                        <div class="flex gap-3 justify-center">
                            <a href="#" 
                             @click.prevent='openEdit = true; editData = {{ $mhs }};
                             $nextTick(() => {document.querySelectorAll("#form-edit span[id^=edit-error-]").forEach(el => el.textContent = "");});'
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
</div>

@include('mahasiswa.add')
@include('mahasiswa.edit')

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
            url: '{{ route('mahasiswa.store') }}',
            method: 'POST',
            data: formData,
            success: function (res) {
    if (res.status === 'success') {
        const data = res.data;

        // Tambahkan ke DOM
        const newRow = `
            <tr>
                <td class="px-6 py-3">${data.id}</td>
                <td class="px-6 py-3">${data.mhsw_nim}</td>
                <td class="px-6 py-3">${data.mhsw_nama}</td>
                <td class="px-6 py-3">${data.mhsw_alamat}</td>
                <td class="px-6 py-3">${new Date(data.created_at).toLocaleString('id-ID')}</td>
                <td class="px-6 py-3">${new Date(data.updated_at).toLocaleString('id-ID')}</td>
                <td class="px-6 py-3">
                    <div class="flex gap-3 justify-center">
                        <a href="#" @click.prevent='openEdit = true; editData = ${JSON.stringify(data)}' class="bg-blue-500 text-white p-3 rounded">  <i class="fa fa-edit"></i></a>
                           <a href="#" class="text-white hover:underline bg-red-500 p-3 rounded-md btn-delete" data-id=${data.id}>  <i class="fa fa-trash"></i></a> 
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



// Submit form edit from modal EDIT OF COURSE
$('#form-edit').submit(function (e) {
    e.preventDefault();

    const form = $(this);
    const formData = form.serialize();
    const id = form.find('input[name="id"]').val(); // id value

    $.ajax({
        url: `/mahasiswa/${id}`, // route update
        method: 'POST',
        data: formData,
        success: function (res) {
            if (res.status === 'success') {
                const data = res.data;

                // Update row di DOM
                const row = $(`#dataTables tbody tr`).filter(function () {
                    return $(this).find('td:first').text() == data.id;
                });

                row.html(`
                    <td class="px-6 py-3">${data.id}</td>
                    <td class="px-6 py-3">${data.mhsw_nim}</td>
                    <td class="px-6 py-3">${data.mhsw_nama}</td>
                    <td class="px-6 py-3">${data.mhsw_alamat ?? '<span class="bg-red-400 p-1 rounded">Tidak diinput</span>'}</td>
                    <td class="px-6 py-3">${new Date(data.created_at).toLocaleString('id-ID')}</td>
                    <td class="px-6 py-3">${new Date(data.updated_at).toLocaleString('id-ID')}</td>
                    <td class="px-6 py-3">
                        <div class="flex gap-3 justify-center">
                            <a href="#" 
                                @click.prevent='openEdit = true; editData = ${JSON.stringify(data)}'
                                class="bg-blue-500 text-white p-3 rounded">  <i class="fa fa-edit"></i></a>
                            <a href="#" class="text-white hover:underline bg-red-500 p-3 rounded-md btn-delete" data-id=${data.id}><i class="fa fa-trash"></i></a> 
                        </div>
                    </td>
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

        // Loop through the fields and display messages
        for (let field in errors) {
            $(`#edit-error-${field}`).text(errors[field][0]);
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal Update data.',
        });
    }
}
    });
});

// Delete!!!!
// Handle delete button
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
                url: `/mahasiswa/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    if (res.status === 'success') {
                        // Remove the row
                        
                        $(`#dataTables tbody tr`).filter(function () {
                            return $(this).find('td:first').text() == id;
                        }).remove();

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
