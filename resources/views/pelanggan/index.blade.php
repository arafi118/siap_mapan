@extends('layouts.base')

@section('content')

<!-- Row -->
<!-- Row -->
<style>
    table, th, td {
        font-size: 12px;
    }
</style>

<div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-users" style="font-size: 30px; margin-right: 13px;"></i>
                            <b> Data Pelanggan</b>
                        </div>
                        <div>&nbsp;</div>
                        <tr>
                            <th>NIK</th>
                            <th>NAMA LENGKAP</th>
                            <th>ALAMAT</th>
                            <th>TELPON</th>
                            <th>STATUS</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->nik }}</td>
                            <td>{{ $customer->nama }}</td>
                            <td>{{ $customer->alamat }}</td>
                            <td>{{ $customer->hp }}</td>
                            <td></td>
                            <td style="text-align: center;"> 
                                <a href="/customers/{{ $customer->nik }}/edit" class="btn btn-warning"><i class=" fas fa-pencil-alt"></i></a>
                                <a href="/customers/{{ $customer->nik }}" class="btn btn-danger"><i class=" fas fa-trash-alt"></i></a>
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
        ajax: "/database/pelanggan",
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            }, 
            {
                data: 'nik',
                name: 'nik'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'hp',
                name: 'hp'
            },
            {
                data: 'status',
                name: 'status',
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
        window.location.href = '/database/pelanggan/' + data.nik;
    });
</script>

@if (Session::get('berhasil'))
    <script>
        alert('{{ Session::get('berhasil') }}')
    </script>
@endif
@endsection