@extends('cdc.layouts.main')

@section('content')
<div class="container-fluid content-inner mt-n6 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Daftar Admin</h4>
                    </div>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambahAdmin">Tambah User</button>
                </div>

                {{-- Modal Tambah --}}
                <div class="modal fade" id="modalTambahAdmin" tabindex="-1" role="dialog" aria-labelledby="modalTambahAdminLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahAdminLabel">Tambah Data Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Tambah Nama Admin -->
                                <form id="formTambahAdmin" action="{{ route('dataadmin.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nim">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_wa">No WA</label>
                                        <input type="number" class="form-control" id="no_wa" name="no_wa" placeholder="Masukkan nomor WA" required>
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
                        <table id="basic-table" class="table table-striped mb-0" role="grid">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($admin as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->nip }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>
                                            <a href="{{ route('dataadmin.ubahstatus', $data->id) }}" class="btn btn-sm btn-{{ $data->status == 1 ? 'success' : 'danger' }}">
                                                {{ $data->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <!-- Button Edit -->
                                            <button class="btn btn-sm btn-icon btn-primary mr-2" data-toggle="modal" data-target="#modalEditAdmin{{ $data->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <!-- Button Delete -->
                                            <button type="button" class="btn btn-sm btn-icon btn-danger delete-btn" data-id="{{ $data->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form action="{{ route('dataadmin.delete', $data->id) }}" method="POST" style="display: none;" id="deleteForm{{ $data->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEditAdmin{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditAdminLabel{{ $data->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditAdminLabel{{ $data->id }}">Edit Data Admin</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Form Edit Admin -->
                                                    <form id="formEditAdmin{{ $data->id }}" action="{{ route('dataadmin.update', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="name">Nama</label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nim">Email</label>
                                                            <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nim">NIP</label>
                                                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $data->nip }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="no_wa">Nomor WA</label>
                                                            <input type="number" class="form-control" id="no_wa" name="no_wa" value="{{ $data->no_wa }}">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#basic-table').DataTable({
                "lengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(filter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "&laquo;",
                        "previous": "&raquo"
                    }
                },
                "column                .Defs": [
                    { "width": "10%", "targets": 0 },
                    { "width": "20%", "targets": 5 }
                ],
                "order": [],
                "responsive": true
            });

            // Delete button action 
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
        });
    </script>
@endpush

