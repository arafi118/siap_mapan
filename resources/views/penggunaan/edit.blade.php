@extends('layouts.base')

@section('content')
<form action="/usages/{{ $usage->id }}" method="post" id="PutPemakaian">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-tint" style="font-size: 28px; margin-right: 8px;"></i>
                                    <b>Edit Pemakaian</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="customer_id" customer_id="kode" value="{{ $usage->customers->nama }}"> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="customer">Nama</label>
                                    <input autocomplete="off" readonly type="text" name="customer" id="customer"
                                        class="form-control" value="{{$usage->customers->nama}}">
                                    <small class="text-danger" id="msg_customer">{{ $errors->first('customer') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="kode_instalasi">Kode Instalasi</label>
                                    <input autocomplete="off" readonly type="text" name="kode_instalasi" id="kode_instalasi" class="form-control"
                                        value="{{ $usage->kode_instalasi }}">
                                    <small class="text-danger" id="msg_kode_instalasi">{{ $errors->first('kode_instalasi') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="awal">Awal</label>
                                    <input autocomplete="off" readonly type="text" name="awal" id="awal" class="form-control"
                                        value="{{ $usage->awal }}">
                                    <small class="text-danger">{{ $errors->first('awal') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="akhir">Akhir</label>
                                    <input autocomplete="off" readonly type="text" name="akhir" id="akhir" class="form-control"
                                        value="{{ $usage->akhir }}">
                                    <small class="text-danger">{{ $errors->first('akhir') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="jumlah">Jumlah</label>
                                    <input autocomplete="off" readonly type="text" name="jumlah" id="jumlah" class="form-control"
                                        value="{{ $usage->jumlah }}">
                                    <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="tgl_akhir">Tgl Akhir</label>
                                    <input type="text" class="form-control date" name="tgl_akhir"
                                           id="tgl_akhir" aria-describedby="tgl_akhir" placeholder="Tgl Akhir"
                                           value="{{ \Carbon\Carbon::parse($usage->tgl_akhir)->format('d/m/Y') }}">
                                    <small class="text-danger" id="msg_tgl_akhir"></small>
                                </div>
                                
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="close">Close</button>
                        <button type="submit" class="btn btn-dark btn-sm float-end" id="SimpanPemakaian">Simpan Desa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    document.getElementById("close").addEventListener("click", function () {
        window.location.href = "/usages"; // Ganti "/usage" dengan URL yang sesuai
    });
    jQuery.datetimepicker.setLocale('de');
        $('.date').datetimepicker({
            i18n: {
                de: {
                    months: [
                        'Januar', 'Februar', 'März', 'April',
                        'Mai', 'Juni', 'Juli', 'August',
                        'September', 'Oktober', 'November', 'Dezember',
                    ],
                    dayOfWeek: [
                        "So.", "Mo", "Di", "Mi",
                        "Do", "Fr", "Sa.",
                    ]
                }
            },
            timepicker: false,
            format: 'd/m/Y'
        });
        
</script>
@endsection