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
@section('modal')
@endsection
@section('script')
    <script>
        //hitung _total
        $(document).on('change', '#pembayaran', function() {
            function cleanNumber(value) {
                let cleanNumber = value.toString().replace(/,/g, ''); // Remove commas
                return parseFloat(cleanNumber); // Convert back to number
            }
            var jumlah = cleanNumber($(this).val());
            var jumlah_bayar = cleanNumber($("#tagihan").val());
            var total = (jumlah - jumlah_bayar);

            $("#total").val(numFormat.format(total));
        });

        //simpan data
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
