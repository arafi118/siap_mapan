@extends('layouts.base')

@section('content')
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden">
                <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-3.png);"></div>

                <div class="card-body position-relative">
                    <h6 class="font-weight-bold">
                        Instalasi
                    </h6>
                    <div class="display-4 fs-5 mb-2 font-weight-normal text-success" id="InstallationCount">
                        {{ $Installation }}
                    </div>
                    <a class="font-weight-bold text-nowrap fs-10" href="../app/e-commerce/customers.html">
                        See all
                        <span class="fas fa-angle-right mr-1"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden">
                <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-2.png);"></div>

                <div class="card-body position-relative">
                    <h6 class="font-weight-bold">
                        Pemakaian
                    </h6>
                    <div class="display-4 fs-5 mb-2 font-weight-normal text-primary" id="UsageCount">
                        {{ $Usage }}
                    </div>
                    <a class="font-weight-bold text-nowrap fs-10" href="../app/e-commerce/customers.html">
                        See all
                        <span class="fas fa-angle-right mr-1"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden">
                <div class="bg-holder bg-card" style="background-image:url(/assets/img/corner-1.png);"></div>

                <div class="card-body position-relative">
                    <h6 class="font-weight-bold">
                        Tagihan
                    </h6>
                    <div class="display-4 fs-5 mb-2 font-weight-normal text-warning" id="TagihanCount">
                        {{ $Tagihan }}
                    </div>
                    <a class="font-weight-bold text-nowrap fs-10" href="../app/e-commerce/customers.html">
                        See all
                        <span class="fas fa-angle-right mr-1"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row flex-between-center py-2">
                                <div class="col d-md-flex d-lg-block flex-between-center">
                                    <h6 class="mb-md-0 mb-lg-2">Saldo Kas</h6>
                                    <span class="badge rounded-pill badge-success">
                                        <span class="fas fa-caret-up"></span>
                                        61.8%
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <h4 class="fs-6 font-weight-normal text-700">
                                        $82.18M
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row flex-between-center py-2">
                                <div class="col d-md-flex d-lg-block flex-between-center">
                                    <h6 class="mb-md-0 mb-lg-2">Revenue</h6>
                                    <span class="badge rounded-pill badge-success">
                                        <span class="fas fa-caret-up"></span>
                                        61.8%
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <h4 class="fs-6 font-weight-normal text-700">
                                        $82.18M
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row flex-between-center py-2">
                                <div class="col d-md-flex d-lg-block flex-between-center">
                                    <h6 class="mb-md-0 mb-lg-2">Revenue</h6>
                                    <span class="badge rounded-pill badge-success">
                                        <span class="fas fa-caret-up"></span>
                                        61.8%
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <h4 class="fs-6 font-weight-normal text-700">
                                        $82.18M
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="main" style="width: 100%;height:314px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('script')
    <script>
        var myChart = echarts.init(document.getElementById('main'));

        // Specify the configuration items and data for the chart
        option = {
            xAxis: {
                data: ['A', 'B', 'C', 'D', 'E']
            },
            yAxis: {},
            series: [{
                    data: [10, 22, 28, 23, 19],
                    type: 'line',
                    areaStyle: {}
                },
                {
                    data: [25, 14, 23, 35, 10],
                    type: 'line',
                    areaStyle: {
                        color: '#ff0',
                        opacity: 0.5
                    }
                }
            ]
        };

        // Display the chart using the configuration items and data just specified.
        myChart.setOption(option);
    </script>

    <script>
        function dataInstallations() {
            $.ajax({
                'url': '/dashboard/installations',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    console.log(result);
                }
            })
        }

        function dataUsages() {
            $.ajax({
                'url': '/dashboard/usages',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    console.log(result);
                }
            })
        }

        function dataTagihan() {
            $.ajax({
                'url': '/dashboard/tagihan',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    console.log(result);
                }
            })
        }

        dataTagihan()
    </script>
@endsection
