@extends('layouts.base')

@section('content')
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form class="">
                    <div class="row">
                        <div class="card-body">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
                            </div>
                            <div class="alert alert-light" role="alert">
                                <form action="/installations" method="post" id="FormRegisterProposal"
                                    class="small-font-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="position-relative mb-3">
                                                <label for="customer_id">Customer</label>
                                                <select class="select2 form-control" name="customer_id"
                                                    id="customer_id">
                                                    @foreach ( $customer as $anggota )
                                                    <option value="{{ $anggota->id }}">
                                                        {{ $anggota->nik }} {{ $anggota->nama }}
                                                        [{{ $anggota->village->nama }}]
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="order">Tanggal Order</label>
                                                <input type="text" class="form-control date" id="order"
                                                    aria-describedby="order" placeholder="order"
                                                    value="{{ date('d/m/Y') }}">
                                                <small class="text-danger" id="msg_order"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="position-relative mb-3">
                                                <label for="desa">Nama/Desa</label>
                                                <select class="select2 form-control" name="desa" id="desa">
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
                                                <label for="hamlet_id">Nama/Dusun</label>
                                                <select class="select2 form-control" name="hamlet_id" id="hamlet_id">
                                                    <option>Pilih Nama/Dusun</option>
                                                    @foreach ($installations as $ins)
                                                    <option value="{{ $ins->id }}">
                                                        {{ $ins->alamat }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger" id="msg_hamlet_id"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
                                                <label for="package_id">Paket/Kelas</label>
                                                <select class="select2 form-control" name="package_id" id="package_id">
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
                                </form>
                            </div>
                            <button type="submit" id="SimpanProposal" class="btn btn-dark" style="float: right;">Simpan
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
    $(document).ready(function () {
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
@endsection
