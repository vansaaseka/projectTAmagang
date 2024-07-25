@extends('mahasiswa.layouts.main')

@section('content')
    <div class="card">
        <br>
        <div id="dataTableHover_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <a href="/datapengajuan" type="button" class="btn btn-primary">Kembali Ke Halaman
                Pengajuan
            </a>
        </div>
        <br />

        <h2 class="text-success text-center">
            <strong>SUCCESS !</strong>
        </h2>
        <br>
        <div class="row justify-content-center">
            <div class="col-3">
                <img src="{{ asset('assets/images/img-success.png') }}" class="img-fluid" alt="fit-image">
            </div>
        </div>
        <br>
        <br>
        <div class="row justify-content-center">
            <div class="col-7 text-center">
                <h5 class="purple-text text-center">Data berhasil Ditambahkan</h5>
            </div>
        </div>
    </div>
@endsection
