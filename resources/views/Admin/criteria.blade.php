@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold"><i class="fa-solid fa-book pr-2"></i>Kriteria</h3>
        </div>

        <div class="card-body py-2">
            <div class="py-3">
                <h6>Nama Kriteria</h6>
                <table id="dataCriteria" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Code</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr><td colspan="3" class="text-center">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="py-3">
                <h6>Bobot Kriteria</h6>
                <form id="criteriaForm" class="criteria-form" novalidate>

                    <table id="dataCriteriaValues" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code Kriteria</th>
                                <th>Bobot</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-bobot">
                            <tr>
                                <td colspan="4" class="text-center">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        function getDataCriteria() {
            let tbody = $("#tbody");
            let tbodyBobot = $("#tbody-bobot");
            tbody.html('<tr><td colspan="3" class="text-center">Memuat data...</td></tr>');
            tbodyBobot.html('<tr><td colspan="4" class="text-center">Memuat data...</td></tr>');

            $.ajax({
                url: "/v1/criteria",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    tbody.empty();
                    tbodyBobot.empty();

                    if (response.code === 200 && response.data.length > 0) {
                        let no = 1;
                        response.data.forEach(function(item) {
                            tbody.append(`
                                <tr>
                                    <td>${no}</td>
                                    <td>${item.code}</td>
                                    <td>${item.name}</td>
                                </tr>
                            `);
                            no++;
                        });
                    } else {
                        tbody.html('<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>');
                    }
                },
                error: function() {
                    tbody.html('<tr><td colspan="3" class="text-center text-danger">Gagal mengambil data</td></tr>');
                }
            });

            // Ambil data bobot
            $.ajax({
                url: "/v1/criteria-values",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    tbodyBobot.empty();
                    if (response.code === 200) {
                        let no = 1;
                        let criteriaUsed = [];

                        // 🔹 Urutkan berdasarkan kode criteria agar dinamis
                        let sortedData = response.data.sort((a, b) => {
                            let codeA = a.criteria.code.match(/\d+/) ? parseInt(a.criteria.code.match(/\d+/)[0]) : 0;
                            let codeB = b.criteria.code.match(/\d+/) ? parseInt(b.criteria.code.match(/\d+/)[0]) : 0;
                            return codeA - codeB;
                        });

                        sortedData.forEach(function(item) {
                            criteriaUsed.push(item.criteria_id);
                            tbodyBobot.append(`
                                <tr>
                                    <td>${no}</td>
                                    <td>${item.criteria.code}</td>
                                    <td>${item.weight}</td>
                                    <td>
                                        <button class="btn btn-outline-danger btn-delete" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            `);
                            no++;
                        });

                        $.ajax({
                            url: '/v1/criteria',
                            method: "GET",
                            dataType: "json",
                            success: function(response) {
                                if (response.code === 200 && response.data.length > 0) {
                                    let sortedCriteria = response.data.sort((a, b) => {
                                        let codeA = a.code.match(/\d+/) ? parseInt(a.code.match(/\d+/)[0]) : 0;
                                        let codeB = b.code.match(/\d+/) ? parseInt(b.code.match(/\d+/)[0]) : 0;
                                        return codeA - codeB;
                                    });

                                    sortedCriteria.forEach(function(item) {
                                        if (!criteriaUsed.includes(item.id)) {
                                            tbodyBobot.append(`
                                                <tr>
                                                    <td>${no}</td>
                                                    <td>${item.code}</td>
                                                    <td>
                                                        <input type="hidden" class="criteria-id" value="${item.id}">
                                                        <input type="number" name="weight" id="weight" class="form-control weight" min="0.1" max="9" step="0.1">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline-success btn-save"><i class="fas fa-check-square"></i></button>
                                                    </td>
                                                </tr>
                                            `);
                                            no++;
                                        }
                                    });
                                }
                            }
                        });
                    } else {
                        tbodyBobot.html('<tr><td colspan="4" class="text-center">Data tidak ditemukan</td></tr>');
                    }
                },
                error: function() {
                    tbodyBobot.html('<tr><td colspan="4" class="text-center text-danger">Gagal mengambil data</td></tr>');
                }
            });
        }

        function successAlert(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            })
        }

        function errorAlert() {
            Swal.fire({
                title: 'Error',
                text: 'Terjadi kesalahan!',
                icon: 'error',
                showConfirmButton: false,
                timer: 1000,
            });
        }

        function reloadBrowsers() {
            setTimeout(function() {
                location.reload();
            }, 1500);
        }


        function confirmAlert(message, callback) {
            Swal.fire({
                title: '<span style="font-size: 22px"> Konfirmasi!</span>',
                html: message,
                showCancelButton: true,
                showConfirmButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya',
                reverseButtons: true,
                confirmButtonColor: '#48ABF7',
                cancelButtonColor: '#EFEFEF',
                customClass: {
                    cancelButton: 'text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }


        function applyValidation() {
            $("#criteriaForm").validate({
                rules: {
                    weight: {
                        required: true,
                        number: true,
                        min: 0.1,
                        max: 9,
                    }
                },
                messages: {
                    weight: {
                        required: "Bobot tidak boleh kosong!",
                        number: "Masukkan angka yang valid!",
                        min: "Bobot harus lebih dari 0.1!",
                        max: "Maksimal bobot 9!"
                    }
                },
                highlight: function (element) {
                    $(element).removeClass("border-success").addClass("border-danger");
                },
                success: function (label, element) {
                    $(element).removeClass("border-danger").addClass("border-success");
                },
                errorPlacement: function (error, element) {
                    error.addClass("text-danger text-sm");
                    error.insertAfter(element);
                }
            });
        }

        applyValidation();

        $(document).on("click", ".btn-save", function () {
            let row = $(this).closest("tr");
            let criteriaId = row.find(".criteria-id").val();
            let weightInput = row.find(".weight");

            if (!$("#criteriaForm").valid()) return;

            let weight = weightInput.val();

            $.ajax({
                type: "POST",
                url: "/v1/criteria-values/create",
                data: {
                    criteria_id: criteriaId,
                    weight: weight,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.code == 200) {
                        successAlert();
                        getDataCriteria();
                    } else {
                        errorAlert();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    errorAlert();
                }
            });
        });


        $(document).on("click", ".btn-delete", function (e) {
            e.preventDefault();

            let id = $(this).data("id");

            function deleteData() {
                $.ajax({
                    type: "DELETE",
                    url: `/v1/criteria-values/delete/${id}`,
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        if (response.code == 200) {
                            successAlert();
                            reloadBrowsers();
                        } else {
                            errorAlert();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        errorAlert();
                    }
                });
            }

            confirmAlert("Apakah Anda yakin ingin menghapus data?", deleteData);
        });
        getDataCriteria();
    });
</script>
@endsection
