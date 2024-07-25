@extends('cdc.layouts.main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Pengajuan</h4>

            <!-- Export Button -->
            <div class="row mb-3">
                <div class="col-md-12 text-right">
                    <button type="button" id="exportButton" class="btn btn-success">Export Excel</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Ajaran</th>
                            <th>Nama Mahasiswa</th>
                            <th>Prodi</th>
                            <th>NIM</th>
                            <th>Dosen Pembimbing</th>
                            <th>Jenis Kegiatan</th>
                            <th>Instansi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataajuan->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center">Data kosong</td>
                            </tr>
                        @else
                            @php $no = 1; @endphp
                            @foreach ($dataajuan as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        @if ($data->semester === 'ganjil')
                                            <label>Ganjil/{{ $data->tahun }}</label>
                                        @elseif ($data->semester === 'genap')
                                            <label>Genap/{{ $data->tahun }}</label>
                                        @endif
                                    </td>
                                    <td>{{ $data->users->name }}</td>
                                    <td>{{ $data->users->units ? $data->users->units->nama_prodi : 'Prodi Tidak Ditemukan' }}
                                    </td>
                                    <td>{{ $data->users->nim }}</td>
                                    <td>{{ $data->dosenPembimbing ? $data->dosenPembimbing->name : 'Dosen Tidak Ditemukan' }}
                                    </td>
                                    <td>
                                        @if ($data->jenis_kegiatan === 'individu')
                                            Individu
                                        @elseif ($data->jenis_kegiatan === 'kelompok')
                                            Kelompok
                                        @endif
                                    </td>
                                    <td>{{ $data->instansis ? $data->instansis->nama_instansi : 'Instansi Tidak Ditemukan' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('exportButton').addEventListener('click', function() {
            window.location.href = "{{ route('cetakdata.export.dataajuan') }}";
        });
    </script>
@endsection
