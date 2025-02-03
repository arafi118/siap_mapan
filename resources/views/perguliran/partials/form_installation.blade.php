@php
    $status = $settings->swit_tombol ?? null;
@endphp

<div class="row">
    <div class="card-body">
        <div class="alert alert-light" role="alert">
            <div class="row">
                <div class="col-md-3">
                    <div class="position-relative mb-3">
                        <label for="order">Tanggal Order</label>
                        <input type="text" class="form-control date" name="order" id="order"
                            aria-describedby="order" placeholder="order" value="{{ date('d/m/Y') }}">
                        <small class="text-danger" id="msg_order"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative mb-3">
                        <label for="desa">Nama/Desa</label>
                        <select class="select2 form-control" name="desa" id="desa">
                            <option>Pilih Nama/Desa</option>
                            @foreach ($desa as $ds)
                                <option {{ $pilih_desa == $ds->kode ? 'selected' : '' }}value="{{ $ds->id }}">
                                    {{ $ds->kode }} - [{{ $ds->nama }}]
                                </option>
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
                <div class="col-md-12">
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
                        <input type="text" class="form-control" placeholder="Masukkan Link Koordinate"
                            aria-describedby="koordinate" name="koordinate" id="koordinate">
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
                        <input type="text" class="form-control" aria-describedby="Kode_instalasi"
                            name="kode_instalasi" id="kode_instalasi"
                            placeholder="Kode instalasi akan terpenuhi jika desa dipilih" readonly>
                    </div>
                </div>
                @if ($status === 1)
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <label for="total">Nominal</label>
                            <input type="text" class="form-control total" aria-describedby="total" name="total"
                                id="total" value="{{ number_format($settings->pasang_baru, 2) }}" readonly>
                            <small class="text-danger" id="msg_package_id"></small>
                        </div>
                    </div>
                @elseif ($status === 2)
                    <div class="col-md-6">
                        <div class="position-relative mb-3">
                            <label for="total">Nominal</label>
                            <input type="text" class="form-control total total1" aria-describedby="total"
                                name="total" id="total">
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
        <button type="submit" id="SimpanPermohonan" class="btn btn-dark" style="float: right;">Daftar &
            Simpan</button>
        <br>
    </div>
</div>
<script>
    $(".abodemen").maskMoney({
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
