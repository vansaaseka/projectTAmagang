@extends('mahasiswa.layouts.main')

@section('content')
    <h2>Edit Profil</h2>
    <form action="{{ route('profileUpdate') }}" method="POST">
        @csrf
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Profil</h4>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $users->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $users->email }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nip" class="col-sm-3 col-form-label">NIM</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nim" name="nim"
                                value="{{ $users->nim }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nip" class="col-sm-3 col-form-label">Prodi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="prodi_id" name="prodi_id"
                                value="{{ $users->prodi_id }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_wa" class="col-sm-3 col-form-label">Nomor WA</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" id="no_wa" name="no_wa"
                                value="{{ $users->no_wa }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_wa" class="col-sm-3 col-form-label">Update Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan password baru">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <button type="reset" class="btn btn-light">Cancel</button>
                            <button type="submit" class="btn btn-primary mr-2">Update Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
