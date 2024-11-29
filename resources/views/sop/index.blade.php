@extends('layouts.base')

@section('content')
<style>
    .btn-white-custom {
        display: flex;
        align-items: center;
        background-color: rgb(253, 12, 12);
        color: black;
        border-color: #ffffff;
        /* Menjaga warna border asli */
    }

    .btn-white-custom:hover,
    .btn-white-custom:focus,
    .btn-white-custom.active {
        background-color: #202b3c;
        /* Warna asli saat aktif atau hover */
        color: rgb(255, 250, 250);
    }

    .left-align {
        display: flex;
        align-items: center;
    }

    .left-align span {
        font-size: 14px;
        /* Adjust the text size as needed */
    }

</style>

<div class="app-main__inner">

    <div class="tab-content">
        <div class="tab-pane  fade show active" id="" role="tabpanel">
            <div class="row">
                <div class="col-md-4">
                    <div class="main-card mb-3 card">
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                            <h5 class="card-title">&nbsp;&nbsp;&nbsp;Pengaturan !</h5>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white  active" style="width: 280px;" id="wellcome"
                                    data-bs-toggle="tab" href="#tab-content-0">
                                    <div class="left-align">
                                        <i class="fa-solid fa-home"></i>&nbsp;&nbsp;<span>Wellcome</span>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white " style="width: 280px;" id="lembaga"
                                    data-bs-toggle="tab" href="#tab-content-1">
                                    <div class="left-align">
                                        <i class="fa-solid fa-tree-city"></i>&nbsp;&nbsp;<span>Identitas Lembaga</span>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white " style="width: 280px;" id="pengelola"
                                    data-bs-toggle="tab" href="#tab-content-2">
                                    <div class="left-align">
                                        <i class="fa-solid fa-person-chalkboard"></i>&nbsp;&nbsp;<span>Sebutan
                                            Pengelola</span>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white " style="width: 280px;" id="peminjam"
                                    data-bs-toggle="tab" href="#tab-content-3">
                                    <div class="left-align">
                                        <i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;<span>Sistem Pinjaman</span>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white " style="width: 280px;" id="asuransi"
                                    data-bs-toggle="tab" href="#tab-content-4">
                                    <div class="left-align">
                                        <i class="fa-solid fa-money-bill-transfer"></i>&nbsp;&nbsp;<span> Pengaturan
                                            Asuransi</span>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white" style="width: 280px;" data-bs-toggle="tab"
                                    href="#tab-content-5">
                                    <div class="left-align">
                                        <i class="fa-solid fa-laptop-file"></i>&nbsp;&nbsp;<span>Redaksi SPK</span>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white" style="width: 280px;" data-bs-toggle="tab"
                                    href="#tab-content-6">
                                    <div class="left-align">
                                        <i class="fa-solid fa-panorama"></i>&nbsp;&nbsp;<span>Logo</span>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-3">&nbsp;
                                <a role="tab" class="btn btn-white" style="width: 280px;" data-bs-toggle="tab"
                                    href="#tab-content-7">
                                    <div class="left-align">
                                        <i class="fa-solid fa-camera-rotate"></i>&nbsp;&nbsp;<span>Whatsapp</span>
                                    </div>
                                </a>
                            </div>
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-md-8">
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Wellcome !!</h5>
                                        @include('sop.partials._wellcome')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Identitas Lembaga</h5>
                                        @include('sop.partials._lembaga')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sebutan Pengelola Lembaga</h5>
                                        <div class="position-relative mb-3">
                                            @include('sop.partials._pengelola')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sistem Peminjam</h5>
                                        @include('sop.partials._pinjaman')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-4" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Pengaturan Asuransi</h5>
                                        @include('sop.partials._asuransi')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Redaksi Dokumen SPK</h5>
                                        @include('sop.partials._spk')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-6" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Upload LOGO</h5>
                                        @include('sop.partials._logo')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-7" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Pengaturan Whatsapp</h5>
                                        @include('sop.partials._whatsapp')
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</div>
@endsection