@extends('layouts.base')

@section('content')
<div class="tab-content" style="font-size: 14px;">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form class="">
                    <div class="row">
                        <div class="position-relative mb-3">
                            <select class="select2-single form-control" name="state" id="select2Single"
                                style="width: 650px; height: 35px; background-color: #fbfdff; color: #4e4b56;">
                                <option value="">Select</option>
                                <option value="Aceh">Aceh</option>
                                <option value="Sumatra Utara">Sumatra Utara</option>
                            </select>
                            <small class="text-danger" id="msg_individu"></small>
                        </div>
                        
                        <div class="col-md-4 position-relative mb-3 resizeable">
                            <div class="d-grid w-100 mb-2">
                                <a href="" class="btn btn-sm"
                                    style="width: 300px; height: 35px; background-color: #6c81f8; color: white;">Reg. Calon Pelanggan</a>
                                </a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form class="">
                    <div class="row">
                        <div class="card-body">
                            <div class="app-title">
                                <div class="app-wrapper">
                                    <div class="app-heading">
                                        <div class="app-bg-icon fa-solid fa-file-circle-plus" style="font-size: 48px;">
                                            <i class="fas fa-folder-plus"></i>
                                        </div>

                                        <div class="app-text_fount" style="color: rgb(101, 101, 101);">
                                            <h5><b>Register</b></h5>
                                            <div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="/perguliran_i" method="post" id="FormRegisterProposal"
                                class="small-font-form">
                                @csrf

                                <input type="hidden" name="nia" id="nia" value="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="position-relative mb-3">
                                            <label for="tgl_proposal" class="form-label">Tgl proposal</label>
                                            <input autocomplete="off" type="text" name="tgl_proposal" id="tgl_proposal"
                                                class="form-control date" value="">
                                            <small class="text-danger" id="msg_tgl_proposal"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="position-relative mb-3">
                                            <label for="pengajuan" class="form-label">Pengajuan Rp.</label>
                                            <input autocomplete="off" type="text" name="pengajuan" id="pengajuan"
                                                class="form-control">
                                            <small class="text-danger" id="msg_pengajuan"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="position-relative mb-3">
                                            <label for="jangka" class="form-label">Jangka</label>
                                            <input autocomplete="off" type="number" name="jangka" id="jangka"
                                                class="form-control" value="">
                                            <small class="text-danger" id="msg_jangka"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="position-relative mb-3">
                                            <label for="pros_jasa" class="form-label">Prosentase Jasa (%)</label>
                                            <input autocomplete="off" type="number" name="pros_jasa" id="pros_jasa"
                                                class="form-control" value="">
                                            <small class="text-danger" id="msg_pros_jasa"></small>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="jenis_jasa" class="form-label">Jenis Jasa</label>
                                            <select class="js-example-basic-single form-control" name="jenis_jasa"
                                                id="jenis_jasa" style="width: 100%;    ">

                                            </select>
                                            <small class="text-danger" id="msg_jenis_jasa"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="jenis_produk_pinjaman" class="form-label">Jenis Produk
                                                Pinjaman</label>
                                            <select class="js-example-basic-single form-control "
                                                name="jenis_produk_pinjaman" id="jenis_produk_pinjaman"
                                                style="width: 100%;">

                                            </select>
                                            <small class="text-danger" id="msg_jenis_produk_pinjaman"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="id_agent" class="form-label">Nama Agen</label>
                                            <select class="js-example-basic-single form-control" name="id_agent"
                                                id="id_agent" style="width: 100%;">


                                            </select>
                                            <small class="text-danger" id="msg_id_agent"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative mb-3">
                                            <label for="nama_barang" class="form-label">Nama Barang</label>
                                            <input autocomplete="off" type="text" name="nama_barang" id="nama_barang"
                                                class="form-control">
                                            <small class="text-danger" id="msg_nama_barang"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="sistem_angsuran_pokok" class="form-label">Sistem Angs.
                                                Pokok</label>
                                            <select class="js-example-basic-single form-control"
                                                name="sistem_angsuran_pokok" id="sistem_angsuran_pokok"
                                                style="width: 100%;">

                                            </select>
                                            <small class="text-danger" id="msg_sistem_angsuran_pokok"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="sistem_angsuran_jasa" class="form-label">Sistem Angs.
                                                Jasa</label>
                                            <select class="js-example-basic-single form-control"
                                                name="sistem_angsuran_jasa" id="sistem_angsuran_jasa"
                                                style="width: 100%;">

                                            </select>
                                            <small class="text-danger" id="msg_sistem_angsuran_jasa"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="jaminan" class="form-label">Jaminan</label>
                                            <select class="js-example-basic-single form-control" name="jaminan"
                                                id="jaminan" style="width: 100%;">

                                            </select>
                                            <small class="text-danger" id="msg_jaminan"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="formJaminan"></div>

                            </form>
                            <!-- Documentation Link -->

                            <!-- Modal Logout -->
                            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
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
                                            <button type="button" class="btn btn-outline-primary"
                                                data-dismiss="modal">Cancel</button>
                                            <a href="login.html" class="btn btn-primary">Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
