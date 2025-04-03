@extends('Layouts.Base')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="m-0 font-weight-bold"><i class="fa-solid fa-book pr-2"></i> Hasil Perhitungan AHP</h3>
        </div>
        <div class="card-body">
            <h5>Ranking Kandidat</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Skor Akhir</th>
                    </tr>
                </thead>
                <tbody id="resultData"></tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function () {
    $.ajax({
        url: "v1/ahp",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.code === 200 && response.data.status === "success") {
                // **📌 Ranking Kandidat**
                let resultTable = "";
                 let resultData = response.data.result_data;
                resultData.forEach(item => {
                    resultTable += `<tr>
                        <td>${item.rank}</td>
                        <td>${item.applicant_name}</td>
                        <td>${item.applicant_position}</td>
                        <td>${item.final_score}</td>
                    </tr>`;
                });
                $("#resultData").html(resultTable);
            } else {
                console.error("Gagal mengambil data:", response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
});

</script>
@endsection
