@extends('layouts.base')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <form action="">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Bagian Informasi Customer -->
                            <div class="alert alert-info d-flex align-items-center m-0 text-white" role="alert"
                                style="border-radius: 10;">
                                <!-- Gambar -->
                                <img src="../../assets/img/pls.png"
                                    style="max-height: 150px; margin-right: 20px; margin-left: 15px;" class="img-fluid">

                                <!-- Konten Teks -->
                                <div class="flex-grow-1">
                                    <h4 class="alert-heading text-white"><b>Customer an. </b></h4>
                                    <hr class="my-2 bg-white">
                                    <div class="mt-3">
                                        <table class="table table-bordered table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th colspan="4" class="text-black">Detail Instalasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;"
                                                        class="text-white">
                                                        Tgl Order
                                                    </td>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;"
                                                        class="text-white">
                                                        Abodemen
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;"
                                                        class="text-white">
                                                        Tgl Order
                                                    </td>
                                                    <td style="width: 50%; font-size: 14px; padding: 8px;"
                                                        class="text-white">
                                                        Abodemen
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabel di Bawah Customer -->
                            <br>
                            <div class="alert alert-light" role="alert">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="kode_instalasi"></label>
                                            <input type="text" class="form-control date" name="kode_instalasi"
                                                id="kode_instalasi">
                                            <small class="text-danger" id="msg_kode_instalasi"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="order">Tanggal Pasang</label>
                                            <input type="text" class="form-control date" name="order" id="order"
                                                value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_order"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="order">Biaya Istalasi</label>
                                            <input type="text" class="form-control" name="order" id="order">
                                            <small class="text-danger" id="msg_order"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPermohonan"
                                    style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span>
                                    <span class="text" style="float: right;">Simpan Pembayaran</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div id="tabsContent" class="tab-content">
            <!-- Permohonan Tab -->
            <div role="tab" class="tab-pane active show">
                <!-- Content for Permohonan -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover" id="TbPermohonan">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>kode instalasi</th>
                                            <th>Customer</th>
                                            <th>Paket</th>
                                            <th>Tanggal Order</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($status_0 as $status_0)
                                            <tr>
                                                <td>{{ $status_0->kode_instalasi }}</td>
                                                <td>{{ $status_0->customer ? $status_0->customer->nama : '' }}</td>
                                                <td>{{ $status_0->package ? $status_0->package->kelas : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($status_0->order)->format('d-m-Y') }}</td>
                                                <td>
                                                    @if ($status_0->status === '0')
                                                        <a href="/installations/{{ $status_0->id }}/edit"
                                                            class="btn-sm btn-warning"><i
                                                                class="fa fa-exclamation-circle">&nbsp;Pengajuan</i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#TbPermohonan').DataTable();
        });
    </script>
@endsection
