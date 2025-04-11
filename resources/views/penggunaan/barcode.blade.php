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
                {{-- <button type="button" id="stopScan" class="btn btn-warning">Stop</button> --}}
                <a href="create" type="button" class="btn btn-secondary">Tutup</a>
            </div>
        </div>
    </div>
</div>
