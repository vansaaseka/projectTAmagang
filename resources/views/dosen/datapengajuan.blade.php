@extends('dosen.layouts.main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Pengajuan</h4>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('datapengajuan.index') }}">
                <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label"><b>Filter Status</b></label>
                    <div class="col-sm-4">
                        <select class="form-control" id="status" name="status" onchange="this.form.submit()">
                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                            <option value="ajuan diproses" {{ request('status') == 'ajuan diproses' ? 'selected' : '' }}>
                                Ajuan Diproses</option>
                            <option value="perbaikan proposal"
                                {{ request('status') == 'perbaikan proposal' ? 'selected' : '' }}>Perbaikan Proposal
                            </option>
                            <option value="proses validasi" {{ request('status') == 'proses validasi' ? 'selected' : '' }}>
                                Proses Validasi Pimpinan SV</option>
                            <option value="approve" {{ request('status') == 'approve' ? 'selected' : '' }}>Approve</option>
                            <option value="siap download" {{ request('status') == 'siap download' ? 'selected' : '' }}>Siap
                                Download</option>
                            <option value="magang selesai" {{ request('status') == 'magang selesai' ? 'selected' : '' }}>
                                Magang Selesai</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Ajaran</th>
                            <th>Nama Mahasiswa</th>
                            <th>Prodi</th>
                            <th>NIM</th>
                            <th>Jenis Kegiatan</th>
                            <th>Nama Instansi</th>
                            <th>Proposal</th>
                            <th>Status Ajuan</th>
                            <th>Nilai</th>
                            <th>Laporan Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataajuan->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">Data kosong</td>
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
                                    <td>{{ $data->users->units->nama_prodi }}</td>
                                    <td>{{ $data->users->nim }}</td>
                                    <td>
                                        @if ($data->jenis_kegiatan === 'individu')
                                            <label>Individu</label>
                                        @elseif ($data->jenis_kegiatan === 'kelompok')
                                            <button class="badge badge-primary border-0" data-id="{{ $data->id }}"
                                                data-toggle="modal"
                                                data-target="#modalKelompok{{ $data->id }}">Kelompok</button>
                                        @endif
                                    </td>
                                    <td>{{ $data->instansis->nama_instansi }}</td>
                                    <td>
                                        <a href="{{ 'storage/' . $data->proposals->nama_file }}"
                                            class="badge badge-info border-0" target="_blank">Proposal</a>
                                    </td>
                                    <td>
                                        @if ($data->status === 'ajuan diproses')
                                            <button class="badge badge-primary border-0">Ajuan Diproses</button>
                                        @elseif ($data->status === 'perbaikan proposal')
                                            <button class="badge badge-danger border-0 text-white bg-danger">Perbaikan
                                                Proposal</button>
                                        @elseif ($data->status === 'proses validasi')
                                            <button class="badge badge-secondary border-0 text-dark">Proses Validasi
                                                Pimpinan
                                                SV</button>
                                        @elseif ($data->status === 'approve')
                                            <button class="badge badge-warning border-0 text-dark">Approve</button>
                                        @elseif ($data->status === 'siap download')
                                            <span class="badge badge-success text-light">Siap Download</span>
                                        @elseif ($data->status === 'magang selesai')
                                            <span class="badge badge-primary text-light">Magang Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($data->file_nilai))
                                            <p data-toggle="modal" data-id="{{ $data->id }}"
                                                data-target="#nilaiMagang{{ $data->id }}">-</p>
                                        @else
                                            <a href="{{ 'storage/' . $data->file_nilai }}"
                                                class="badge badge-secondary border-0" target="_blank">Lihat</a>
                                        @endif
                                    </td>
            </div>
            <td>
                @if (empty($data->laporan_akhir))
                    <p data-toggle="modal" data-id="{{ $data->id }}" data-target="#laporanAkhir{{ $data->id }}">-
                    </p>
                @else
                    <a href="{{ 'storage/' . $data->laporan_akhir }}" class="badge badge-secondary border-0"
                        target="_blank">Lihat</a>
                @endif
            </td>
            <!-- Modal Kelompok -->
            <div class="modal fade" id="modalKelompok{{ $data->id }}" tabindex="-1" role="dialog"
                aria-labelledby="modalKelompokLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalKelompokLabel">Daftar Kelompok
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @php
                                $proditerlibatIds = json_decode($data->anggota_id, true);
                            @endphp

                            @if (!empty($proditerlibatIds))
                                @foreach ($proditerlibatIds as $index => $prodiItem)
                                    @php
                                        $prodiId = $prodiItem['id'];
                                        $prodi = App\Models\Anggota::find($prodiId);
                                    @endphp
                                    @if ($prodi)
                                        <p class="m-0 font-weight-bold">{{ $index + 1 }}.
                                            {{ $prodi->nama }}</p>
                                        <p class="m-0">NIM :{{ $prodi->nim }}</p>
                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <p>Data anggota tidak ditemukan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <td>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#detailModal{{ $data->id }}"><i
                        class="fas fa-info-circle fa-sm"></i></button>

                <!-- Modal Detail -->
                <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1"
                    aria-labelledby="detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title fs-5" id="detailModalLabel">Detail Pengajuan
                                </h3>
                                <button type="button" class="btn btn-close" data-dismiss="modal"
                                    aria-label="Close">x</button>
                            </div>
                            <div class="modal-body">
                                <table id="table" style="width: 100% !important;">
                                    <tbody>
                                        <tr>
                                            <th>Nama Mahasiswa</th>
                                            <td>:</td>
                                            <td>{{ $data->users->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIM</th>
                                            <td>:</td>
                                            <td>{{ $data->users->nim }}</td>
                                        </tr>
                                        <tr>
                                            <th>Prodi</th>
                                            <td>:</td>
                                            <td>{{ $data->users->units->nama_prodi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Judul Kegiatan</th>
                                            <td>:</td>
                                            <td>{{ $data->proposals->judul_proposal }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pembimbing</th>
                                            <td>:</td>
                                            <td>{{ $data->dosenPembimbing ? $data->dosenPembimbing->name : 'Dosen Tidak Ditemukan' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Bobot SKS</th>
                                            <td>:</td>
                                            <td>{{ $data->bobot_sks }}</td>
                                        </tr>
                                        <tr>
                                            <th>Instansi</th>
                                            <td>:</td>
                                            <td>{{ $data->instansis->nama_instansi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Instansi</th>
                                            <td>:</td>
                                            <td>{{ $data->instansis->alamat_instansi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <td>:</td>
                                            <td>{{ $data->tanggal_mulai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <td>:</td>
                                            <td>{{ $data->tanggal_selesai }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
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
        $('.approve-btn').on('click', function() {
            var id = $(this).data('id');
            console.log('Approve button clicked');
            Swal.fire({
                title: 'Anda yakin?',
                text: "Menyetujui Ajuan Magang ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9ADE7B',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, saya setuju!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#approveForm' + id).submit();
                }
            });
        });
    </script>
@endsection
