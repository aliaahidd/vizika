@extends('layouts.app')
@section('content')
<style>
    body {
      margin: 0;
      padding: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column
    }

    canvas {
      position: absolute;
    }
  </style>
<body>
    <!-- Page Header -->
    <div class="page-header row no-gutters pb-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
            <h1 class="page-title">Biometric</h1>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <!-- Add a canvas element to display the video and overlay -->
            <video id="video" autoplay muted></video>
        </div>
    </div>

</body>
<!-- Add JavaScript code -->
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1/dist/face-api.min.js"></script>
<script>
    const video = document.getElementById('video');

    Promise.all([
        faceapi.nets.faceRecognitionNet.loadFromUri('/face-models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/face-models'),
        faceapi.nets.ssdMobilenetv1.loadFromUri('/face-models')
    ]).then(startVideo);

    async function startVideo() {
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                console.error('Error accessing webcam:', error);
            });

        video.addEventListener('play', async () => {
            const canvas = faceapi.createCanvasFromMedia(video);
            document.body.append(canvas);
            document.body.append(video);

            // Set the canvas size to match the video's dimensions
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const displaySize = {
                width: video.videoWidth,
                height: video.videoHeight
            };
            faceapi.matchDimensions(canvas, displaySize);

            const labeledFaceDescriptors = await loadLabeledImages();
            const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6);

            setInterval(async () => {
                const detections = await faceapi.detectAllFaces(video)
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

                faceapi.draw.drawDetections(canvas, resizedDetections);
                faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

                const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

                results.forEach((result, i) => {
                    const box = resizedDetections[i].detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, {
                        label: result.toString()
                    });
                    drawBox.draw(canvas);


                });
            }, 100);
        });
    }

    function loadLabeledImages() {
        const labels = ['avatar']
        return Promise.all(
            labels.map(async label => {
                const descriptions = []
                for (let i = 1; i <= 1; i++) {
                    const img = await faceapi.fetchImage(`http://127.0.0.1:8000/assets/${label}/1685445966.png`);

                    const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                    descriptions.push(detections.descriptor)
                }

                return new faceapi.LabeledFaceDescriptors(label, descriptions)
            })
        )
    }
</script>
@endsection