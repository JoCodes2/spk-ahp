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
                        <tr><td colspan="4" class="text-center">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        function getDataCriteria() {
            let tbody = $("#tbody");
            let tbodyBobot = $("#tbody-bobot");
            tbody.html('<tr><td colspan="3" class="text-center">Memuat data...</td></tr>');
            tbodyBobot.html('<tr><td colspan="4" class="text-center">Memuat data...</td></tr>');

            $.ajax({
                url: `/v1/criteria`,
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

                            tbodyBobot.append(`
                                <tr>
                                    <td>${no}</td>
                                    <td>${item.code}</td>
                                    <td>
                                        <input type="hidden" class="criteria-id" value="${item.id}">
                                        <input type="number" step="0.01" min="0" class="form-control weight" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-save">Simpan</button>
                                    </td>
                                </tr>
                            `);
                            no++;
                        });
                    } else {
                        tbody.html('<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>');
                        tbodyBobot.html('<tr><td colspan="4" class="text-center">Data tidak ditemukan</td></tr>');
                    }
                },
                error: function() {
                    tbody.html('<tr><td colspan="3" class="text-center text-danger">Gagal mengambil data</td></tr>');
                    tbodyBobot.html('<tr><td colspan="4" class="text-center text-danger">Gagal mengambil data</td></tr>');
                }
            });
        }

        $(document).on("click", ".btn-save", function() {
            let row = $(this).closest("tr");
            let criteriaId = row.find(".criteria-id").val();
            let weight = row.find(".weight").val();
            let btn = $(this);

            if (!weight || parseFloat(weight) <= 0) {
                alert("Masukkan bobot yang valid!");
                return;
            }

            btn.prop("disabled", true).text("Menyimpan...");

            $.ajax({
                url: "/v1/criteria-values/create",
                method: "POST",
                data: {
                    criteria_id: criteriaId,
                    weight: weight,
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    alert("Data bobot berhasil disimpan!");
                    row.find(".weight").val("");
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan saat menyimpan data.");
                    console.error(xhr.responseJSON);
                },
                complete: function() {
                    btn.prop("disabled", false).text("Simpan");
                }
            });
        });

        getDataCriteria();
    });
</script>
@endsection
