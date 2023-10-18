@extends('layouts.sideNav')
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
            <h1 class="page-title">Find Match</h1>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col videoScan">
                    <!-- Add a canvas element to display the video and overlay -->
                    <video id="video" autoplay muted></video>

                </div>
                <div class="col">
                    <a class="btn btn-success" href="#">Next</a>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- Add JavaScript code -->
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1/dist/face-api.min.js"></script>
<script>
    const video = document.getElementById('video');

    Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('/face-models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/face-models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('/face-models'),
        faceapi.nets.ssdMobilenetv1.loadFromUri('/face-models'),
    ]).then(startVideo);

    async function startVideo() {
        // Create a variable to store the detected person's label

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
            const videoScanContainer = document.querySelector('.videoScan');
            videoScanContainer.appendChild(canvas);
            videoScanContainer.appendChild(video);

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

                let detectedPersonLabel = '';

                results.forEach((result, i) => {
                    const box = resizedDetections[i].detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, {
                        label: result.toString()
                    });
                    drawBox.draw(canvas);

                    // Extract the label of the detected person
                    const detectedLabel = result.toString();

                    // Set the detected person's label to the variable
                    detectedPersonLabel = detectedLabel;

                });
                // Construct the URL dynamically and set it as the href attribute
                const nextButton = document.querySelector('.btn-success');
                const baseUrl = '/nextButton'; // Replace with your actual Laravel route URL
                const urlWithLabel = `${baseUrl}/${detectedPersonLabel}`;
                nextButton.href = urlWithLabel;
            }, 100);
        });
    }

    function loadLabeledImages() {
        return fetch('/fetch-data-label')
            .then(response => response.json())
            .then(data => {
                // Extract row names and update the labels array
                const labelsAndImages = data.map(item => ({
                    label: item.name,
                    imageFilename: item.facialRecognition
                }));
                // Now, you can use the 'labelsAndImages' array as needed
                console.log(labelsAndImages);

                // Perform face detection and descriptor extraction on each image
                return Promise.all(
                    labelsAndImages.map(async ({
                        label,
                        imageFilename
                    }) => {
                        const img = await faceapi.fetchImage(`https://vizika.online/assets/${label}/${imageFilename}`);
                        const descriptions = [];

                        // Perform face detection and descriptor extraction on 'img' here
                        const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                        descriptions.push(detections.descriptor);

                        return new faceapi.LabeledFaceDescriptors(label, descriptions);
                    })
                );
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
</script>
@endsection