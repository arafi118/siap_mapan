@extends('layouts.base')

@php
$label_search = 'Nama/Kode Installasi';
@endphp

@section('content')
<form action="/usages/storeSampah" method="post" id="FormInputSampah">
    @csrf

    <input type="hidden" id="tgl_toleransi" value="{{ $settings->tanggal_toleransi }}">
    <input type="hidden" id="caters" value="{{ $cater_id }}">
    <input type="hidden" name="tanggal" id="tanggal" value="{{ $bulan }}">

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div style="overflow-x:auto;">
                        <table class="table align-items-center table-flush table-center table-hover" id="TbPemakain">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>NAMA</th>
                                    <th>DUSUN</th>
                                    <th>RT</th>
                                    <th>NO.INDUK</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody id="DaftarInstalasi"></tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="col-12 d-flex justify-content-end">
                        <a href="/usages/sampah" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<div style="display:none;" id="print"></div>

@include('sampah.partials.pemakaian')

@endsection
@section('script')
    <script>
    $("#jumlah_bayar").maskMoney({
        allowNegative: false,
        thousands: '.',
        decimal: '.',
        precision: 2
    });

    $(document).on('keyup','#jumlah_bayar',function(){
        $('#jumlah_').val($('#jumlah_bayar').maskMoney('unmasked')[0]);
    });

    function showModalInputPemakaian(installation){

        var abodemen = parseFloat(installation.abodemen) || 0;
        var akhir = $(installation.akhir)
        var allowInput = akhir.attr('data-allow-input') || false

        if (installation.customer.jk == 'P') {
            $('.avatar-customer').attr('src', '{{ asset("assets/img/woman.png") }}')
        } else {
            $('.avatar-customer').attr('src', '{{ asset("assets/img/man.png") }}')
        }

        var inisialPaket = installation.package.kelas.charAt(0).toUpperCase()

        $('.namaCustomer').html(installation.customer.nama)
        $('.customer').val(installation.customer_id)
        $('.NikCustomer').html(installation.customer.nik ? installation.customer.nik : '-')
        $('.id_instalasi').val(installation.id)
        $('.AlamatCustomer').html(installation.customer.alamat + '.' + installation.customer.hp)
        $('.KdInstallasi').html(installation.kode_instalasi + ' ' + inisialPaket)
        $('.CaterInstallasi').html(installation.users.nama)
        $('.PackageInstallasi').html(installation.package.kelas)
        $('.AlamatInstallasi').html(installation.alamat)

        $('#jumlah_bayar').maskMoney('mask', abodemen)
        $('#jumlah_').val(abodemen)

        if (allowInput == 'false') {
            $('#SimpanSampah').attr('disabled', true)
        } else {
            $('#SimpanSampah').attr('disabled', false)
        }

        $('#staticBackdrop').modal('show')
    }

    let dataInstallation
    let dataSearch
    let indexInput
    let dataPemakaian = []

    var id_cater = $('#caters').val()
    var tanggal = $('#tanggal').val()

    var dataTable = $('#TbPemakain').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/installations/cater/' + id_cater + '?tanggal=' + tanggal,
            type: 'GET'
        },
        language: {
            processing: `<i class="fas fa-spinner fa-spin"></i> Mohon Tunggu....`,
            emptyTable: "Tidak ada data yang tersedia",
            search: "",
            searchPlaceholder: "Pencarian...",
            paginate: {
                next: "<i class='fas fa-angle-right'></i>",
                previous: "<i class='fas fa-angle-left'></i>"
            }
        },
        columns: [
            { data: 'customer.nama' },
            { data: 'village.dusun' },
            { data: 'rt' },
            {
                data: 'kode_instalasi',
                render: function (data, type, row) {
                    return `${data}.${row.package.kelas.charAt(0).toUpperCase()}`
                }
            },
            {
                data: 'abodemen',
                render: function (data) {
                    return Number(data).toLocaleString('de-DE', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                }
            }
        ]
    })

    $('#TbPemakain_filter').html(`
        <div class="input-group">
            <input type="text" id="customSearch" class="form-control" placeholder="Cari Pelanggan...">
        </div>
    `)

    $('#customSearch').on('keyup', function () {
        dataTable.search(this.value).draw()
    })

    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    })

    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert')
        if (alert) {
            setTimeout(() => {
                alert.classList.add('d-none')
            }, 5000)
        }
    })

    $(document).on('change', '.hitungan', function () {

        var awal = $('#awal').val()
        var akhir = $('#akhir').val()

        if (akhir - awal < 0 || akhir == '') {
            return
        }

    })

    jQuery.datetimepicker.setLocale('de')

    $('.date').datetimepicker({
        i18n: {
            de: {
                months: [
                    'Januar','Februar','März','April',
                    'Mai','Juni','Juli','August',
                    'September','Oktober','November','Dezember'
                ],
                dayOfWeek: [
                    "So.","Mo","Di","Mi",
                    "Do","Fr","Sa."
                ]
            }
        },
        timepicker: false,
        format: 'd/m/Y'
    })

    $(document).on('change', '.tanggal', function () {
        $('.tanggal').val($(this).val())
    })

    $('#TbPemakain').on('click', 'tbody tr', function () {
        var installation = dataTable.row(this).data()
        showModalInputPemakaian(installation)
    })

    $(document).on('focus', '.input-jumlah-bayar', function (e) {
        e.preventDefault()
        $(this).select()
    })

    $(document).on('change', '.input-jumlah-bayar', function (e) {
        e.preventDefault()

        var id = $(this).attr('id').split('_')[1]
        var nilai_akhir = $(this).val()
        var nilai_awal = $('#awal_' + id).val()

        if (nilai_akhir - nilai_awal < 0) {
            Swal.fire({
                title: 'Periksa kembali nilai yang dimasukkan',
                text: 'Nilai Akhir tidak boleh lebih kecil dari Nilai Awal',
                icon: 'warning'
            })
            $(this).val(nilai_awal)
            return
        }

        var jumlah = nilai_akhir - nilai_awal
        $('#jumlah_' + id).val(jumlah)

    })

    $(document).on('click', '#SimpanSampah', function (e) {
        e.preventDefault()

        var id_cater = $('#caters').val()
        var customer = $('#customer').val()
        var awal = $('#awal_').val()
        var akhir = $('#akhir_').val()
        var jumlah = $('#jumlah_').val()
        var id_instalasi = $('#id_instalasi').val()
        var kd_instalasi = $('.KdInstallasi').html()
        var tgl = $('#tanggal').val()
        var toleransi = $('#tgl_toleransi').val()

        var data = {
            id_instalasi: id_instalasi,
            tgl_pemakaian: tgl,
            kd_instalasi: kd_instalasi,
            id_cater: id_cater,
            customer: customer,
            awal: awal,
            akhir: akhir,
            jumlah: jumlah,
            toleransi: toleransi
        }

        var form = $('#FormInputSampah')

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: {
                _token: form.find('input[name="_token"]').val(),
                tanggal: $('#tanggal').val(),
                data: data
            },
            success: function (result) {

                if (result.success) {

                    toastMixin.fire({
                        title: 'Pemakaian Berhasil di Input'
                    })

                    $('#staticBackdrop').modal('hide')
                    dataTable.ajax.reload()

                }

            },
            error: function () {
                alert('Terjadi kesalahan saat menyimpan')
            }
        })
    })
</script>
@endsection