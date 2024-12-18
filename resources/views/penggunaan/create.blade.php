@extends('layouts.base')
@php
    $ketik_search = 'CariCustommers';
    $label_search = 'Nama/Kode Installasi';
@endphp
@section('content')
@if (session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="/usages" method="post" id="FormInputPenggunaan">
    @csrf
    <input type="text" name="pemakaian_id" id="pemakaian_id" hidden>
    <div class="card">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
        </div>
        <div class="card-body">
            <!-- Form Inputs -->

            <input type="hidden" name="_block" id="_block" value="{{ $setting->block }}">
            <input type="hidden" name="_daftar_harga" id="_daftar_harga">
            <div class="row g-3">
                <div class="col-md-3 mb-3">
                   <label for="customer" style="font-size: 13px;height">Nama</label>
                  <input type="text"
                        class="typeahead form-control bg-light border-1 small search"
                        id="cariAnggota" placeholder="{{ $label_search }}">
                    <div class="invalid-feedback">Masukkan (Kode Installasi / Nama Custommers)</div>
                </div>                
                <div class="col-md-2 mb-3">
                    <label for="awal" class="form-label"style="font-size: 13px;">Awal</label>
                    <input type="text" name="awal" id="awal" readonly class="form-control form-control-sm hitungan" value="50">
                    <small class="text-danger" id="msg_awal"></small>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="akhir" class="form-label"style="font-size: 13px;">Akhir</label>
                    <input type="text" name="akhir" id="akhir" class="form-control form-control-sm hitungan">
                    <small class="text-danger" id="msg_akhir"></small>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="jumlah" class="form-label"style="font-size: 13px;">Jumlah</label>
                    <input type="text" readonly name="jumlah" id="jumlah" class="form-control form-control-sm">
                    <small class="text-danger" id="msg_jumlah"></small>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tgl_akhir" class="form-label"style="font-size: 13px;">Tgl Akhir</label>
                    <input type="text" name="tgl_akhir" id="tgl_akhir" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                    <small class="text-danger" id="msg_tgl_akhir"></small>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="/usages" class="btn btn-primary btn-sm">Kembali</a>
            <button type="submit" class="btn btn-dark btn-sm" id="SimpanPemakaian">Simpan</button>
        </div>

    </div>
</form>

@endsection

@section('script')


 <script>
    document.getElementById("close").addEventListener("click", function () {
        window.location.href = "/usages"; // Url kembali
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 5000); // Notifikasi hilang setelah 5 detik
        }
    });

    $(document).on('change', '#customer', function (e) {
        var value = $(this).val().split("|")
        var kode = value[0]
        $('#kode_instalasi').val(kode)

        harga = value[1]
        $("#_daftar_harga").val(harga)
    })

    // $(document).on('change','.hitungan', function() {
    //     var awal = $('#awal').val()
    //     var akhir = $('#akhir').val()

    //     if (akhir - awal < 0 || akhir == '') {
    //         return;
    //     }

    //     var block = JSON.parse($("#_block").val())
    //     var jumlah_block = block.length
    //     var daftar_harga = JSON.parse($("#_daftar_harga").val())
    //     var selisih = akhir - awal

    //     $.each(block, function(key, value) {
    //         var jarak = value.jarak.replace('M3','').split("-");
    //         var jarak_awal = parseInt(jarak[0])
    //         var jarak_akhir = parseInt(jarak[1])
            
    //         if (selisih > jarak_awal) {
    //             $('#jumlah').val(selisih)
    //         }
    //     });
    // })

// $(document).ready(function() {
//     $('#searchCustomer').on('keyup', function() {
//         var searchTerm = $(this).val().toLowerCase();
        
//         if (searchTerm === '') {
//             $('#customerList').hide();
//         } else {
//             $('#customerList').show();
//         }
        
//         $('#customerList .customer-item').each(function() {
//             var customerText = $(this).text().toLowerCase();
//             if (customerText.indexOf(searchTerm) > -1) {
//                 $(this).show();
//             } else {
//                 $(this).hide();
//             }
//         });
//     });

//     $('#customerList').on('click', '.customer-item', function() {
//         var selectedText = $(this).text();
//         var selectedValue = $(this).data('value');

//         $('#searchCustomer').val(selectedText);
//         $('#customerList').hide();

//         console.log('Selected:', selectedValue);
//     });

//     $(document).on('click', function(e) {
//         if (!$(e.target).closest('#searchCustomer, #customerList').length) {
//             $('#customerList').hide();
//         }
//     });
// });


</script>

@endsection
