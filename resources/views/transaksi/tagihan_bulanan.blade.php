@extends('layouts.base')
@php
    $search = 'TagihanBulanan';
    $label = 'Usages (Kode Installasi / Nama Custommers)';
@endphp

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="col-12">
            <div class="form-group">
                <input type="text" class="form-control is-valid" id="{{ $search }}" placeholder="{{ $label }}">
            </div>
            <hr class="my-2 bg-white">
            <br>
        </div>

        <div id="accordion">
            <div class="text-center">
                <img src="../../assets/img/air.png" style="max-height: 200px;" class="mb-3">
                <h3 class="text-gray-800 font-weight-bold">Tagihan!</h3>
                <p class="lead text-gray-800 mx-auto">Seacrh untuk melakukan pembayaran</p>
                <a href="#">&larr; Back to Dashboard</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        //hitung total (tagihan bulanan)
        $(document).on('change', '#pembayaran', function() {
            function cleanNumber(value) {
                let cleanNumber = value.toString().replace(/,/g, '');
                return parseFloat(cleanNumber);
            }
            var jumlah = cleanNumber($(this).val());
            var jumlah_bayar = cleanNumber($("#tagihan").val());
            var total = (jumlah - jumlah_bayar);

            $("#total").val(numFormat.format(Math.abs(total)));
        });

        //simpan data pembayaran tagihan bulanan
        $(document).on('click', '.SimpanTagihan', function(e) {
            e.preventDefault();
            $('small').html('');

            var target = $(this).attr('data-form'); // narget button
            var form = $(target); // narget form = id
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            icon: "success",
                            draggable: true
                        });
                        window.open('/transactions/dokumen/struk_tagihan/' + result.transaction_id)
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

        //simpan pembayaran installations
        $(document).on('click', '#simpanpembayaran', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormPembayaran');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Lanjut Pembayaran Tagihan?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Lanjutkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else if (res.isDenied) {
                                window.location.href = '#';
                            }
                        });

                        window.open('/transactions/dokumen/struk_instalasi/' + result.transaction_id)
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

        $(document).on('change', '#tgl_transaksi', function() {

            var tglTransaksi = $('#tgl_transaksi').val();
            var tglAkhir = $('#tgl_akhir').val();
            var denda = $('#denda').val();

            var tanggal = tglTransaksi.split('/')
            var bulan = tanggal[1]

            if (tglAkhir - bulan > 1) {
                denda = denda;
            } else {
                denda = 0;
            }

            $("#denda_bulanan").val(numFormat.format(Math.abs(denda)));
        })
    </script>
@endsection
