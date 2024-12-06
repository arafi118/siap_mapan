@extends('layouts.base')
@section('content')
    <!-- Container Fluid-->
    <!-- Container Fluid-->
    <div class="container-fluid">
        <div class="row">
            <!-- Alerts Basic -->
            <div class="col-lg-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Pengaturan !</h6>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills">
                            <li class="nav-item" style="margin-bottom: 10px;">
                                <a class="nav-link btn btn-white active" data-status="P" data-toggle="tab"
                                    style="width: 220px;" data-target="#wellcome" href="#">
                                    <div class="left-align" style="display: flex; align-items: center; gap: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20"
                                            height="25" style="fill: rgb(255, 255, 255);">
                                            <path
                                                d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                        </svg>
                                        <span><b>Wellcome</b></span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" style="margin-bottom: 10px;">
                                <a class="nav-link btn btn-white" data-status="S" data-toggle="tab" style="width: 220px;"
                                    data-target="#instalasi" href="#">
                                    <div class="left-align" style="display: flex; align-items: center; gap: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20"
                                            height="25" style="fill: rgb(255, 255, 255);">
                                            <path
                                                d="M94.1 315.1c0 25.9-21.2 47.1-47.1 47.1S0 341 0 315.1c0-25.9 21.2-47.1 47.1-47.1h47.1v47.1zm23.7 0c0-25.9 21.2-47.1 47.1-47.1s47.1 21.2 47.1 47.1v117.8c0 25.9-21.2 47.1-47.1 47.1s-47.1-21.2-47.1-47.1V315.1zm47.1-189c-25.9 0-47.1-21.2-47.1-47.1S139 32 164.9 32s47.1 21.2 47.1 47.1v47.1H164.9zm0 23.7c25.9 0 47.1 21.2 47.1 47.1s-21.2 47.1-47.1 47.1H47.1C21.2 244 0 222.8 0 196.9s21.2-47.1 47.1-47.1H164.9zm189 47.1c0-25.9 21.2-47.1 47.1-47.1 25.9 0 47.1 21.2 47.1 47.1s-21.2 47.1-47.1 47.1h-47.1V196.9zm-23.7 0c0 25.9-21.2 47.1-47.1 47.1-25.9 0-47.1-21.2-47.1-47.1V79.1c0-25.9 21.2-47.1 47.1-47.1 25.9 0 47.1 21.2 47.1 47.1V196.9zM283.1 385.9c25.9 0 47.1 21.2 47.1 47.1 0 25.9-21.2 47.1-47.1 47.1-25.9 0-47.1-21.2-47.1-47.1v-47.1h47.1zm0-23.7c-25.9 0-47.1-21.2-47.1-47.1 0-25.9 21.2-47.1 47.1-47.1h117.8c25.9 0 47.1 21.2 47.1 47.1 0 25.9-21.2 47.1-47.1 47.1H283.1z" />
                                        </svg>
                                        <span><b>Sistem Instalasi</b></span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-white" data-status="A" data-toggle="tab" style="width: 220px;"
                                    data-target="#block" href="#">
                                    <div class="left-align" style="display: flex; align-items: center; gap: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20"
                                            height="25" style="fill: rgb(255, 255, 255);">
                                            <path
                                                d="M290.7 311L95 269.7 86.8 309l195.7 41zm51-87L188.2 95.7l-25.5 30.8 153.5 128.3zm-31.2 39.7L129.2 179l-16.7 36.5L293.7 300zM262 32l-32 24 119.3 160.3 32-24zm20.5 328h-200v39.7h200zm39.7 80H42.7V320h-40v160h359.5V320h-40z" />
                                        </svg>
                                        <span><b>Block Paket</b></span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div id="tabsContent" class="tab-content">
                    <!-- wellcome Tab -->
                    <div id="wellcome" role="tab" class="tab-pane active">
                        <!-- Content for wellcome -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="table-responsive p-3">
                                        @include('sop.partials.profil')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- instalasi Tab -->
                    <div id="instalasi" role="tab" class="tab-pane ">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="table-responsive p-3">
                                        @include('sop.partials.sistem_instalasi')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- block Tab -->
                    <div id="block" role="tab" class="tab-pane ">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="table-responsive p-3">
                                        @include('sop.partials.block_paket')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->

    </div>
@endsection
