<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
    <div class="flex mt-8 mb-8 justify-center">
        <video id="previewVideoCam"></video>
    </div>
</div>

<script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('previewVideoCam') });
    scanner.addListener('scan', function (content) {
        fetch(content)
            .then(response => response.text())
            .then(html => console.log(html))
            .catch(error => console.log('Ocurrió un error:', error));

        location.reload()
    });
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
        scanner.start(cameras[0]);
        } else {
        console.error('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
    });
</script>

<div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
    <div>
        <div class="flex mt-8 mb-6 justify-center">
            <h1>{{Auth::user()->currentTeam->name}} today's retirements</h1>
        </div>
        <livewire:retirement-status />
    </div>
</div>
