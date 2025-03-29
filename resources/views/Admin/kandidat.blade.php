@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold"><i class="fa-solid fa-book pr-2"></i> Kriteria</h3>
        </div>

        <div class="card-body py-2">
            <div class="py-3">
                <h6>Posisi</h6>
                <button type="button" class="btn btn-primary mb-3" id="btnTambahPosition">
                    <i class="fa fa-plus"></i> Tambah Posisi
                </button>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="positionBody">
                        <tr>
                            <td colspan="3" class="text-center">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="py-3">
                <h6>Data Kandidat</h6>
                <button type="button" class="btn btn-primary mb-3" id="btnTambahApplicant">
                    <i class="fa fa-plus"></i> Tambah Kandidat
                </button>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="candidateBody">
                        <tr>
                            <td colspan="5" class="text-center">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Position --}}
        <div class="modal fade" id="DataModalPosition" tabindex="-1" aria-labelledby="DataModalLabelPosition"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DataModalLabelPosition">Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="userForm" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Masukkan nama">
                                <small id="name-error" class="text-danger"></small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="simpanPosition">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Applicant --}}
        <div class="modal fade" id="DataModalApplicant" tabindex="-1" aria-labelledby="DataModalLabelApplicant"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DataModalLabelApplicant">Kandidat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="applicantForm" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Masukkan nama">
                                <small id="name-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="code">Kode</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    placeholder="Masukkan Kode">
                                <small id="code-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="position_id">Posisi</label>
                                <select class="form-control" name="position_id" id="position_id">
                                    <option value="">Pilih Posisi</option>
                                </select>
                                <small id="position-error" class="text-danger"></small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="simpanApplicant">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengambil data posisi dari API
            function getDataPosition() {
                $.ajax({
                    url: `/v1/position`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        let positionBody = $('#positionBody');
                        positionBody.empty(); // Kosongkan tabel sebelum menambah data baru

                        if (response.code === 200 && response.data && response.data.length > 0) {
                            $.each(response.data, function(index, item) {
                                let row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.name}</td>
                                        <td>
                                            <button type='button' class='btn btn-outline-danger btn-sm delete-confirm' data-id='${item.id}'>
                                                <i class='fa fa-trash'></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                positionBody.append(row);
                            });
                        } else {
                            positionBody.html(
                                `<tr><td colspan="3" class="text-center"><i class="fa-solid fa-face-sad-tear px-1"></i> Data tidak ditemukan</td></tr>`
                            );
                        }
                    },
                    error: function() {
                        console.log("Gagal mengambil data dari server");
                        $('#positionBody').html(
                            `<tr><td colspan="3" class="text-center text-danger">Gagal mengambil data!</td></tr>`
                        );
                    }
                });
            }

            // Panggil fungsi untuk menampilkan data posisi
            getDataPosition();

            // Fungsi untuk mengambil data posisi dari API
            function getDataApplicant() {
                $.ajax({
                    url: `/v1/applicant`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        let positionBody = $('#candidateBody');
                        positionBody.empty(); // Kosongkan tabel sebelum menambah data baru

                        if (response.code === 200 && response.data && response.data.length > 0) {
                            $.each(response.data, function(index, item) {
                                let row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.code}</td>
                                        <td>${item.name}</td>
                                        <td>${item.position.name}</td>
                                        <td>
                                            <button type='button' class='btn btn-outline-danger btn-sm delete-applicant' data-id='${item.id}'>
                                                <i class='fa fa-trash'></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                positionBody.append(row);
                            });
                        } else {
                            positionBody.html(
                                `<tr><td colspan="3" class="text-center"><i class="fa-solid fa-face-sad-tear px-1"></i> Data tidak ditemukan</td></tr>`
                            );
                        }
                    },
                    error: function() {
                        console.log("Gagal mengambil data dari server");
                        $('#positionBody').html(
                            `<tr><td colspan="3" class="text-center text-danger">Gagal mengambil data!</td></tr>`
                        );
                    }
                });
            }

            // Panggil fungsi untuk menampilkan data posisi
            getDataApplicant();

            // Event klik tombol tambah posisi
            $('#btnTambahPosition').click(function() {
                $('#DataModalPosition').modal('show'); // Tampilkan modal
                $('#userForm')[0].reset(); // Reset form
                $('#id').val(''); // Kosongkan input ID
                $('.text-danger').text('');
            });
            $('#btnTambahApplicant').click(function() {
                $('#DataModalApplicant').modal('show'); // Tampilkan modal
                $('#applicantForm')[0].reset(); // Reset form
                $('#id').val(''); // Kosongkan input ID
                $('.text-danger').text('');
            });

            // Setup CSRF Token untuk AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // alert success message
            function successAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                })
            }

            // alert error message
            function errorAlert() {
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            // Function to show confirmation alert
            function confirmAlert(message, callback) {
                Swal.fire({
                    title: '<span style="font-size: 22px"> Konfirmasi</span>',
                    text: message,
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya',
                    reverseButtons: true,
                    confirmButtonColor: '#48ABF7',
                    cancelButtonColor: '#EFEFEF',
                    cancelButtonText: 'Tidak',
                    customClass: {
                        cancelButton: 'text-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }

            // funtion reload
            function reloadBrowsers() {
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
            $(document).on('click', '#simpanPosition', function(e) {
                $('.text-danger').text(''); // Kosongkan pesan error sebelumnya
                e.preventDefault();

                let id = $('#id').val();
                let formData = new FormData($('#userForm')[0]);

                $.ajax({
                    type: 'POST',
                    url: `/v1/position/create`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.code === 422) {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                // Menampilkan error pada elemen <small> dengan id yang sesuai
                                $(`[name="${key}"]`).siblings('.text-danger').text(
                                    value[0]);
                            });
                        } else if (response.code === 200) {
                            $('#DataModalPosition').modal('hide');
                            successAlert();
                            reloadBrowsers();
                        } else {
                            errorAlert();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $(`[name="${key}"]`).siblings('.text-danger').text(
                                    value[0]);
                            });
                        }
                    }
                });
            });

            $(document).ready(function() {
                // Fungsi untuk mengambil daftar posisi
                function loadPositions() {
                    $.ajax({
                        url: '/v1/position', // Sesuaikan dengan endpoint Laravel yang mengembalikan daftar posisi
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            let positionDropdown = $('#position_id');
                            positionDropdown.empty();
                            positionDropdown.append('<option value="">Pilih Posisi</option>');

                            $.each(response.data, function(index, position) {
                                positionDropdown.append(
                                    `<option value="${position.id}">${position.name}</option>`
                                );
                            });
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data posisi:', xhr.responseText);
                        }
                    });
                }

                // Panggil fungsi saat modal dibuka
                $('#DataModalApplicant').on('show.bs.modal', function() {
                    loadPositions();
                });

                // AJAX untuk menyimpan data applicant
                $(document).on('click', '#simpanApplicant', function(e) {
                    $('.text-danger').text('');
                    e.preventDefault();

                    let formData = new FormData($('#applicantForm')[0]);

                    $.ajax({
                        type: 'POST',
                        url: `/v1/applicant/create`,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.code === 422) {
                                let errors = response.errors;
                                $.each(errors, function(key, value) {
                                    $(`[name="${key}"]`).siblings(
                                        '.text-danger').text(value[0]);
                                });
                            } else if (response.code === 200) {
                                $('#DataModalApplicant').modal('hide');
                                successAlert();
                                reloadBrowsers();
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    $(`[name="${key}"]`).siblings(
                                        '.text-danger').text(value[0]);
                                });
                            }
                        }
                    });
                });
            });




            // Delete data button click handler
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/v1/position/delete/${id}`,
                        success: function(response) {
                            if (response.code === 200) {
                                successAlert();
                                reloadBrowsers();
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                confirmAlert('Apakah Anda yakin ingin menghapus data?', deleteData);
            });

            // Delete data button click handler
            $(document).on('click', '.delete-applicant', function() {
                let id = $(this).data('id');

                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/v1/applicant/delete/${id}`,
                        success: function(response) {
                            if (response.code === 200) {
                                successAlert();
                                reloadBrowsers();
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                confirmAlert('Apakah Anda yakin ingin menghapus data?', deleteData);
            });



        });
    </script>
@endsection
