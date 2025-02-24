@extends('layouts.base')

@section('content')
    <div class="app-main__inner">
        <div class="tab-content">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div id="akun">
                                <ul>
                                    @foreach ($akun1 as $lev1)
                                        <li>{{ $lev1->kode_akun }}. {{ $lev1->nama_akun }}
                                            <ul>
                                                @foreach ($lev1->akun2 as $lev2)
                                                    <li>{{ $lev2->kode_akun }}. {{ $lev2->nama_akun }}
                                                        <ul>
                                                            @foreach ($lev2->akun3 as $lev3)
                                                                <li>{{ $lev3->kode_akun }}. {{ $lev3->nama_akun }}
                                                                    <ul>
                                                                        @foreach ($lev3->accounts as $lev4)
                                                                            <li>{{ $lev4->kode_akun }}.{{ $lev4->nama_akun }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
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
        $('#akun').jstree();
    </script>
@endsection
