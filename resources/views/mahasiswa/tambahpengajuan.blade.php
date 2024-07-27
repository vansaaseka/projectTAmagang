@extends('mahasiswa.layouts.main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORM AJUAN SURAT PENGANTAR</h4>
            <p class="card-description">
                Kegiatan Magang Mahasiswa (KMM) SV UNS
            </p>

            <form action="ajuan" enctype="multipart/form-data" method="post">
                @csrf
                <fieldset id="fieldset1">
                    <input type="hidden" name="jenis_ajuan" value="jenis_baru">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap*</label>
                                <input class="form-control" placeholder="Nama Ketua Kelompok/Individu" name="user_id"
                                    value="{{ auth()->user()->name }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran Semester*</label>
                                <select class="form-control" name="semester">
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kegiatan KMM*</label>
                                <select class="form-control" name="jenis_kegiatan" id="jenis_kegiatan">
                                    <option value="individu">Individu</option>
                                    <option value="kelompok">Kelompok</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun*</label>
                                <input class="form-control" placeholder="2024" name="tahun" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Dosen Pembimbing*</label>
                                <input type="text" class="form-control" id="nama_dosen" name="dosen_pembiming"
                                    placeholder="Ketik untuk mencari dosen pembimbing" autocomplete="off">
                                <input type="hidden" id="dosen_pembimbing_id" name="dosen_pembimbing" />
                                <div id="nama_dosen_list"
                                    style="position: absolute; z-index: 1000; display: none; width: 100%; max-height: 200px; overflow-y: auto; border: 1px solid #ccc; background-color: #fff;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Angkatan*</label>
                                <input class="form-control" placeholder="2022" name="angkatan" />
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai Magang*</label>
                                <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="tanggal_mulai" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Selesai Magang*</label>
                                <input type="date" class="form-control" placeholder="dd/mm/yyyy"
                                    name="tanggal_selesai" />
                            </div>
                        </div>
                    </div>
                    <!-- untuk anggota -->
                    <div id="anggota_section" style="display: none;">
                        <!-- untuk anggota 1 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama (Anggota 1)</label>
                                    <input type="text" class="form-control" placeholder="Nama Anggota" name="nama[]" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIM (Anggota 1)</label>
                                    <input type="text" class="form-control" placeholder="NIM Anggota" name="nim[]" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- untuk menambah anggota lain -->
                    <div id="tambah_anggota_section" style="display: none; margin-bottom: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success" id="tambah_anggota">Tambah Anggota</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="button" class="next btn btn-info">Lanjut</button>
                    </div>
                </fieldset>
                <!-- Fieldset Kedua -->
                <fieldset id="fieldset2" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Instansi*</label>
                                <div class="col-sm-9">
                                    <select class="form-control nama_instansi select2" name="nama_instansi"
                                        style="width: 100%"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kategori Instansi*</label>
                                <div class="col-sm-9">
                                    <select class="form-control kategori-instansi" name="kategori_instansi_id"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nomor Telpon Instansi*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="no_telpon" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bobot SKS*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="bobot_sks">
                                        <option value="2">2</option>
                                        <option value="4">4</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Alamat Surat Pengantar*</label>
                                    <p class="card-description">
                                        Contoh : Yth.Kepala Dinas Pertanahan Kota Surakarta atau CEO Gojek Indonesia.
                                    </p>
                                    <input type="text" class="form-control" name="alamat_surat" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Alamat Instansi*</label>
                                <p class="card-description">
                                    Contoh : Jalan Raya Songgo Langit 20, Gentan, Baki, Sukoharjo Jawa Tengah 57194
                                </p>
                                <textarea name="alamat_instansi" class="w-100 form-control" style="height: 150px !important"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label">Judul Proposal KMM*</label>
                            <p class="card-description">
                                Contoh : Perbedaan Tingkat Stres Kerja Pegawai PT Adem Ayem Indonesia.
                                JANGAN KAPITAL SEMUA
                            </p>
                            <input type="text" class="form-control" name="judul_proposal" />
                        </div>
                    </div>
                    <div class="row" style="padding: 15px">
                        <div class="form-group">
                            <label class="col-form-label">Upload Proposal KMM*</label>
                            <p class="card-description">
                                Silahkan upload proposal yang sudah disetujui Pembimbing Magang dan Kaprodi. Tanda
                                tangan
                                Wakil Dekan 1 akan
                                dibubuhkan pada file yang di-upload ke form ini dan dikirimkan kembali ke mahasiswa
                                bersama
                                Surat Pengantar. <br>
                                NAMA FILE NIM-NamaMhs-ProposalKMM.pdf.
                            </p>
                            <div class="input-group col-xs-12">
                                <input type="file" accept=".pdf" name="nama_file"
                                    class="form-control file-upload-info" placeholder="Upload File">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light previous">Kembali</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fieldsets = document.querySelectorAll('fieldset');
            let currentFieldsetIndex = 0;

            const showFieldset = index => {
                fieldsets.forEach((fieldset, i) => {
                    if (i === index) {
                        fieldset.style.display = 'block';
                    } else {
                        fieldset.style.display = 'none';
                    }
                });
            };

            showFieldset(currentFieldsetIndex);

            document.querySelector('.next').addEventListener('click', function() {
                currentFieldsetIndex++;
                if (currentFieldsetIndex >= fieldsets.length) {
                    currentFieldsetIndex = 0;
                }
                showFieldset(currentFieldsetIndex);
            });

            document.querySelector('.previous').addEventListener('click', function() {
                currentFieldsetIndex--;
                if (currentFieldsetIndex < 0) {
                    currentFieldsetIndex = fieldsets.length - 1;
                }
                showFieldset(currentFieldsetIndex);
            });
            document.querySelector('#jenis_kegiatan').addEventListener('change', function() {
                const
                    anggotaSection = document.getElementById('anggota_section');
                const
                    tambahAnggotaSection = document.getElementById('tambah_anggota_section');
                if (this.value === 'individu') {
                    anggotaSection.style.display = 'none';
                    tambahAnggotaSection.style.display = 'none';
                } else {
                    anggotaSection.style.display = 'block';
                    tambahAnggotaSection.style.display = 'block';
                }
            });
            const
                tambahAnggotaButton = document.querySelector('#tambah_anggota');
            const
                anggotaSection = document.getElementById('anggota_section');
            tambahAnggotaButton.addEventListener('click', function() {
                if (anggotaSection.children.length < 4) {
                    const newAnggotaRow = document.createElement('div');
                    newAnggotaRow.classList.add('row');
                    newAnggotaRow.innerHTML = ` <div class="col-md-6">
        <div class="form-group">
            <label>Nama (Anggota ${anggotaSection.children.length + 1})</label>
            <input type="text" class="form-control" placeholder="Nama Anggota" name="nama[]" />
        </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>NIM (Anggota ${anggotaSection.children.length + 1})</label>
                <input type="text" class="form-control" placeholder="NIM Anggota" name="nim[]" />
            </div>
        </div>
        `;
                    anggotaSection.appendChild(newAnggotaRow);
                }
                if (anggotaSection.children.length >= 4) {
                    tambahAnggotaButton.style.display = 'none';
                }
            });

            const namaDosenInput = document.querySelector('#nama_dosen');
            const namaDosenList = document.querySelector('#nama_dosen_list');
            const dosenPembimbingIdInput = document.querySelector('#dosen_pembimbing_id');

            namaDosenInput.addEventListener('input', function() {
                const inputText = this.value.trim().toLowerCase();
                if (inputText.length === 0) {
                    namaDosenList.innerHTML = '';
                    return;
                }

                const data = {!! json_encode($dosen) !!};

                const filteredData = data.filter(dosen => dosen.name.toLowerCase().includes(inputText));

                if (filteredData.length > 0) {
                    const suggestions = filteredData.map(dosen =>
                        `<div class="suggestion" data-id="${dosen.id}">${dosen.name}</div>`).join('');
                    namaDosenList.innerHTML = suggestions;
                    namaDosenList.style.display = 'block';
                } else {
                    namaDosenList.innerHTML = '<div class="suggestion">Tidak ada hasil</div>';
                    namaDosenList.style.display = 'block';
                }
            });

            namaDosenList.addEventListener('click', function(e) {
                const selectedDosen = e.target.closest('.suggestion');
                if (selectedDosen) {
                    const namaDosen = selectedDosen.textContent;
                    namaDosenInput.value = namaDosen;
                    namaDosenList.innerHTML = '';
                    namaDosenList.style.display = 'none';

                    const dosenId = selectedDosen.dataset.id;
                    dosenPembimbingIdInput.value = dosenId;
                }
            });

            document.addEventListener('click', function(e) {
                if (!namaDosenList.contains(e.target)) {
                    namaDosenList.innerHTML = '';
                    namaDosenList.style.display = 'none';
                }
            });

        });


        $('.kategori-instansi').select2({
            placeholder: 'Pilih atau tambahkan kategori instansi',
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            },
            ajax: {
                url: '/get-categories',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama_kategori,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script>
        // Inisialisasi select2 untuk nama_instansi
        $('.nama_instansi').select2({
            placeholder: 'Pilih atau tambahkan nama instansi',
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            },
            ajax: {
                url: '/get-instansi',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama_instansi,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script>
        $('.kategori-instansi').select2({
            placeholder: 'Pilih atau tambahkan kategori instansi',
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            },
            ajax: {
                url: '/get-categories', // Pastikan URL ini sesuai dengan rute di Laravel
                dataType: 'json',

                delay: 100,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item
                                    .nama_kategori,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: -70px;
            height: 48px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px;
        }

        .select2-container--default .select2-selection--single {
            height: 48px;
        }

        .suggestion {
            padding: 5px 10px;
            cursor: pointer;
        }

        .suggestion:hover {
            background-color: #f0f0f0;
        }
    </style>
@endsection
