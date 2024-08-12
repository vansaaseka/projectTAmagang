@extends('mahasiswa.layouts.main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Pengajuan</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Ajaran</th>
                            <th>Instansi</th>
                            <th>Status Ajuan</th>
                            <th>Catatan / Komentar</th>
                            <th>Proposal</th>
                            <th>Surat Tugas</th>
                            <th>Nilai & Laporan Akhir</th>
                            <th>Surat Selesai</th>
                            <th>Aksi</th>
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
                                        @else
                                            <label>Unknown Semester/{{ $data->tahun }}</label>
                                        @endif
                                    </td>
                                    <td>{{ $data->instansis->nama_instansi }}</td>
                                    <td>
                                        @if ($data->status === 'ajuan diproses')
                                            <button class="badge badge-primary border-0">Ajuan Diproses</button>
                                        @elseif ($data->status === 'perbaikan proposal')
                                            <button class="badge badge-danger border-0 text-white bg-danger">Perbaikan
                                                Proposal</button>
                                        @elseif ($data->status === 'proses validasi')
                                            <button class="badge badge-secondary border-0 text-dark">Proses Validasi Pimpinan
                                                SV</button>
                                        @elseif ($data->status === 'approve')
                                            <button class="badge badge-warning border-0 text-dark">Approve</button>
                                        @elseif ($data->status === 'siap download')
                                            <a target="_blank" href="{{ 'storage/' . $data->surat_pengantar }}"
                                                class="badge badge-success border-0 text-light">Siap Download</a>
                                        @elseif ($data->status === 'magang selesai')
                                            <span class="badge badge-primary text-light">Magang Selesai</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if (empty($data->komentar_status))
                                            <p>Tidak ada komentar</p>
                                        @else
                                            <p>{{ $data->komentar_status }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ 'storage/' . $data->proposals->nama_file }}"
                                            class="badge badge-info border-0" target="_blank">Proposal</a>
                                    </td>
                                    <td>
                                        @if (optional($data->buktimagangs)->jawaban === 'ditolak')
                                            <span class="badge badge-danger">{{ $data->buktimagangs->jawaban }}</span>
                                        @elseif (optional($data->buktimagangs)->jawaban === 'diterima')
                                            <span class="badge badge-success">{{ $data->buktimagangs->jawaban }}</span>
                                            @if (empty($data->surat_tugas))
                                            @else
                                                <a href="{{ 'storage/surat_tugas/' . $data->surat_tugas }}"
                                                    class="badge badge-info border-0" target="_blank">Surat Tugas</a>
                                            @endif
                                        @else
                                            <p>-</p>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="badge badge-success border-0 text-dark" data-toggle="modal"
                                            data-target="#UploadFileModal{{ $data->id }}"
                                            data-id="{{ $data->id }}">Upload
                                        </button>
                                    </td>
                                    <td>
                                        @if (empty($data->surat_selesai))
                                            <p>-</p>
                                        @else
                                            <a href="{{ 'storage/' . $data->surat_selesai }}"
                                                class="badge badge-info border-0" target="_blank">Surat Selesai</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->status === 'perbaikan proposal')
                                            <button class="btn btn-primary btn-sm edit-btn" data-toggle="modal"
                                                data-target="#editModal{{ $data->id }}"
                                                data-id="{{ $data->id }}"><i class="fas fa-sm fa-edit"></i></button>
                                        @endif
                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#detailModal{{ $data->id }}"><i
                                                class="fas fa-info-circle fa-sm"></i></button>
                                        @if ($data->status === 'siap download')
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#uploadModal{{ $data->id }}"
                                                data-id="{{ $data->id }}">
                                                <a href="{{ route('dokumenmagang.index') }}?ajuan={{ $data->id }}"
                                                    style="color: white;">
                                                    <i class="fas fa-sm fa-upload"></i>
                                                </a>
                                            </button>
                                        @endif
                                        <form action="{{ route('datapengajuan.delete', $data->id) }}" method="POST"
                                            style="display:inline;" id="deleteForm{{ $data->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $data->id }}"><i
                                                    class="fas fa-trash-alt fa-sm"></i></button>
                                        </form>
                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="detailModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title fs-5" id="detailModalLabel">Detail
                                                            Pengajuan
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
                                                                    <td>{{ $data->formatted_tanggal_mulai }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tanggal Selesai</th>
                                                                    <td>:</td>
                                                                    <td>{{ $data->formatted_tanggal_selesai }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel{{ $data->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $data->id }}">Form
                                                            Upload Ulang Proposal KMM *</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editForm{{ $data->id }}"
                                                            action="{{ route('datapengajuan.update', ['id' => $data->id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="nama_file">Upload Ulang Proposal KMM*</label>
                                                                <input type="file" accept=".pdf" class="form-control"
                                                                    id="nama_file" name="nama_file"
                                                                    value="{{ $data->instansis->nama_file }}" />
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm float-end">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Upload Modal Nilai & Laporan -->
                                        <div class="modal fade" id="UploadFileModal{{ $data->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Upload Nilai & Laporan
                                                            Akhir Magang</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="uploadForm{{ $data->id }}"
                                                            action="{{ route('datapengajuan.selesaiMagang', ['id' => $data->id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="file_nilai">Nilai Akhir Magang / Sertifikat
                                                                    Magang*</label>
                                                                <input type="file" accept=".pdf" class="form-control"
                                                                    id="file_nilai" name="file_nilai"
                                                                    value="{{ $data->file_nilai }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="laporan_akhir">Laporan Akhir Magang*</label>
                                                                <input type="file" accept=".pdf" class="form-control"
                                                                    id="laporan_akhir" name="laporan_akhir"
                                                                    value="{{ $data->laporan_akhir }}" />
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm float-end">Submit</button>
                                                        </form>
                                                    </div>
                                                    <!-- Upload Modal -->
                                                    <div class="modal fade" id="UploadFileModal{{ $data->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="uploadModalLabel{{ $data->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="uploadModalLabel{{ $data->id }}">Upload
                                                                        Nilai & Laporan Akhir Magang
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="uploadForm{{ $data->id }}"
                                                                        action="{{ route('datapengajuan.upload', ['id' => $data->id]) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group">
                                                                            <label for="file_nilai">Nilai Magang</label>
                                                                            <input type="file" class="form-control"
                                                                                name="file_nilai" accept=".pdf" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="laporan_akhir">Laporan Akhir
                                                                                Magang</label>
                                                                            <input type="file" class="form-control"
                                                                                name="laporan_akhir" accept=".pdf"
                                                                                required>
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-sm float-end">Submit</button>
                                                                    </form>
                                                                </div>
                                                            </div>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle click on "Upload" button
            $('.badge-success').on('click', function() {
                var id = $(this).data('id');
                $('#UploadFileModal' + id).modal('show');
            });

            // Additional JavaScript logic can be added here as needed
        });

        $(document).ready(function() {
            // Handle edit button click
            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/dataajuan/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#editForm' + id).attr('action', '/dataajuan/update/' + id);
                        $('#tahun_ajaran_semester_id').val(data.tahun_ajaran_semester_id);
                        $('#nama_instansi').val(data.instansis.nama_instansi);
                    }
                });
            });

            // Handle delete button click
            $('.delete-btn').on('click', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus data!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteForm' + id).submit();
                    }
                });
            });

            // Handle info button click
            $('.btn-info').on('click', function() {
                var id = $(this).data('id');
                $('#UploadFileModal' + id).modal('show');
            });
        });
    </script>
@endpush
