@extends('dekanat.layouts.main')

@section('content')
    <div class="row mb-4">
        <div class="col-md-6" style="margin-bottom: 10px">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Grafik Per-Jenis Magang</h4>
                    <canvas id="jenisKegiatanChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Program Studi</p>
                            <p class="fs-30 mb-2">{{ $totalProgramStudi }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Instansi</p>
                            <p class="fs-30 mb-2">{{ $totalInstansi }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Pengajuan</p>
                            <p class="fs-30 mb-2">{{ $totalPengajuan }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Jenis Kegiatan</p>
                            <p class="fs-30 mb-2">2</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 20px">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kategori Instansi</h4>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div style="width: 100%; height: 400px;">
                                <canvas id="kategoriInstansiChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Data grafik jenis kegiatan
            var jenisKegiatanData = {!! json_encode($jenisKegiatan) !!};

            // Labels dan data untuk chart
            var labels = Object.keys(jenisKegiatanData);
            var data = Object.values(jenisKegiatanData);

            // Pengaturan opsi grafik
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            // Inisialisasi grafik menggunakan Chart.js
            var ctx = document.getElementById('jenisKegiatanChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Data',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: options
            });

            // Data untuk pie chart kategori instansi
            var kategoriInstansiData = {!! json_encode($kategoriInstansi) !!};

            var pieLabels = Object.keys(kategoriInstansiData);
            var pieData = Object.values(kategoriInstansiData);

            // Inisialisasi pie chart menggunakan Chart.js
            var ctxPie = document.getElementById('kategoriInstansiChart').getContext('2d');
            var kategoriInstansiChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieData,
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF'
                        ],
                        hoverBackgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF'
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>
@endsection
