@extends('layouts.base')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
    </div>
@endif

<!-- Row -->
<div class="col-lg-12">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <!-- Bagian kiri: Rekening -->
        <div style="display: flex; align-items: center;">
            <i class="fa fa-cubes" style="font-size: 30px; margin-right: 7px;"></i>
            <b>Data Paket</b>
        </div>
        <!-- Bagian kanan: Tombol -->
        <div>
            <a href="/packages/create" class="btn btn-primary" id="RegisterPaket">Register Paket</a>
        </div>
    </div>
</div>
<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="TbPaket">
                    <thead class="thead-light">
                        <div>&nbsp;</div>
                        <tr>
                            <th>KELAS</th>
                            <th>HARGA</th>
                            <th>HARGA1</th>
                            <th>BEBAN</th>
                            <th>DENDA</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $paket)
                        <tr>
                            <td>{{ $paket->kelas }}</td>
                            <td>{{ $paket->harga }}</td>
                            <td>{{ $paket->harga1 }}</td>
                            <td>{{ $paket->abodemen }}</td>
                            <td>{{ $paket->denda }}</td>
                            <td style="text-align: center;"> 
                                <a href="/packages/{{ $paket->id }}/edit" class="btn btn-warning"><i class=" fas fa-pencil-alt"></i></a>
                                <a href="/packages/{{ $paket->id }}" class="btn btn-danger"><i class=" fas fa-trash-alt"></i></a>
                              </td>
                        </tr> 
                        @endforeach                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Row-->

<!-- Documentation Link -->

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <a href="login.html" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var table = $('.table-hover').DataTable({
        language: {
            paginate: {
                previous: "&laquo;",
                next: "&raquo;"
            }
        },
        processing: true,
        serverSide: true,
        ajax: "/packages",
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            }, 
            {
                data: 'kelas',
                name: 'kelas'
            },
            {
                data: 'harga',
                name: 'harga'
            },
            {
                data: 'harga1',
                name: 'harga1'
            },
            {
                data: 'abodemen',
                name: 'abodemen'
            },
            {
                data: 'denda',
                name: 'denda',
                orderable: false,
                searchable: false,
            }
        ],
        order: [
            [0, 'desc']
        ]
    });

    $('.table').on('click', 'tbody tr', function (e) {
        var data = table.row(this).data();
        window.location.href = '/packages' + data.kelas;
    });
</script>
<script>
     $(document).ready(function () {
        $('#TbPaket').DataTable(); // ID From dataTable 
    });
</script>

@if (Session::get('berhasil'))
    <script>
        alert('{{ Session::get('berhasil') }}')
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hapus notifikasi setelah 3 detik
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show'); // Hilangkan kelas 'show' untuk animasi fade out
                setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
            }
        }, 3000);
    });
</script>

@endsection

