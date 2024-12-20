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
                                    <input autocomplete="off" maxlength="16" type="text" name="nik" id="nik"
                                        class="form-control" value="{{ $customer->nik }}">
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
                                        <option {{ $customer->jk == 'L' ? 'selected' : '' }} value="L">Laki-Laki</option>
                                        <option {{ $customer->jk == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="no_kk">No. KK</label>
                                    <input autocomplete="off" type="text" name="no_kk" id="no_kk" class="form-control"
                                        value="{{ $customer->kk }}">
                                    <small class="text-danger">{{ $errors->first('no_kk') }}</small>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="alamat">Alamat KTP</label>
                                    <input autocomplete="off" maxlength="16" type="text" name="alamat" id="alamat"
                                        class="form-control" value="{{ $customer->alamat}}">
                                    <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="domisi">Domisi saat ini</label>
                                    <input autocomplete="off" type="text" name="domisi" id="domisi" class="form-control"
                                        value="{{ $customer->domisi}}">
                                    <small class="text-danger">{{ $errors->first('domisi') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="desa">Desa/Kelurahan</label>
                                    <select class="js-select-2 form-control" name="desa" id="desa">
                                        <option value="">Pilih Desa/Kelurahan</option>
                                        @foreach ($desa as $ds)
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
                                        <option {{ $customer->agama == 'islam' ? 'selected':''  }} value="islam">Islam
                                        </option>
                                        <option {{ $customer->agama == 'kristen_protestan' ? 'selected':'' }}
                                            value="kristen_protestan">Kristen Protestan</option>
                                        <option {{ $customer->agama == 'kristen_katolik' ? 'selected':'' }}
                                            value="kristen_katolik">Kristen Katolik</option>
                                        <option {{ $customer->agama == 'hindu' ? 'selected':'' }} value="hindu">Hindu
                                        </option>
                                        <option {{ $customer->agama == 'buddha' ? 'selected':'' }} value="buddha">Buddha
                                        </option>
                                        <option {{ $customer->agama == 'konghucu' ? 'selected':'' }} value="konghucu">
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
                                        <option {{ $customer->pendidikan == 'sd_mi' ? 'selected':'' }} value="sd_mi">
                                            SD/MI</option>
                                        <option {{ $customer->pendidikan == 'smp_mts' ? 'selected':'' }}
                                            value="smp_mts">SMP/MTs</option>
                                        <option {{ $customer->pendidikan == 'sma_smk_ma' ? 'selected':'' }}
                                            value="sma_smk_ma">SMA/SMK/MA</option>
                                        <option {{ $customer->pendidikan == 'diploma_1' ? 'selected':'' }}
                                            value="diploma_1">Diploma 1 (D1)</option>
                                        <option {{ $customer->pendidikan == 'diploma_2' ? 'selected':'' }}
                                            value="diploma_2">Diploma 2 (D2)</option>
                                        <option {{ $customer->pendidikan == 'diploma_3' ? 'selected':'' }}
                                            value="diploma_3">Diploma 3 (D3)</option>
                                        <option {{ $customer->pendidikan == 'sarjana' ? 'selected':'' }}
                                            value="sarjana">Sarjana (S1)</option>
                                        <option {{ $customer->pendidikan == 'magister' ? 'selected':'' }}
                                            value="magister">Magister (S2)</option>
                                        <option {{ $customer->pendidikan == 'doktor' ? 'selected':'' }} value="doktor">
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
                                        <option value="">{{ $customer->status_pernikahan}}</option>
                                        <option {{ $customer->status_pernikahan == 'lajang' ? 'selected':'' }}
                                            value="lajang">Lajang</option>
                                        <option {{ $customer->status_pernikahan == 'menikah' ? 'selected':'' }}
                                            value="menikah">Menikah</option>
                                        <option {{ $customer->status_pernikahan == 'cerai hidup' ? 'selected':'' }}
                                            value="cerai hidup">Cerai Hidup</option>
                                        <option {{ $customer->status_pernikahan == 'cerai mati' ? 'selected':'' }}
                                            value="cerai mati">Cerai Mati</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('status_pernikahan') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="no_telp">No. Telp</label>
                                    <input autocomplete="off" type="text" name="no_telp" id="no_telp"
                                        class="form-control" value="{{ $customer->hp}}">
                                    <small class="text-danger">{{ $errors->first('no_telp') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="nama_ibu">Nama Ibu Kandung</label>
                                    <input autocomplete="off" type="text" name="nama_ibu" id="nama_ibu"
                                        class="form-control" value="{{ $customer->nama_ibu}}">
                                    <small class="text-danger">{{ $errors->first('nama_ibu') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="tempat_kerja">Alamat Tempat Kerja</label>
                                    <input autocomplete="off" type="text" name="tempat_kerja" id="tempat_kerja"
                                        class="form-control" value="{{ $customer->tempat_kerja}}">
                                    <small class="text-danger">{{ $errors->first('tempat_kerja') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="usaha">Jenis Usaha</label>
                                    <input autocomplete="off" type="text" name="jenis_usaha" id="jenis_usaha"
                                        class="form-control" value="{{ $customer->usaha}}">
                                    <small class="text-danger">{{ $errors->first('jenis_usaha') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="nik_penjamin">NIK Penjamin</label>
                                    <input autocomplete="off" type="text" name="nik_penjamin" id="nik_penjamin"
                                        class="form-control" value="{{ $customer->nik_penjamin}}" maxlength="16"
                                        minlength="16">
                                    <small class="text-danger">{{ $errors->first('nik_penjamin') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="penjamin">Penjamin</label>
                                    <input autocomplete="off" type="text" name="penjamin" id="penjamin"
                                        class="form-control" value="{{ $customer->penjamin}}">
                                    <small class="text-danger">{{ $errors->first('penjamin') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="hubungan">Hubungan</label>
                                    <select class="js-select-2 form-control" name="hubungan" id="hubungan">
                                        @foreach ($hubungan as $hb)
                                            <option value="{{ $hb->id }}" 
                                                {{ $customer->hubungan == $hb->id ? 'selected' : '' }}>
                                                {{ $hb->kekeluargaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('hubungan') }}</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark btn-sm float-end" id="SimpanPenduduk">Simpan
                            Penduduk</button>
                        {{-- <button type="button" class="btn btn-danger btn-sm me-3 float-end" id="BlokirPenduduk">
                            @if ($status == '0')
                            Blokir Penduduk
                            @else
                            Lepaskan Blokiran
                            @endif
                        </button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
