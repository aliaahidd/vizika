@extends('layouts.sideNav')
@section('content')
<style>
    body>.card>.videoScan {
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
            <h1 class="page-title ml-3">Profile</h1>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body videoScan">
            <!-- Add a canvas element to display the video and overlay -->
            <video id="video" autoplay muted></video>
            <button id="checkInButton" class="btn btn-primary" style="display: none;">Check-In</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/face-landmarks-detection"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1/dist/face-api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>
<!-- Add JavaScript code -->
<script>
    const video = document.getElementById('video');
    const checkInButton = document.getElementById('checkInButton');
    // Load the face-api.js models
    Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri('/face-models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/face-models'),
            faceapi.nets.faceRecognitionNet.loadFromUri('/face-models'),
            faceapi.nets.ssdMobilenetv1.loadFromUri('/face-models'),
        ])
        .then(() => {
            console.log('Face models loaded successfully!');
            startBiometric();
        })
        .catch((error) => {
            console.error('Error loading face models:', error);
        });

    async function startBiometric() {
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
            const videoScanContainer = document.querySelector('.card-body');

            videoScanContainer.appendChild(canvas);
            videoScanContainer.appendChild(video);

            const displaySize = {
                width: video.videoWidth,
                height: video.videoHeight
            };
            faceapi.matchDimensions(canvas, displaySize);

            const labeledFaceDescriptors = await loadLabeledImages();

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

                    if (result.similarity > 0.6) {
                        checkInButton.style.display = 'block'; // Show the check-in button
                    } else {
                        checkInButton.style.display = 'none'; // Hide the check-in button
                    }
                });
            }, 100);
        });
    }

    function loadLabeledImages() {
        const labels = ['avatar'];
        return Promise.all(
            labels.map(async label => {
                const descriptions = [];
                for (let i = 1; i <= 1; i++) {
                    const img = await faceapi.fetchImage(`http://127.0.0.1:8000/assets/${label}/1685445966.png`);

                    const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                    descriptions.push(detections.descriptor);
                }

                return new faceapi.LabeledFaceDescriptors(label, descriptions);
            })
        );
    }
</script>
@endsection