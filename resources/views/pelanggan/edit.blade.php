@extends('layouts.base')

@section('content')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div style="display: flex; align-items: center;">
                                    <i class="fa fa-user-secret" style="font-size: 30px; margin-right: 13px;"></i>
                                    <b>Edit data Pelanggan</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="/customers/{{ $customer->nik }}" method="post" id="Penduduk">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_nik" id="_nik" value="{{ $customer->nik }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="nik">NIK</label>
                                        <input autocomplete="off" maxlength="16" type="text" name="nik"
                                            id="nik" class="form-control" value="{{ $customer->nik }}">
                                        <small class="text-danger" id="msg_nik">{{ $errors->first('nik') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="nama_lengkap">Nama lengkap</label>
                                        <input autocomplete="off" type="text" name="nama_lengkap" id="nama_lengkap"
                                            class="form-control" value="{{ $customer->nama }}">
                                        <small class="text-danger"
                                            id="msg_nama_lengkap">{{ $errors->first('nama_lengkap') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="nama_panggilan">Nama Panggilan</label>
                                        <input autocomplete="off" type="text" name="nama_panggilan" id="nama_panggilan"
                                            class="form-control" value="{{ $customer->nama_panggilan }}">
                                        <small class="text-danger">{{ $errors->first('nama_panggilan') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input autocomplete="off" type="text" name="tempat_lahir" id="tempat_lahir"
                                            class="form-control" value="{{ $customer->tempat_lahir }}">
                                        <small class="text-danger">{{ $errors->first('tempat_lahir') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" for="tgl_lahir">
                                        <label for="simpleDataInput">Tgl Lahir</label>
                                        <div class="input-group date">
                                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control"
                                                value={{ $customer->tgl_lahir }} id="simpleDataInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="position-relative mb-3">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="js-select-2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option {{ $customer->jk == 'L' ? 'selected' : '' }} value="L">Laki-Laki
                                            </option>
                                            <option {{ $customer->jk == 'P' ? 'selected' : '' }} value="P">Perempuan
                                            </option>
                                        </select>
                                        <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="no_kk">No. KK</label>
                                        <input autocomplete="off" type="text"maxlength="16" name="no_kk" id="no_kk"
                                            class="form-control" value="{{ $customer->kk }}">
                                        <small class="text-danger">{{ $errors->first('no_kk') }}</small>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="alamat">Alamat KTP</label>
                                        <input autocomplete="off"type="text" name="alamat" id="alamat"
                                            class="form-control" value="{{ $customer->alamat }}">
                                        <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="domisi">Domisi saat ini</label>
                                        <input autocomplete="off" type="text" name="domisi" id="domisi"
                                            class="form-control" value="{{ $customer->domisi }}">
                                        <small class="text-danger">{{ $errors->first('domisi') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="desa">Desa/Kelurahan</label>
                                        <select class="js-select-2 form-control" name="desa" id="desa">
                                            @foreach ($desa as $ds)
                                                <option value="">{{ $ds->nama }}</option>
                                                <option value="{{ $ds->id }}"
                                                    {{ $customer->desa == $ds->id ? 'selected' : '' }}>
                                                    {{ $ds->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('desa') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="agama">Agama</label>
                                        <select class="js-select-2 form-control" name="agama" id="agama"
                                            class="form-control">
                                            <option {{ $customer->agama == 'islam' ? 'selected' : '' }} value="islam">
                                                Islam
                                            </option>
                                            <option {{ $customer->agama == 'kristen_protestan' ? 'selected' : '' }}
                                                value="kristen_protestan">Kristen Protestan</option>
                                            <option {{ $customer->agama == 'kristen_katolik' ? 'selected' : '' }}
                                                value="kristen_katolik">Kristen Katolik</option>
                                            <option {{ $customer->agama == 'hindu' ? 'selected' : '' }} value="hindu">
                                                Hindu
                                            </option>
                                            <option {{ $customer->agama == 'buddha' ? 'selected' : '' }} value="buddha">
                                                Buddha
                                            </option>
                                            <option {{ $customer->agama == 'konghucu' ? 'selected' : '' }}
                                                value="konghucu">
                                                Konghucu</option>
                                        </select>
                                        <small class="text-danger">{{ $errors->first('agama') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="position-relative mb-3">
                                        <label for="pendidikan">Pendidikan</label>
                                        <select class="js-select-2 form-control" name="pendidikan" id="pendidikan"
                                            class="form-control">
                                            <option {{ $customer->pendidikan == 'sd_mi' ? 'selected' : '' }}
                                                value="sd_mi">
                                                SD/MI</option>
                                            <option {{ $customer->pendidikan == 'smp_mts' ? 'selected' : '' }}
                                                value="smp_mts">SMP/MTs</option>
                                            <option {{ $customer->pendidikan == 'sma_smk_ma' ? 'selected' : '' }}
                                                value="sma_smk_ma">SMA/SMK/MA</option>
                                            <option {{ $customer->pendidikan == 'diploma_1' ? 'selected' : '' }}
                                                value="diploma_1">Diploma 1 (D1)</option>
                                            <option {{ $customer->pendidikan == 'diploma_2' ? 'selected' : '' }}
                                                value="diploma_2">Diploma 2 (D2)</option>
                                            <option {{ $customer->pendidikan == 'diploma_3' ? 'selected' : '' }}
                                                value="diploma_3">Diploma 3 (D3)</option>
                                            <option {{ $customer->pendidikan == 'sarjana' ? 'selected' : '' }}
                                                value="sarjana">Sarjana (S1)</option>
                                            <option {{ $customer->pendidikan == 'magister' ? 'selected' : '' }}
                                                value="magister">Magister (S2)</option>
                                            <option {{ $customer->pendidikan == 'doktor' ? 'selected' : '' }}
                                                value="doktor">
                                                Doktor (S3)</option>
                                        </select>
                                        <small class="text-danger">{{ $errors->first('pendidikan') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="position-relative mb-3">
                                        <label for="status_pernikahan">Status Pernikahan</label>
                                        <select class="js-select-2 form-control" name="status_pernikahan"
                                            id="status_pernikahan" class="form-control">
                                            <option value="">{{ $customer->status_pernikahan }}</option>
                                            <option {{ $customer->status_pernikahan == 'lajang' ? 'selected' : '' }}
                                                value="lajang">Lajang</option>
                                            <option {{ $customer->status_pernikahan == 'menikah' ? 'selected' : '' }}
                                                value="menikah">Menikah</option>
                                            <option {{ $customer->status_pernikahan == 'cerai hidup' ? 'selected' : '' }}
                                                value="cerai hidup">Cerai Hidup</option>
                                            <option {{ $customer->status_pernikahan == 'cerai mati' ? 'selected' : '' }}
                                                value="cerai mati">Cerai Mati</option>
                                        </select>
                                        <small class="text-danger">{{ $errors->first('status_pernikahan') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="no_telp">No. Telp</label>
                                        <input autocomplete="off" type="text" name="no_telp" id="no_telp"
                                            class="form-control" value="{{ $customer->hp }}">
                                        <small class="text-danger">{{ $errors->first('no_telp') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="tempat_kerja">Alamat Tempat Kerja</label>
                                        <input autocomplete="off" type="text" name="tempat_kerja" id="tempat_kerja"
                                            class="form-control" value="{{ $customer->tempat_kerja }}">
                                        <small class="text-danger">{{ $errors->first('tempat_kerja') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative mb-3">
                                        <label for="usaha">Jenis Usaha</label>
                                        <input autocomplete="off" type="text" name="jenis_usaha" id="jenis_usaha"
                                            class="form-control" value="{{ $customer->usaha }}">
                                        <small class="text-danger">{{ $errors->first('jenis_usaha') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button id="kembali" class="btn btn-light btn-icon-split kembali">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-turn-slight-left-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM6.864 8.368a.25.25 0 0 1-.451-.039l-1.06-2.882a.25.25 0 0 1 .192-.333l3.026-.523a.25.25 0 0 1 .26.371l-.667 1.154.621.373A2.5 2.5 0 0 1 10 8.632V11H9V8.632a1.5 1.5 0 0 0-.728-1.286l-.607-.364-.8 1.386Z" />
                                        </svg>
                                    </span>
                                    <span class="text">Kembali</span>
                                </button>

                                <button class="btn btn-secondary btn-icon-split" id="SimpanPenduduk"
                                    type="submit"style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Simpan Pelanggan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/customers';
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.js-select-2').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
