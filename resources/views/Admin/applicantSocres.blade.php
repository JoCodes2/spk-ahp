@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold"><i class="fa-solid fa-book pr-2"></i>Nilai Kandidat</h3>
        </div>

        <div class="card-body py-2">
            <div class="py-3">
                <h6>Nilai Kandidat</h6>
                <form id="app-scores">
                    <table id="dataCriteria" class="table table-bordered table-striped">
                        <thead>
                            <tr id="criteriaHead">
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </form>

                <div class="mt-3">
                    <button id="saveData" class="btn btn-outline-success"><i class="fa fa-save"></i> Simpan Data</button>
                    <button id="clearData" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Bersihkan Form</button>
                    <button id="deleteData" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Hapus Data</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        fetchData();
        function fetchData() {
            $.ajax({
                url: "/v1/criteria-values",
                method: "GET",
                dataType: "json",
                success: function(criteriaResponse) {
                    $.ajax({
                        url: "/v1/applicant",
                        method: "GET",
                        dataType: "json",
                        success: function(candidatesResponse) {
                            $.ajax({
                                url: "/v1/applicants-scores/",
                                method: "GET",
                                dataType: "json",
                                success: function(scoresResponse) {
                                    console.log(scoresResponse);

                                    generateTable(criteriaResponse.data, candidatesResponse.data, scoresResponse.data);

                                    if (scoresResponse.data.length > 0) {
                                        $("#saveData, #clearData").hide();
                                        $("#deleteData").show();
                                    } else {
                                        $("#saveData, #clearData").show();
                                        $("#deleteData").hide(); 
                                    }
                                },
                                error: function(error) {
                                    console.error("Error fetching scores:", error);
                                }
                            });
                        },
                        error: function(error) {
                            console.error("Error fetching candidates:", error);
                        }
                    });
                },
                error: function(error) {
                    console.error("Error fetching criteria:", error);
                }
            });
        }

        function generateTable(criteria, candidates, scores) {
            let criteriaHead = $("#criteriaHead");
            let tbody = $("#tbody");

            criteriaHead.find("th:gt(0)").remove();
            tbody.empty();

            criteria.forEach(criterion => {
                criteriaHead.append(`<th>${criterion.criteria.code}</th>`);
            });

            candidates.forEach(candidate => {
                let row = `<tr><td>${candidate.code}</td>`;

                criteria.forEach(criterion => {
                    let scoreValue = "";
                    let matchedScore = scores.find(score =>
                        score.applicant_id === candidate.id && score.criteria_value.criteria_id === criterion.criteria.id
                    );

                    if (matchedScore) {
                        scoreValue = matchedScore.score;
                        row += `<td>${scoreValue}</td>`;
                    } else {
                        row += `<td>
                            <input type="number" class="form-control nilai-input" step="0.1" min="0.1" max="9"
                                data-applicant-id="${candidate.id}" data-criteria-id="${criterion.id}" value="">
                        </td>`;
                    }
                });

                row += `</tr>`;
                tbody.append(row);
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

        $("#saveData").click(function(e) {
            e.preventDefault();


        });
        $(document).on("click", "#saveData", function(e){
            e.preventDefault();
            function saveData(){
                let values = {};
                let isValid = true;
                let firstErrorMessage = "";

                $(".nilai-input").each(function() {
                    let applicantId = $(this).data("applicant-id");
                    let criteriaId = $(this).data("criteria-id");
                    let score = $(this).val().trim();
                    let errorMessage = "";

                    if (score === "") {
                        errorMessage = "Nilai tidak boleh kosong!";
                    } else if (isNaN(score)) {
                        errorMessage = "Masukkan angka yang valid!";
                    } else {
                        score = parseFloat(score);
                        if (score < 0.1) {
                            errorMessage = "Nilai harus lebih dari 0.1!";
                        } else if (score > 9) {
                            errorMessage = "Nilai maksimal adalah 9!";
                        }
                    }

                    if (errorMessage) {
                        $(this).addClass("border-danger").removeClass("border-success");
                        if (firstErrorMessage === "") {
                            firstErrorMessage = errorMessage;
                        }
                        isValid = false;
                    } else {
                        $(this).removeClass("border-danger").addClass("border-success");
                    }
                    if (!values[applicantId]) {
                        values[applicantId] = {};
                    }
                    values[applicantId][criteriaId] = score;
                });

                if (!isValid) {
                    Swal.fire({
                        icon: "warning",
                        title: '<span style="font-size: 22px"> Validasi Gagal!</span>',
                        text: firstErrorMessage,
                        confirmButtonText: "OK",
                        confirmButtonColor: "#FFA500"
                    });
                    return;
                }

                $.ajax({
                    url: "/v1/applicants-scores/create/",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        values: values
                    },
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
            confirmAlert("Apakah semua nilai sudah benar?", saveData);
        })

        $("#clearData").click(function() {
            $(".nilai-input").val("").removeClass("border-success border-danger");
        });

        $(document).on("click", "#deleteData", function (e) {
            e.preventDefault();

            function deleteData() {
                $.ajax({
                    type: "DELETE",
                    url: "/v1/applicants-scores/delete",
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

            confirmAlert("Apakah Anda yakin ingin menghapus semua data?", deleteData);
        });
    });
</script>
@endsection
