<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $title }}</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
        integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/ruang-admin-min.css" rel="stylesheet">
    <link href="/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="/assets/css/custom.css?v={{ time() }}">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    @yield('content')
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            @include('layouts.footer')
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @yield('modal')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/assets/vendor/chart.js/Chart.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugins -->
    <script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js"
        integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
        integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.3/typeahead.jquery.min.js"
        integrity="sha512-FoYDcEN8AC55Q46d/gra+GO1tD9Bw7ZTLBUDqaza5YQ+g2UGysVxBoVOkXB6RVVM8wFyPJxr3vcEz9wxbFKM6g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var numFormat = new Intl.NumberFormat('en-EN', {
            minimumFractionDigits: 2
        })

        //cari customors
        $('#PelunasanInstalasi').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'states',
            source: function(query, process) {
                if (query.length < 2) return;

                $.ajax({
                    url: '/installations/CariPelunasan_Instalasi',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        var states = [];
                        result.map(function(item) {
                            if (item.installation.length > 0) {
                                item.installation.map(function(instal) {
                                    states.push({
                                        id: instal.id,
                                        installation: instal,
                                        name: item.nama +
                                            ' - ' + instal.village.nama +
                                            ' - ' + instal.kode_instalasi +
                                            ' [' + item.nik + ']',
                                        value: instal.id
                                    })
                                })
                            }
                        });

                        process(states);
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan saat pemanggilan custommers:", error);
                        process([]);
                    }
                });
            },

            displayKey: 'name',
            autoSelect: true,
            fitToElement: true,
            items: 10

        }).bind('typeahead:selected', function(event, item) {
            var installation = item.installation
            var trx = installation.transaction

            var sum_total = 0;
            trx.map(function(item) {
                sum_total += item.total;
            })
            // console.log(numFormat.format(installation.abodemen))
            // $("#customername").val(installation.customers.nama);

            var tagihan = sum_total - installation.abodemen;
            $("#transaction_id").val(installation.id);
            $("#order").val(installation.order);
            $("#kode_instalasi").val(installation.kode_instalasi);
            $("#alamat").val(installation.village.nama);
            $("#package").val(installation.package.kelas);
            $("#abodemen").val(numFormat.format(installation.abodemen));
            $("#biaya_sudah_dibayar").val(numFormat.format(sum_total));
            $("#tagihan").val(numFormat.format(tagihan));
            $("#_total").val(numFormat.format(installation.abodemen - sum_total));
        });
        //end cari customors
    </script>

    <script>
        var numFormat = new Intl.NumberFormat('en-EN', {
            minimumFractionDigits: 2
        })

        //Tagihan Bulanan (Aktif)
        $('#TagihanBulanan').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'states',
            source: function(query, process) {
                if (query.length < 2) return;

                $.ajax({
                    url: '/installations/CariTagihan_bulanan',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        var states = [];
                        result.map(function(item) {
                            states.push({
                                kode_instalasi: item.kode_instalasi,
                                name: item.nama +
                                    ' - ' + item.kode_instalasi +
                                    ' [' + item.nik + ']',
                                value: item.kode_instalasi,
                                item: item,
                            })
                        });

                        process(states);
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan saat pemanggilan custommers:", error);
                        process([]);
                    }
                });
            },

            displayKey: 'name',
            autoSelect: true,
            fitToElement: true,
            items: 10

        }).bind('typeahead:selected', function(event, item) {
            $.get('/installations/usage/' + item.kode_instalasi, (result) => {
                if (result.success) {
                    $('#accordion').html(result.view)
                } else {
                    $('#accordion').html(result.view)
                }
            })
        });
        //end cari Tagihan perbulan
    </script>

    <script>
        // Awal script untuk cari Anggota Pemakaian
        $('#carianggota').typeahead({
            hint: true,
            highlight: true,
            minLength: 2 // Minimal karakter untuk memulai pencarian
        }, {
            name: 'states',
            source: function(query, process) {
                if (query.length < 2) return; // Hindari pengiriman permintaan jika terlalu pendek

                $.ajax({
                    url: '/usages/cari_anggota',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        var states = result.map(function(item) {
                            return {
                                id: item.customer.kode_instalasi,
                                name: `${item.customer.nama} [${item.customer.kode_instalasi}]`,
                                value: item.customer.kode_instalasi,
                                data: item
                            };
                        });

                        process(states);
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan saat memanggil pelanggan:", error);
                        process([]); // Tetap proses dengan data kosong jika ada error
                    }
                });
            },
            displayKey: 'name',
            autoSelect: true,
            fitToElement: true,
            items: 10
        }).bind('typeahead:selected', function(event, item) {
            var data = item.data;
            var usage = data.usage;

            // Default nilai awal adalah 0 jika tidak ada data penggunaan sebelumnya
            var nilai_awal = usage ? usage.akhir || 0 : 0;

            // Set nilai awal dan customer_id di form
            $('#awal').val(nilai_awal);
            $('#customer_id').val(data.customer.customer_id);
            $('#kode_instalasi').val(data.customer.kode_instalasi);
        });

        $(document).on('change', '.hitungan', function() {
            var awal = parseFloat($('#awal').val()) || 0;
            var akhir = parseFloat($('#akhir').val()) || 0;
            var jarak_awal = parseFloat($('#jarak_awal').val()) || 0;

            if (akhir <= awal || akhir === 0) {
                alert('Nilai akhir tidak valid. Harus lebih besar dari nilai awal.');
                $('#jumlah').val('');
                return;
            }

            var selisih = akhir - awal;

            if (selisih >= jarak_awal) {
                $('#jumlah').val(selisih);
                $('#awal').val(awal);
            } else {
                $('#jumlah').val();
                alert('Selisih tidak memenuhi syarat jarak minimum.');
            }
        });
    </script>

    @yield('script')
</body>

</html>
