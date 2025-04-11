@extends('layouts.base')

@section('content')
    <div class="modal fade" id="scanQrCode" tabindex="-1" role="dialog" aria-labelledby="scanQrCodeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="height: 100vh;">
            <div class="modal-content" style="height: 60%;">
                <div class="modal-header">
                    <h5 class="modal-title">Scan QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="scanQrCodeClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="reader" style="width: 100%"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="stopScan" class="btn btn-warning">Stop</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var startScan, scanningEnabled = true;
        var html5QrcodeScanner;

        $(document).ready(function() {
            scanningEnabled = true
            $('#scanQrCode').modal('show')

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

                    if (result.length >= 10) {
                        Swal.fire('Error',
                            'Sepertinya kartu angsuran yang anda punya bukan yang terbaru. Silahkan cetak ulang kartu angsuran anda',
                            'error')
                        $('#html5-qrcode-button-camera-stop').trigger('click')
                        $('#stopScan').html('Scan Ulang')
                    } else {
                        window.location.href = '/usages/barcode' + result
                    }

                    scanningEnabled = false
                }
            });

            $('#html5-qrcode-button-camera-start').hide()
            $('#html5-qrcode-button-camera-stop').hide()
            $('#html5-qrcode-anchor-scan-type-change').hide()

            $('#html5-qrcode-button-camera-start').trigger('click')

            startScan = true
            $('#stopScan').html('Stop')
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
    </script>
@endsection
