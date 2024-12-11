@extends('layouts.base')
@php
    $status = $settings->swit_tombol ?? null;
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Bagian Informasi Customer -->
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <!-- Gambar -->
                        <img src="../../assets/img/reg3.png" style="max-height: 150px; margin-right: 20px;" class="img-fluid">
                        <div class="w-100">
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-success btn-icon-split" style="background-color: #8eea03; "
                                    type="submit" id="SimpanPaket" class="btn btn-dark"
                                    style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-sign-intersection-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                        </svg>
                                    </span><span class="text" style="float: right;">Simpan Harga</span>
                                </button>
                            </div>
                            <hr>
                            <h4 class="alert-heading"><b>Tentukan Harga Paket</b></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form action="/installations" method="post" id="FormRegisterPermohonan">
                        @csrf
                        <div class="row">
                            <div class="card-body">
                                <div class="alert alert-light" role="alert">
                                    <div style="display: flex; justify-content: flex-end;">
                                        <a href="/villages/create" class="btn btn-primary" id="RegisterDesa"
                                            style="display: inline-block; width: 130px; height: 30px; text-align: center; line-height: 18px; font-size: 12px;">
                                            <i class="fas fa-plus"></i> Register Desa
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="position-relative mb-3">
                                                <label for="customer_id">Customer</label>
                                                <select class="select2 form-control" name="customer_id" id="customer_id">
                                                    @foreach ($customer as $anggota)
                                                        <option value="{{ $anggota->id }}">
                                                            {{ $anggota->nik }} {{ $anggota->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="order">Tanggal Order</label>
                                                <input type="text" class="form-control date" name="order"
                                                    id="order" aria-describedby="order" placeholder="order"
                                                    value="{{ date('d/m/Y') }}">
                                                <small class="text-danger" id="msg_order"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="desa">Nama/Desa</label>
                                                <select class="select2 form-control" name="desa" id="desa">
                                                    <option>Pilih Nama/Desa</option>
                                                    @foreach ($desa as $ds)
                                                        <option
                                                            {{ $pilih_desa == $ds->kode ? 'selected' : '' }}value="{{ $ds->id }}">
                                                            {{ $ds->kode }} - [{{ $ds->nama }}]
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger" id="msg_desa"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat"
                                                    aria-describedby="alamat" placeholder="Alamat">
                                                <small class="text-danger" id="msg_alamat"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="koordinate">Koordinate</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    placeholder="Masukkan Link Koordinate" aria-describedby="koordinate"
                                                    name="koordinate" id="koordinate">
                                                <div class="input-group-append">
                                                    {{-- https://www.google.com/maps/place/-7.462512371777572,%20110.1149253906747 --}}
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <a href="https://maps.google.com/" target="_blank"
                                                            style="color: white; text-decoration: none;">Google Maps</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="jenis_paket">Paket/Kelas</label>
                                                <select class="select2 form-control" name="package_id" id="jenis_paket">
                                                    <option>Pilih Paket/Kelas</option>
                                                    @foreach ($paket as $p)
                                                        <option value="{{ $p->id }}">
                                                            {{ $p->kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger" id="msg_package_id"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="formjenis_paket">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="kode_instalasi">Kode instalasi</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    aria-describedby="Kode_instalasi" name="kode_instalasi"
                                                    id="kode_instalasi"
                                                    placeholder="Kode instalasi akan terpenuhi jika desa dipilih" readonly>
                                            </div>
                                        </div>
                                        @if ($status === 1)
                                            <div class="col-md-6">
                                                <div class="position-relative mb-3">
                                                    <label for="total">Nominal</label>
                                                    <input type="text" class="form-control total"
                                                        aria-describedby="total" name="total" id="total"
                                                        value="100000" readonly>
                                                    <small class="text-danger" id="msg_package_id"></small>
                                                </div>
                                            </div>
                                        @elseif ($status === 2)
                                            <div class="col-md-6">
                                                <div class="position-relative mb-3">
                                                    <label for="total">Nominal</label>
                                                    <input type="text" class="form-control total"
                                                        aria-describedby="total" name="total" id="total">
                                                    <small class="text-danger" id="msg_package_id"></small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <p class="mb-0">
                                    Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
                                </p>
                                <button type="submit" id="SimpanPermohonan" class="btn btn-dark"
                                    style="float: right;">Simpan
                                    Permohonan</button>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#total").maskMoney({
            allowNegative: true
        });
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
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

        $(document).on('change', '#desa', function(e) {
            e.preventDefault()

            var kd_desa = $(this).val()
            $.get('/installations/kode_instalasi?kode=' + kd_desa, function(result) {
                $('#kode_instalasi').val(result.kd_instalasi)
            })
        });

        $(document).on('change', '#jenis_paket', function() {
            var jenis_paket = $(this).val()

            $.get('/installations/jenis_paket/' + jenis_paket, function(result) {
                $('#formjenis_paket').html(result.view)
            })
        })

        style = "background-color: #7365f0; color: #fff; border-color: #6f42c1;" > Close
        $(document).on('click', '#SimpanPermohonan', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormRegisterPermohonan');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Permohonan Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/installations/' + result.installation
                                    .id;
                            }
                        });
                    }
                },
                error: function(result) {
                    const response = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');

                    if (response && typeof response === 'object') {
                        $.each(response, function(key, message) {
                            $('#' + key)
                                .closest('.input-group.input-group-static')
                                .addClass('is-invalid');

                            $('#msg_' + key).html(message);
                        });
                    }
                }
            });
        });
    </script>
@endsection
