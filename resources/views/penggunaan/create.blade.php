@extends('layouts.base')
@php
    $label_search = 'Nama/Kode Installasi';

@endphp
@section('content')
    <form action="/usages" method="post" id="FormInputPemakaian">
        @csrf
        <input type="hidden" id="tgl_toleransi" value="{{ $settings->tanggal_toleransi }}">
        <input type="hidden" id="caters" value="{{ $cater_id }}">
        <input type="hidden" name="tanggal" id="tanggal" value="{{ date('d/m/Y') }}">

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info align-items-center text-white {{ auth()->user()->jabatan == '5' ? 'd-none' : 'd-flex mb-3' }}"
                            role="alert" style="border-radius: 1;">
                            <!-- Gambar -->
                            <img src="../../assets/img/air.png"
                                style="max-height: 160px; margin-right: 15px; margin-left: 10px;"
                                class="img-fluid d-none d-lg-block">

                            <div class="flex-grow-1">
                                <div class="mt-3">
                                    <h3><b>Input Pemakaian Air Bulanan</b></h3>
                                </div>
                                <hr class="my-2 bg-white">
                                {{-- <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <select class="select2 form-control" name="caters" id="caters">
                                            <option value=""></option>
                                            @foreach ($caters as $cater)
                                                <option value="{{ $cater->id }}">{{ $cater->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="tanggal" id="tanggal"
                                            class="form-control tanggal date" value="{{ date('d/m/Y') }}">
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div style="overflow-x: auto;">
                            <table class="table align-items-center table-flush table-center table-hover" id="TbPemakain">
                                <thead class="thead-light" align="center">
                                    <tr>
                                        <th>NAMA</th>
                                        <th>DUSUN</th>
                                        <th>RT</th>
                                        <th>NO.INDUK</th>
                                        <th>METER AWAL</th>
                                        <th>METER AKHIR</th>
                                        <th>PEMAKAIAN</th>
                                    </tr>
                                </thead>
                                <tbody id="DaftarInstalasi">
                                    <!-- Data akan ditambahkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="col-12 justify-content-end d-flex">
                            <a href="/usages" class="btn btn-secondary">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <div style="display: none;" id="print"></div>
    @include('penggunaan.partials.pemakaian')
    @include('penggunaan.barcode')
@endsection

@section('script')
    <script>
        let dataInstallation;
        let dataSearch;
        let indexInput;
        let dataPemakaian = [];

        var startScan, scanningEnabled = true;
        var html5QrcodeScanner;


        $(document).ready(function() {
            scanningEnabled = true

            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                false);

            html5QrcodeScanner.render((result) => {
                if (scanningEnabled) {
                    $('tr[data-id=' + result + '] td:first-child').click()
                    $('#scanQrCode').modal('hide')
                }
            });

            $('#html5-qrcode-button-camera-start').hide()
            $('#html5-qrcode-button-camera-stop').hide()
            $('#html5-qrcode-anchor-scan-type-change').hide()

            $('#html5-qrcode-button-camera-start').trigger('click')

            startScan = true
            $('#stopScan').html('Stop')
        })

        var id_cater = $('#caters').val();
        var tanggal = $('#tanggal').val();

        $.get('/installations/cater/' + id_cater + '?tanggal=' + tanggal, function(result) {
            if (result.success) {
                dataInstallation = result.installations;
                dataSearch = dataInstallation
                setTable(dataInstallation)
            }
        })

        $(document).on('click', '#stopScan', function(e) {
            e.preventDefault()

            if (startScan) {
                $(this).html('Scan Ulang')
                $('#html5-qrcode-button-camera-stop').trigger('click')
            } else {
                scanningEnabled = true;
                $(this).html('Stop')
                $('#html5-qrcode-button-camera-start').trigger('click')
            }

            startScan = !startScan
        })

        $(document).on('click', '#scanQrCodeClose', function(e) {
            $('#scanQrCode').modal('hide')
            $('#html5-qrcode-button-camera-stop').trigger('click')
            $('#stopScan').html('Stop')
        })

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);
        }

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
        }

        const video = document.getElementById('video');
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: {
                        ideal: "environment"
                    }
                }
            })
            .then(stream => {
                video.srcObject = stream;

                const track = stream.getVideoTracks()[0];
                const settings = track.getSettings();

                if (settings.facingMode === "user") {
                    video.classList.add("mirror");
                } else {
                    video.classList.remove("mirror");
                }
            });

        $(document).on('click', '#scanMeter', function(e) {
            const canvas = document.getElementById('tmpImage');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const context = canvas.getContext('2d');
            context.filter = "contrast(250%) brightness(125%)";
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const scanX = canvas.width * 0.20;
            const scanY = canvas.height * 0.40;
            const scanWidth = canvas.width * 0.60;
            const scanHeight = canvas.height * 0.20;

            const previewImage = document.getElementById("previewImage");
            previewImage.width = scanWidth;
            previewImage.height = scanHeight;

            const previewContex = previewImage.getContext("2d");
            const imageData = context.getImageData(scanX, scanY, scanWidth, scanHeight);
            previewContex.putImageData(imageData, 0, 0);

            setTimeout(() => {
                Tesseract.recognize(
                    previewImage,
                    'eng', {
                        logger: m => console.log(m),
                        tessedit_char_whitelist: '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ',
                        preserve_interword_spaces: 1,
                        oem: 3,
                        psm: 4,
                    }
                ).then(({
                    data: {
                        text
                    }
                }) => {
                    const hasilMatch = text.match(/\d+/);
                    const angka = hasilMatch ? hasilMatch[0] : "0";

                    console.log(text, angka);
                    $('.input-nilai-akhir').val(angka);
                });
            }, 500);
        })

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });
        $('#btnScanKartu').on('click', function(e) {
            e.preventDefault();
            $('#scanQrCode').modal('show');
        });
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add(
                        'd-none'); // Menyembunyikan notifikasi dengan menambahkan class 'd-none'
                }, 5000); // Notifikasi hilang setelah 5 detik
            }
        });

        $(document).on('change', '.hitungan', function() {
            var awal = $('#awal').val()
            var akhir = $('#akhir').val()

            if (akhir - awal < 0 || akhir == '') {
                return;
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

        $(document).on('change', '.tanggal', function(e) {
            $('.tanggal').val($(this).val());
        })

        $(document).on('click', '#TbPemakain #DaftarInstalasi tr td', function() {
            var parent = $(this).parent()
            var allowInput = parent.attr('data-allow-input')
            var index = parent.attr('data-index')

            var installation = dataSearch[index]

            if (installation.customer.jk == 'P') {
                $('.avatar-customer').attr('src', '{{ asset('assets/img/woman.png') }}')
            } else {
                $('.avatar-customer').attr('src', '{{ asset('assets/img/man.png') }}')
            }

            var inisialPaket = installation.package.kelas.charAt(0).toUpperCase()
            $('.namaCustomer').html(installation.customer.nama)
            $('.customer').val(installation.customer_id)
            $('.NikCustomer').html(installation.customer.nik)
            $('.id_instalasi').val(installation.id)
            $('.AlamatCustomer').html(installation.customer.alamat + '.' + installation.customer.hp)
            $('.KdInstallasi').html(installation.kode_instalasi + ' ' + inisialPaket)
            $('.CaterInstallasi').html(installation.users.nama)
            $('.PackageInstallasi').html(installation.package.kelas)
            $('.AlamatInstallasi').html(installation.alamat)
            $('.AkhirUsage').val(installation.one_usage?.akhir || 0)
            $('.TglAkhirUsage').val(installation.one_usage?.tgl_akhir || 0)
            $('.PemakaianUsage').val(installation.one_usage?.tgl_pemakaian || 0)

            if (allowInput == 'false') {
                $('#SimpanPemakaian').attr('disabled', true)
            } else {
                $('#SimpanPemakaian').attr('disabled', false)
            }

            $('#staticBackdrop').modal('show')
            indexInput = index
        })

        function searching(search) {
            let data = dataInstallation;

            dataSearch = data.filter((element) => {
                return (
                    element.kode_instalasi.includes(search) ||
                    element.customer.nama.toLowerCase().includes(search)
                )
            });

            setTable(dataSearch)
        }

        function setTable(data) {
            $('#TbPemakain').DataTable().destroy();
            const table = $('#DaftarInstalasi');
            table.html('');

            const formatbulan1 = (tanggal, type = 'date') => {
                if (!tanggal) return '';
                const parts = tanggal.split('/');
                return (parts.length === 3 && type === 'month') ? parts[1] : '';
            };

            const formatbulan2 = (tanggal, type = 'date') => {
                if (!tanggal) return '';
                const parts = tanggal.split('-');
                return (parts.length === 3 && type === 'month') ? parts[1] : '';
            };

            const tgl_hariini = formatbulan1($('#tanggal').val(), 'month');

            data.forEach((item, index) => {
                console.log(item);
                const nilai_awal = item.one_usage ? item.one_usage.akhir : '0';
                const nilai_akhir = item.one_usage ? item.one_usage.akhir : '0';
                const nilai_jumlah = item.one_usage ? item.one_usage.jumlah : '0';

                const tgl_pemakaian = item.one_usage ? formatbulan2(item.one_usage.tgl_pemakaian, 'month') : '0';
                const tgl_akhir = item.one_usage ? formatbulan2(item.one_usage.tgl_akhir, 'month') : '0';

                let allowInput = false;
                let colorClass = 'text-danger';
                let hasildata = 0;
                let jumlahN = 0;

                // tampilkan hanya jika belum pernah diinput dan waktunya sudah sesuai
                if (tgl_akhir <= tgl_hariini) {
                    allowInput = true;
                    colorClass = 'text-warning';
                    hasildata = nilai_awal;
                    jumlahN = 0;
                }

                // jika sudah pernah diinput ATAU belum waktunya → jangan tampilkan
                if (
                    tgl_pemakaian >= tgl_hariini ||
                    jQuery.inArray(item.id.toString(), dataPemakaian) !== -1
                ) {
                    // tetap disimpan kalau diperlukan, tapi tidak ditampilkan
                    return;
                }

                // tampilkan di tabel jika memenuhi syarat
                if (allowInput) {
                    table.append(`
                <tr data-index="${index}" data-allow-input="${allowInput}" data-id="${item.id}">
                    <td align="left">${item.customer.nama}</td> 
                    <td align="left">${item.village?.dusun || '-'}</td>
                    <td align="left">${item.rt}</td>
                    <td align="center">${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>   
                    <td align="right" class="awal"><b>${nilai_awal}</b></td> 
                    <td align="right" class="akhir ${colorClass}"><b>${hasildata}</b></td> 
                    <td align="right" class="jumlah">${jumlahN}</td> 
                </tr>
            `);
                }
            });

            $('#TbPemakain').DataTable();

        }


        $(document).on('focus', '.input-nilai-akhir', function(e) {
            e.preventDefault();
            $(this).select();
        });

        $(document).on('change', '.input-nilai-akhir', function(e) {
            e.preventDefault()

            var id = $(this).attr('id').split('_')[1]
            var nilai_akhir = $(this).val()
            var nilai_awal = $('#awal_' + id).val()

            if (nilai_akhir - nilai_awal < 0) {
                Swal.fire({
                    title: 'Periksa kembali nilai yang dimasukkan',
                    text: 'Nilai Akhir tidak boleh lebih kecil dari Nilai Awal',
                    icon: 'warning',
                })

                $(this).val(nilai_awal)
                return;
            }

            var jumlah = nilai_akhir - nilai_awal
            $('#jumlah_' + id).val(jumlah)
        })

        $(document).on('click', '#SimpanPemakaian', function(e) {
            e.preventDefault();

            var id_cater = $('#caters').val();
            var customer = $('#customer').val();
            var awal = $('#awal_').val();
            var akhir = $('#akhir_').val();
            var jumlah = $('#jumlah_').val();
            var id = $('#id_instalasi').val();
            var tgl = $('#tanggal').val();
            var toleransi = $('#tgl_toleransi').val();

            var data = {
                id: id,
                tgl_pemakaian: tgl,
                id_cater: id_cater,
                customer: customer,
                awal: awal,
                akhir: akhir,
                jumlah: jumlah,
                toleransi: toleransi
            };

            var form = $('#FormInputPemakaian');
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: {
                    _token: form.find('input[name="_token"]').val(),
                    tanggal: $('#tanggal').val(),
                    data: data
                },
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pemakaian Berhasil di Input'
                        });

                        let pemakaian = result.pemakaian;
                        dataSearch[indexInput].one_usage = pemakaian;
                        dataPemakaian.push(pemakaian.id_instalasi.toString());
                        setTable(dataSearch);

                        // Tutup modal
                        $('#staticBackdrop').modal('hide');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan');
                }
            });
        });
    </script>
@endsection
