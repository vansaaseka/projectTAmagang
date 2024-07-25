@extends('mahasiswa.layouts.main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Dokumen Jawaban</h1>
            <p class="card-description">
                Silahkan Upload Dokumen Jawaban dari Instansi
            </p>

            <form action="{{ route('dokumenmagang.store', ['id' => $dokumen->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="jawaban" value="diterima" required>
                                    Diterima
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="jawaban" value="ditolak" required>
                                    Ditolak
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label">Silahkan upload file jawaban instansi bisa dalam bentuk surat
                                atau bukti chat WhatsApp (.pdf/.png/.jpg)</label>

                            <div class="input-group col-xs-12">
                                <input type="file" accept=".pdf,.png,.jpg" name="nama_file"
                                    class="form-control file-upload-info" placeholder="Upload File">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </form>
            <hr>
        </div>
    </div>

    <style>
        .form-group.row,
        .form-group {
            margin-bottom: 10px;
        }

        .form-check-inline {
            margin-right: 10px;
        }

        .form-control-file {
            display: block;
            width: 100%;
            margin-top: 10px;
        }
    </style>
@endsection
