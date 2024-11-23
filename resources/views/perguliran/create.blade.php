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
                                style="width: 643px; height: 35px; background-color: #fbfdff; color: #4e4b56;">
                                @foreach ( $customer as $anggota )
                                <option value="{{ $anggota->id }}">
                                    {{ $anggota->nik }} {{ $anggota->nama }} [{{ $anggota->village->nama }}]
                                </option>
                                @endforeach
                            </select>
                            <small class="text-danger" id="msg_individu"></small>
                        </div>

                        <div class="col-md-4 position-relative mb-3 resizeable">
                            <div class="d-grid w-100 mb-2">
                                <a href="/customers/create" class="btn btn-sm"
                                    style="width: 300px; height: 35px; background-color: #6c81f8; color: white;">Reg.
                                    Calon Pelanggan</a>
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
                            <form action="/installations" method="post" id="FormRegisterProposal"
                                class="small-font-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="desa">Nama/Desa</label>
                                            <select class="js-select-2 form-control" name="desa" id="desa">
                                                <option>Pilih Nama/Desa</option>
                                                @foreach ( $customer as $anggota )
                                                <option value="{{ $anggota->id }}">
                                                 {{ $anggota->nama }} [{{ $anggota->village->nama }}]
                                                </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_desa"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="lokasi">Alamat</label>
                                            <select class="js-select-2 form-control" name="lokasi" id="lokasi">
                                                <option>Pilih Alamat</option>
                                                 @foreach ($installations as $ins)
                                                <option value="{{ $ins->id }}">
                                                    {{ $ins->alamat }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_lokasi"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="status">Kelas</label>
                                            <select class="js-select-2 form-control" name="status" id="status">
                                                <option>Pilih Kelas</option>
                                                 @foreach ($paket as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->kelas }}
                                                </option> 
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_status"></small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12">
                                <div class="font-icon-wrapper">
                                    <p><p><b>Catatan : </b> ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )</p></p>
                                </div>
                            </div>
                            <button type="submit" id="SimpanProposal" class="btn btn-dark btn-sm custom-green">Simpan Proposal</button>
                            <br><br><br>
                            
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
