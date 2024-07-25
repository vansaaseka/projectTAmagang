@extends('cdc.layouts.main')

@section('content')
<div class="container-fluid content-inner mt-n6 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Daftar Mahasiswa</h4>
                    </div>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambahMahasiswa">Tambah Mahasiswa</button>
                </div>

                {{-- Modal Tambah --}}
                <div class="modal fade" id="modalTambahMahasiswa" tabindex="-1" role="dialog" aria-labelledby="modalTambahMahasiswaLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahMahasiswaLabel">Tambah Data Mahasiswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Tambah Nama Mahasiswa -->
                                <form id="formTambahMahasiswa" action="{{ route('datamahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nama Mahasiswa</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Mahasiswa" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Mahasiswa" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nim">NIM</label>
                                        <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM Mahasiswa" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_wa">No WA</label>
                                        <input type="number" class="form-control" id="no_wa" name="no_wa" placeholder="Masukkan nomor WA" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="prodi_id">Prodi</label>
                                        <select name="prodi_id" class="form-control" required>
                                            <option value="">-- Pilih Prodi --</option>
                                            @foreach ($prodi as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table id="mahasiswaTable" class="table table-striped mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Prodi</th>
                                    <th>NIM</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($mahasiswa as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ optional($data->units)->nama_prodi }}</td>
                                        <td>{{ $data->nim }}</td>
                                        <td>
                                            <a href="{{ route('datamahasiswa.ubahstatus', $data->id) }}" class="btn btn-sm btn-{{ $data->status == 1 ? 'success' : 'danger' }}">
                                                {{ $data->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <!-- Button Edit -->
                                            <button class="btn btn-sm btn-icon btn-primary mr-2" data-toggle="modal" data-target="#modalEditMahasiswa{{ $data->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <!-- Button Delete -->
                                            <button type="button" class="btn btn-sm btn-icon btn-danger delete-btn" data-id="{{ $data->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form action="{{ route('datamahasiswa.delete', $data->id) }}" method="POST" style="display: none;" id="deleteForm{{ $data->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEditMahasiswa{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditMahasiswaLabel{{ $data->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditMahasiswaLabel{{ $data->id }}">Edit Data Mahasiswa</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Form Edit Mahasiswa -->
                                                    <form id="formEditMahasiswa{{ $data->id }}" action="{{ route('datamahasiswa.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="name">Nama Mahasiswa</label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nim">Email</label>
                                                            <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nim">NIM</label>
                                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ $data->nim }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="no_wa">Nomor WA</label>
                                                            <input type="number" class="form-control" id="no_wa" name="no_wa" value="{{ $data->no_wa }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="prodi_id">Prodi</label>
                                                            <select name="prodi_id" class="form-control">
                                                                <option value="">-- Pilih Prodi --</option>
                                                                @foreach ($prodi as $unit)
                                                                    <option value="{{ $unit->id }}" {{ $data->prodi_id == $unit->id ? 'selected' : '' }}>{{ $unit->nama_prodi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="password">Password (Biarkan kosong jika tidak ingin mengubah)</label>
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Baru">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mahasiswaTable').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                "pageLength": 10, // Jumlah baris per halaman
                "order": [], // Menonaktifkan pengurutan default
                "language": {
                    "paginate": {
                        "previous": "&laquo;",
                        "next": "&raquo;"
                    },
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "zeroRecords": "Tidak ada data yang sesuai",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Data tidak tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)"
                }
            });
        });

        // Delete button action with SweetAlert confirmation
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
    </script>
@endpush
