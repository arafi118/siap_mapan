@extends('layouts.base')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div id="tabsContent" class="tab-content">
        <!-- Permohonan Tab -->
        <div role="tab" class="tab-pane active show">
            <!-- Content for Permohonan -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush table-hover" id="TbPermohonan">
                                <thead class="thead-light">
                                    <tr>
                                        <th>kode instalasi</th>
                                        <th>Customer</th>
                                        <th>Paket</th>
                                        <th>Tanggal Order</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status_0 as $status_0)
                                    <tr>
                                        <td>{{ $status_0->kode_instalasi }}</td>
                                        <td>{{ ($status_0->customer) ? $status_0->customer->nama:'' }}</td>
                                        <td>{{ ($status_0->package) ? $status_0->package->kelas:'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status_0->order)->format('d-m-Y') }}</td>
                                        <td>
                                            @if($status_0->status === '0')
                                            <a href="/installations/{{ $status_0->id}}/edit"
                                                class="btn-sm btn-warning"><i
                                                    class="fa fa-exclamation-circle">&nbsp;Pengajuan</i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#TbPermohonan').DataTable();
    });

</script>
@endsection
