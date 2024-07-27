@extends('cdc.layouts.main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Pengajuan</h4>

            <!-- Filter and Export Button -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <select name="semester" class="form-control" id="semesterFilter">
                        <option value="">Semua Semester</option>
                        <option value="ganjil" {{ request('semester') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ request('semester') === 'genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="tahun" class="form-control" placeholder="Tahun"
                        value="{{ request('tahun') }}" id="tahunFilter">
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" id="exportButton" class="btn btn-success">Export Excel</button>
                </div>
            </div>

            <!-- Data Table -->
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
                                            Ganjil/{{ $data->tahun }}
                                        @elseif ($data->semester === 'genap')
                                            Genap/{{ $data->tahun }}
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
            // Ambil nilai filter dari inputan
            var semester = document.getElementById('semesterFilter').value;
            var tahun = document.getElementById('tahunFilter').value;

            // Bangun URL untuk ekspor dengan filter
            var exportUrl = "{{ route('cetakdata.export.dataajuan') }}" + "?semester=" + encodeURIComponent(
                    semester) +
                "&tahun=" + encodeURIComponent(tahun);
            window.location.href = exportUrl;
        });
    </script>
@endsection
