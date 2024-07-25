@extends('cdc.layouts.main')

@section('content')
    <div class="container-fluid content-inner mt-n6 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Daftar Prodi</h4>
                        </div>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modalTambahDekanat">Tambah Prodi</button>
                    </div>

                    {{-- Modal Tambah --}}
                    <div class="modal fade" id="modalTambahDekanat" tabindex="-1" role="dialog"
                        aria-labelledby="modalTambahDekanatLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTambahDekanatLabel">Tambah Data Prodi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formTambahProdi" action="{{ route('dataprodi.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="namadekan">Nama Prodi</label>
                                            <input type="text" class="form-control" id="namaprodi" name="namaprodi"
                                                placeholder="Masukkan Nama">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
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
                                        <th>Nama Prodi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($prodi as $data)
                                        <tr role="row" class="odd">
                                            <th scope="row">{{ $no++ }}</th>
                                            <td>{{ $data->nama_prodi }}</td>
                                            <td class="text-center">
                                                <!-- Button Edit -->
                                                <button type="button" style="display: inline;"
                                                    class="btn btn-sm btn-icon btn-primary mr-2" data-toggle="modal"
                                                    data-target="#modalEditProdi{{ $data->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <!-- Button Delete -->
                                                <button type="button" style="display: inline;"
                                                    class="btn btn-sm btn-icon btn-danger delete-btn"
                                                    data-id="{{ $data->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <form action="{{ route('dataprodi.delete', $data->id) }}" method="POST"
                                                    style="display: none;" id="deleteForm{{ $data->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        {{-- Modal Edit --}}
                                        <div class="modal fade" id="modalEditProdi{{ $data->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalEditProdiLabel{{ $data->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditProdiLabel{{ $data->id }}">
                                                            Edit Data Prodi</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('dataprodi.update', ['id' => $data->id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="editNamaProdi">Nama Prodi</label>
                                                                <input type="text" class="form-control"
                                                                    id="editNamaProdi" name="namaprodi"
                                                                    placeholder="Masukkan Nama Prodi"
                                                                    value="{{ $data->nama_prodi }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
    var table = $('#basic-table').DataTable({
        "pageLength": 10,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ entri",
            "search": "Cari:",
            "paginate": {
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            }
        },
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"bottom"p><"clear">',
        "initComplete": function() {
            // Custom styling for better integration with Bootstrap
            $('.dataTables_filter').addClass('float-right');
            $('.dataTables_length').addClass('float-left');
        },
        "drawCallback": function(settings) {
            // Event delegation for delete button
            $('.delete-btn').off('click').on('click', function() {
                var id = $(this).data('id');
                console.log("Tombol hapus diklik untuk ID: " + id);

                // Tampilkan SweetAlert2 untuk konfirmasi penghapusan
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
        }
    });
});


    </script>
@endpush
