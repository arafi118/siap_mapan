@extends('layouts.base')
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <form action="/" method="post" id="FormTahunTutupBuku">
            @csrf
            <input type="hidden" name="tgl_pakai" id="tgl_pakai" value="{{ $business->tgl_pakai }}">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="alert alert-light" role="alert">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="tahun">Tahun</label>
                                            <select class="form-control select2" name="tahun" id="tahun">
                                                @php
                                                    $tgl_pakai = $business->tgl_pakai;
                                                    $th_pakai = explode('-', $tgl_pakai)[0];
                                                @endphp
                                                @for ($i = $th_pakai; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}"
                                                        {{ date('Y') == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <small class="text-danger" id="msg_tahun"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-secondary" type="button" id="TutupBuku">
                                    <span class="text">1. Tutup Buku</span>
                                </button>

                                <button class="btn btn-primary" type="button" id="PembagianLaba"
                                    style="float: right; margin-left: 10px;">
                                    <span class="text">2. Simpan Alokasi Laba</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid" id="LayoutPreview">

    </div>
@endsection
@section('modal')
    <!-- Ini adalah modal -->
@endsection
@section('script')
    <script>
        //select 2
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });

        var tahun = "{{ date('Y') }}"
        var bulan = "{{ date('m') }}"

        $(document).on('change', 'select#tahun', function(e) {
            e.preventDefault()

            var tahun_val = $(this).val()
            if ((tahun == tahun_val && bulan <= 10)) {
                $('#TutupBuku').prop("disabled", true)
            } else {
                $('#TutupBuku').prop("disabled", false)
            }
        })

        window.addEventListener('message', function(event) {
            if (event.data === 'closed') {
                $('#FormTahunTutupBuku').attr('action', '/transactions/tutup_buku/saldo')
                $('#LayoutPreview').html(
                    '<div class="card"><div class="card-body p-3"><div class="p-5"></div></div></div>')

                var form = $('#FormTahunTutupBuku')
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(result) {
                        if (result.success) {
                            $('#LayoutPreview').html(result.view)
                        }
                    }
                })
            }
        })

        $(document).on('change', 'select#tahun', function(e) {
            e.preventDefault()

            var tahun_val = $(this).val()
            if ((tahun == tahun_val && bulan <= 10)) {
                $('#TutupBuku').prop("disabled", true)
            } else {
                $('#TutupBuku').prop("disabled", false)
            }
        })


        $(document).on('click', '#TutupBuku', function(e) {
            e.preventDefault()
            $('#FormTahunTutupBuku').attr('action', '/transactions/tutup_buku/saldo_tutup_buku')
            $('#LayoutPreview').html(
                '<div class="card"><div class="card-body p-3"><div class="p-5"></div></div></div>')

            var form = $('#FormTahunTutupBuku')
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        $('#LayoutPreview').html(result.view)
                    }
                }
            })
        })

        $(document).on('click', '#PembagianLaba', function(e) {
            e.preventDefault()
            $('#FormTahunTutupBuku').attr('action', '/transactions/tutup_buku')

            $('#FormTahunTutupBuku').submit()
        })
    </script>
@endsection
