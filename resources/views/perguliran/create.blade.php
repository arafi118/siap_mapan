@extends('layouts.base')
@php
    $status = $settings->swit_tombol ?? null;
    $hanyaDusun = $desa->contains('kategori', 1);
@endphp

@section('content')
    <form action="/installations" method="post" id="FormRegisterPermohonan">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <!-- Gambar -->
                            <img src="../../assets/img/reg3.png" style="max-height: 150px; margin-right: 20px;"
                                class="img-fluid d-none d-lg-block">
                            <div class="w-100">
                                <h3 class="alert-heading"><b>Register Instalasi</b></h3>
                                <p class="text-justify">
                                    "Lengkapi data dan klik tombol *<b>DAFTAR & SIMPAN</b>* untuk menyelesaikan
                                    pendaftaran."
                                </p>

                                <hr>
                                <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <div class="position-relative">
                                            <select class="select2 form-control" name="customer_id" id="customer_id">
                                                @foreach ($customer as $anggota)
                                                    <option value="{{ $anggota->id }}">
                                                        {{ $anggota->nik }} {{ $anggota->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <a href="/customers/create" class="btn btn-success" id="RegisterDesa"
                                            style="background-color: #81d700;">
                                            <span class="text">Reg. Pelanggan Baru</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body" id="container">
                        <div class="row">
                            <div class="card-body">
                                <div class="alert alert-light" role="alert">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="position-relative mb-3">
                                                <label for="order">Tanggal Order</label>
                                                <input type="text" class="form-control date" name="order"
                                                    id="order" aria-describedby="order" placeholder="order"
                                                    value="{{ date('d/m/Y') }}">
                                                <small class="text-danger" id="msg_order"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="desa">Nama/Desa & Dusun</label>
                                                <select class="select2 form-control" name="desa" id="desa">
                                                    <option>Pilih Nama/Desa & Dusun</option>
                                                    @foreach ($desa as $ds)
                                                        @if (!$hanyaDusun || $ds->kategori == 1)
                                                            <option {{ $pilih_desa == $ds->kode ? 'selected' : '' }}
                                                                value="{{ $ds->id }}">
                                                                {{ $ds->kode }} -
                                                                [{{ $hanyaDusun ? $ds->dusun : $ds->nama }}]
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <small class="text-danger" id="msg_desa"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="position-relative mb-3">
                                                <label for="cater">Nama Cater</label>
                                                <select class="select2 form-control" name="cater" id="cater">
                                                    <option>Pilih Cater</option>
                                                    @foreach ($caters as $ct)
                                                        <option value="{{ $ct->id }}">
                                                            {{ $ct->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger" id="msg_cater"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="jalan">Jalan</label>
                                                <input type="text" class="form-control" id="jalan" name="jalan"
                                                    aria-describedby="jalan" placeholder="Jalan">
                                                <small class="text-danger" id="msg_jalan"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="position-relative mb-3">
                                                <label for="rw">RW</label>
                                                <input type="number" class="form-control" id="rw" name="rw"
                                                    aria-describedby="rw" placeholder="Rw">
                                                <small class="text-danger" id="msg_rw"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="position-relative mb-3">
                                                <label for="rt">RT</label>
                                                <input type="number" class="form-control" id="rt" name="rt"
                                                    aria-describedby="rt" placeholder="Rt">
                                                <small class="text-danger" id="msg_rt"></small>
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
                                                <select class="select2 form-control package" name="package_id"
                                                    id="jenis_paket">
                                                    <option>Pilih Paket/Kelas</option>
                                                    @foreach ($paket as $p)
                                                        <option value="{{ $p->id }}">
                                                            {{ $p->kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger" id="msg"></small>
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
                                                        value="{{ number_format($settings->pasang_baru, 2) }}" readonly>
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
                                    style="float: right;">Daftar & Simpan</button>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $("#abodemen").maskMoney({
            allowNegative: true
        });

        $(".total").maskMoney({
            allowNegative: true
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });

        $(document).on('change', '#total', function() {
            function cleanNumber(value) {
                let cleanNumber = value.toString().replace(/,/g, '');
                return parseFloat(cleanNumber) || 0;
            }

            var pasang = cleanNumber($('#pasang_baru').val());
            var total = cleanNumber($(this).val());

            if (total > pasang) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Total Tidak Boleh Lebih Dari Pasang Baru!"
                });
            }
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

        $(document).on('change', '#desa, #rt', function(e) {
            e.preventDefault();

            var kd_desa = $('#desa').val();
            var rt = $('#rt').val();

            $.get('/installations/kode_instalasi', {
                kode_desa: kd_desa,
                kode_rt: rt,
            }, function(result) {
                $('#kode_instalasi').val(result.kd_instalasi);
            });
        });

        $(document).on('change', '#jenis_paket', function() {
            var jenis_paket = $(this).val()

            $.get('/installations/jenis_paket/' + jenis_paket, function(result) {
                $('#formjenis_paket').html(result.view)
            })
        })

        //simpan
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
                            text: "Tambahkan Register Instalasi Baru?",
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

        //notifikasi
        $(document).on('change', '#customer_id', function() {
            $.ajax({
                url: '/installations/reg_notifikasi/' + $(this).val(),
                type: 'GET',
                success: function(result) {
                    $('#container').html(result)
                }
            })
        })
    </script>
@endsection
