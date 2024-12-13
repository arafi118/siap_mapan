@extends('layouts.base')

@section('content')
    <div class="tab-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <!-- Gambar -->
                            <img src="../../assets/img/user_edit.png" style="max-height: 90px; margin-right: 10px;"
                                class="img-fluid">
                            <!-- Konten Teks -->
                            <div>
                                <h5 class="alert-heading"><b>Edit Customer an.
                                        {{ $installations->customer->nama }}</b></h5>
                                <hr>
                                <p class="mb-0">
                                    {{ $installations->village->nama }},
                                    {{ $installations->alamat }}, [
                                    {{ $installations->kode_instalasi }}
                                    ].
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">

                <div class="card-body">
                    <form action="/installations/{{ $installations->id }}" method="post" id="FormEditPermohonan">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="card-body">
                                <div class="alert alert-light" role="alert">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="order">Tanggal Order</label>
                                                <input type="text" class="form-control date" name="order"
                                                    id="order" aria-describedby="order" placeholder="order"
                                                    value="{{ $installations->order ? \Carbon\Carbon::parse($installations->order)->format('d/m/Y') : date('d/m/Y') }}">
                                                <small class="text-danger" id="msg_order"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="total">Nominal</label>
                                                <input type="text" class="form-control total" aria-describedby="total"
                                                    name="total" id="total" value="{{ number_format($trx, 2) }}"
                                                    readonly>
                                                <small class="text-danger" id="msg_package_id"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat"
                                                    aria-describedby="alamat" placeholder="Alamat"
                                                    value="{{ $installations->alamat }}">
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
                                                    name="koordinate" id="koordinate"
                                                    value="{{ $installations->koordinate }}">
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
                                                <select class="select2 form-control" name="package_id"
                                                    id="edit_jenis_paket">
                                                    <option>Pilih Paket/Kelas</option>
                                                    @foreach ($paket as $p)
                                                        <option {{ $p->id == $installations->package_id ? 'selected' : '' }}
                                                            value="{{ $p->id }}">
                                                            {{ $p->kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger" id="msg"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="formEditjenis_paket">
                                    </div>
                                </div>
                                <button type="submit" id="EditPermohonan" class="btn btn-dark btn-icon-split"
                                    style="float: right; margin-left: 10px;">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </span>
                                    <span class="text">Edit Perubahan</span>
                                </button>
                                <a href="/installations?status=P" class="btn btn-primary btn-icon-split"
                                    style="float: right;">
                                    <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1" />
                                        </svg>
                                    </span>
                                    <span class="text">Kembali</span>
                                </a>
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

        $(document).on('change', '#edit_jenis_paket', function() {
            var edit_jenis_paket = $(this).val()

            $.get('/installations/edit_jenis_paket/' + edit_jenis_paket, function(result) {
                $('#formEditjenis_paket').html(result.view)
            })
        })

        $(document).on('click', '#EditPermohonan', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormEditPermohonan');
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
                                window.location.href = '/installations/' + result.Editpermohonan
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
