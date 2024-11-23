@extends('layouts.base')

@section('content')

<!-- Row -->
<!-- Row -->

<div class="row">
    <!-- Datatables -->
    <div class="app-main__inner">
        <div class="tab-content">
            <br>
            <div class="row">

                <div class="col-md-9">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        <form action="/transaksi" method="post" id="FormTransaksi">
                        @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="tgl_transaksi">Tgl Transaksi</label>
                                            <input autocomplete="off" type="text" name="tgl_transaksi" id="tgl_transaksi"
                                                class="form-control date" value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_tgl_transaksi"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="jenis_transaksi">Jenis Transaksi</label>
                                            <select class="js-example-basic-single form-control" name="jenis_transaksi" id="jenis_transaksi">
                                                <option value="">-- Pilih Jenis Transaksi --</option>
                                               
                                            </select>
                                            <small class="text-danger" id="msg_jenis_transaksi"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="kd_rekening">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="sumber_dana">Sumber Dana</label>
                                            <select class="js-example-basic-single form-control" name="sumber_dana" id="sumber_dana">
                                                <option value="">-- Sumber Dana --</option>
                                            </select>
                                            <small class="text-danger" id="msg_sumber_dana"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="disimpan_ke">Disimpan Ke</label>
                                            <select class="js-example-basic-single form-control" name="disimpan_ke" id="disimpan_ke">
                                                <option value="">-- Disimpan Ke --</option>
                                            </select>
                                            <small class="text-danger" id="msg_disimpan_ke"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="form_nominal">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="keterangan">Keterangan</label>
                                            <input autocomplete="off" type="text" name="keterangan" id="keterangan"
                                            class="form-control">
                                            <small class="text-danger" id="msg_keterangan"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                             <label for="nominal">Nominal Rp.</label>
                                             <input autocomplete="off" type="text" name="nominal" id="nominal"class="form-control">
                                             <small class="text-danger" id="msg_nominal"></small>
                                        </div>
                                    </div>
                                </div><br>
                                <div style="text-align: right;">
                                    <button type="button" id="SimpanTransaksi"  class="mt-2 btn btn-focus btn--text">SIMPAN TRANSAKSI</button>
                                </div><br>
                            </form>
                        </div>
                    </div>
                </div>
</div>
<!--Row-->

<!-- Documentation Link -->

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <a href="login.html" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div>
@endsection
