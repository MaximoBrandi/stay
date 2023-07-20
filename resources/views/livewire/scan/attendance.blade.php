<div>
    <div>
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div id="pistachazo">
                <div id="reader" ></div>
            </div>
        </div>

        <script type="text/javascript">
            function onScanSuccess(decodedText, decodedResult) {
                fetch(decodedText)
                    .then(response => response.text())
                    .then(html => console.log(html))
                    .catch(error => console.log('Ocurrió un error:', error));

                location.reload()
            }

            function onScanFailure(error) {

            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 720, height: 720} },
            /* verbose= */ false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        </script>
    </div>

    <livewire:scan.recent-scans />
</div>
