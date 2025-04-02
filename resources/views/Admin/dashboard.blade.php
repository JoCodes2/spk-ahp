@extends('Layouts.Base')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="m-0 font-weight-bold"><i class="fa-solid fa-book pr-2"></i> Dashboard</h3>
        </div>
        <div class="card-body">
            <h5>Selamat Datang di Sistem Pendukung Keputusan (SPK) Pemilihan Anggota Marching Band</h5>
            <p>
                Sistem ini bertujuan untuk membantu proses pengambilan keputusan dalam memilih anggota marching band dengan menggunakan metode <strong>Analytical Hierarchy Process (AHP)</strong>.
            </p>
            <p>
                AHP adalah metode pengambilan keputusan yang membantu menentukan prioritas dan membuat keputusan berdasarkan berbagai kriteria yang telah ditentukan. Dalam sistem ini, beberapa kriteria digunakan untuk menilai calon anggota marching band, dan setiap kriteria diberikan bobot untuk menunjukkan seberapa penting kriteria tersebut dalam penilaian.
            </p>

            <h5>Cara Pengisian Bobot Kriteria</h5>
            <p>
                Setiap kriteria yang digunakan untuk menilai calon anggota marching band memiliki rentang nilai bobot yang diberikan oleh admin. Nilai bobot ini mencerminkan tingkat kepentingan setiap kriteria dalam memilih anggota.
            </p>
            <p>
                Rentang angka bobot yang digunakan adalah sebagai berikut:
            </p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Angka</th>
                        <th>Arti</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Perbandingan sama pentingnya antara dua kriteria</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Satu kriteria sedikit lebih penting daripada kriteria lainnya</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Satu kriteria cukup lebih penting daripada kriteria lainnya</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Satu kriteria sangat lebih penting daripada kriteria lainnya</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Satu kriteria mutlak lebih penting daripada kriteria lainnya</td>
                    </tr>
                    <tr>
                        <td>2, 4, 6, 8</td>
                        <td>Nilai-nilai yang berada di antara angka-angka di atas, digunakan untuk memberikan bobot yang lebih tepat</td>
                    </tr>
                </tbody>
            </table>
            <p>
                Sebagai contoh, jika kriteria "Pengalaman" dianggap lebih penting daripada "Kordinasi TIM", maka admin dapat memberikan nilai 5 pada "Pengalaman" dibandingkan "Tinggi Badan". Proses ini dilakukan untuk setiap kriteria yang terlibat dalam seleksi anggota marching band.
            </p>
            <p>
                Setelah semua kriteria diberi bobot, AHP akan menghitung prioritas relatif dari setiap kriteria dan menghasilkan hasil akhir dalam bentuk peringkat berdasarkan skor total setiap calon anggota.
            </p>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
