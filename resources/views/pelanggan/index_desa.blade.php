@extends('layouts.base')

@section('content')

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="TbDesa">
                        <thead class="thead-light">
                            <div
                                style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <!-- Data Desa -->
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-home" style="font-size: 30px; margin-right: 9px;"></i>
                                    <b>Data Desa</b>
                                </div>
                                <div>
                                    <a href="/villages/create" class="btn btn-primary" id="RegisterDesa"
                                        style="display: inline-block; width: 130px; height: 30px; text-align: center; line-height: 18px; font-size: 12px;"><i
                                        class="fas fa-plus"></i> Register Desa</a>
                                </div>
                            </div>
                            <div>&nbsp;</div>
                            <tr>
                                <th>KODE</th>
                                <th>NAMA DESA</th>
                                <th>ALAMAT</th>
                                <th>TELPON</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($villages as $village)
                            <tr>
                                <td>{{ $village->kode }}</td>
                                <td>{{ $village->nama }}</td>
                                <td>{{ $village->alamat }}</td>
                                <td>{{ $village->hp }}</td>
                                <td style="text-align: center;">
                                    <a href="/villages/{{ $village->id }}/edit" class="btn btn-warning"><i class=" fas fa-pencil-alt"></i></a>
                                    <a href="/villages/{{ $village->id }}" class="btn btn-danger"><i class=" fas fa-trash-alt"></i></a>
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
    $(document).ready(function () {
        $('#TbDesa').DataTable(); // ID From dataTable 
    });

</script>

@if (Session::get('berhasil'))
<script>
    alert('{{ Session::get('
        berhasil ') }}')

</script>
@endif
@endsection
