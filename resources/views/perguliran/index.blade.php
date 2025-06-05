@extends('layouts.base')

@section('content')
    <ul class="nav nav-pills nav-fill d-none" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link active" id="pills-table-tab" data-toggle="tab" data-target="#pills-table">
                Table
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link" id="pills-detail-tab" data-toggle="tab" data-target="#pills-detail">
                Detail
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link" id="pills-edit-tab" data-toggle="tab" data-target="#pills-edit">
                Edit
            </a>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
            @include('perguliran.tabs.table')
        </div>
        <div class="tab-pane fade" id="pills-detail" role="tabpanel" aria-labelledby="pills-detail-tab">
            @include('perguliran.tabs.detail')
        </div>
        <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">...</div>
    </div>

    <form action="" method="post" id="FormHapus">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    <script>
        var data = ''
        var column = [{
            data: 'kode_instalasi',
            render: function(data, type, row) {
                return data + '.' + row.package.inisial
            }
        }, {
            data: 'customer.nama'
        }, {
            data: 'alamat'
        }, {
            data: 'package.kelas'
        }, {
            data: 'order',
            render: function(data, type, row) {
                return data ? moment(data).format('DD/MM/YYYY') : '-';
            }
        }, {
            data: 'status',
            render: function(data, type, row) {
                if (data === 'R') {
                    return '<span class="badge badge-info">PAID</span>';
                } else if (data === '0') {
                    return '<span class="badge badge-secondary">UNPAID</span>'
                } else if (data === 'I') {
                    return '<span class="badge badge-primary">PASANG</span>';
                } else if (data === 'A') {
                    return '<span class="badge badge-success">Aktif</span>';
                } else if (data === 'B') {
                    return '<span class="badge badge-warning">Blokir</span>';
                } else if (data === 'C') {
                    return '<span class="badge badge-danger">Cabut</span>';
                }

                return data;
            }
        }, {
            data: 'aksi',
            orderable: false,
            searchable: false
        }]

        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })

        var TbPermohonan = initTable('#TbPermohonan', 'R,0')

        var TbPasang = initTable('#TbPasang', 'I', [{
            data: 'order',
            replace: 'pasang'
        }]);

        var TbAktif = initTable('#TbAktif', 'A', [{
            data: 'order',
            replace: 'aktif'
        }]);

        var TbBlokir = initTable('#TbBlokir', 'B', [{
            data: 'order',

            replace: 'blokir'
        }]);

        var TbCabut = initTable('#TbCabut', 'C', [{
            data: 'order',
            replace: 'cabut'
        }]);

        // $('#TbPermohonan').on('click', '.btn-data', function(e) {
        //     e.preventDefault();
        //     data = TbPermohonan.row($(this).parents('tr')).data();
        // });

        // $(document).on('click', '.btn-detail', function(e) {
        //     e.preventDefault();

        //     $('#namaCustomer').html(data.customer.nama);
        //     $('#desaInstallation').html(data.village.dusun + ' RT. ' + data.rt + ' Desa ' + data.village.nama);
        //     $('#kodeInstallation').html(data.kode_instalasi + '.' + data.package.inisial);
        //     $('#statusInstallation').html(data.status);
        //     $('#tanggalOrder').html(data.order ? moment(data.order).format('DD/MM/YYYY') : '-');
        //     $('#Abodemen').html('Rp. ' + formatter.format(data.abodemen));
        //     $('#paketInstalasi').html(data.package.kelas);

        //     $('#pills-detail-tab').trigger('click');
        // });

        // $(document).on('click', '.Hapus_id', function(e) {
        //     e.preventDefault();

        //     var hapus_id = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
        //     var actionUrl = '/installations/' + hapus_id; // URL endpoint untuk proses hapus

        //     Swal.fire({
        //         title: "Apakah Anda yakin?",
        //         text: "Data Akan dihapus secara permanen dari aplikasi tidak bisa dikembalikan!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: "Hapus",
        //         cancelButtonText: "Batal",
        //         reverseButtons: true
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             var form = $('#FormHapus')
        //             $.ajax({
        //                 type: form.attr('method'), // Gunakan metode HTTP DELETE
        //                 url: actionUrl,
        //                 data: form.serialize(),
        //                 success: function(response) {
        //                     Swal.fire({
        //                         title: "Berhasil!",
        //                         text: response.message || "Data berhasil dihapus.",
        //                         icon: "success",
        //                         confirmButtonText: "OK"
        //                     }).then((res) => {
        //                         if (res.isConfirmed) {
        //                             window.location.reload()
        //                         } else {
        //                             window.location.href = '/installations/';
        //                         }
        //                     });
        //                 },
        //                 error: function(response) {
        //                     const errorMsg = "Terjadi kesalahan.";
        //                     Swal.fire({
        //                         title: "Error",
        //                         text: errorMsg,
        //                         icon: "error",
        //                         confirmButtonText: "OK"
        //                     });
        //                 }
        //             });
        //         } else if (result.dismiss === Swal.DismissReason.cancel) {
        //             Swal.fire({
        //                 title: "Dibatalkan",
        //                 text: "Data tidak jadi dihapus.",
        //                 icon: "info",
        //                 confirmButtonText: "OK"
        //             });
        //         }
        //     });
        // });

        $(document).on('click', '.kembali', function(e) {
            e.preventDefault();
            $('#pills-table-tab').trigger('click');
        });

        function initTable(target, status, replaceColumn = []) {
            var tableColumn = column
            if (replaceColumn.length > 0) {
                tableColumn.forEach((col, index) => {
                    replaceColumn.forEach((replaceCol) => {
                        if (col.data === replaceCol.data) {
                            tableColumn[index].data = replaceCol.replace;
                            tableColumn[index].mData = replaceCol.replace;
                        }
                    });
                });
            }

            return $(target).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/installations',
                    data: {
                        status
                    }
                },
                columns: tableColumn,
                order: [
                    [0, 'desc']
                ],
            });
        }
    </script>
@endsection
