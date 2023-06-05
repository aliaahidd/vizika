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
            <div id="userInfo" style="display: none;">
                <h4>User Information:</h4>
                <p id="name"></p>
                <p id="email"></p>
            </div>
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

            const labeledFaceDescriptors = await loadLabeledImages(userID);
            const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.4); // Adjust the threshold as needed

            setInterval(async () => {
                const detections = await faceapi.detectAllFaces(video)
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

                faceapi.draw.drawDetections(canvas, resizedDetections);
                faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

                const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

                results.forEach(async (result, i) => {
                    const box = resizedDetections[i].detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, {
                        label: result.toString()
                    });
                    drawBox.draw(canvas);

                    if (result.similarity >= 0.3) {
                        console.log('Images matched');

                        checkInButton.style.display = 'block'; // Show the check-in button

                        const name = result.label;
                        const userInformation = await getUserInformation(name);

                        if (userInformation) {
                            document.getElementById('name').textContent = `Name: ${userInformation.name}`;
                            document.getElementById('email').textContent = `Email: ${userInformation.email}`;
                            document.getElementById('userInfo').style.display = 'block'; // Show the user information
                        } else {
                            document.getElementById('userInfo').style.display = 'none'; // Hide the user information
                        }
                    } else if (result.similarity < 0.3) {
                        console.log('Images not matched');

                        checkInButton.style.display = 'none'; // Hide the check-in button
                        document.getElementById('userInfo').style.display = 'none'; // Hide the user information
                    } else {
                        console.log('Cannot read the similarity');
                    }
                });
            }, 100);
        });
    }

    const userID = <?php echo json_encode($userID); ?>;

    function loadLabeledImages(userID) {
        return axios
            .get(`/getPhoto/${userID}`)
            .then(response => {
                const descriptions = [];
                const passportImgURL = response.data.passportPhoto; // Assuming the response contains the URL of the passport photo
                const facialRecognitionImgURL = response.data.facialRecognition; // Assuming the response contains the URL of the facial recognition photo
                const name = response.data.name;

                console.log('userID:', userID);
                console.log('name:', name);
                console.log('passportImgURL:', passportImgURL);
                console.log('facialRecognitionImgURL:', facialRecognitionImgURL);

                const encodedName = encodeURIComponent(name);
                const passportImageURL = `http://127.0.0.1:8000/assets/${encodedName}/${passportImgURL}`;
                const facialRecognitionImageURL = `http://127.0.0.1:8000/assets/${encodedName}/${facialRecognitionImgURL}`;

                console.log('passportImageURL:', passportImageURL);
                console.log('facialRecognitionImageURL:', facialRecognitionImageURL);

                const loadPassportImg = faceapi.fetchImage(passportImageURL)
                    .then(img => faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor())
                    .then(detections => {
                        descriptions.push(detections.descriptor);
                    });

                const loadFacialRecognitionImg = faceapi.fetchImage(facialRecognitionImageURL)
                    .then(img => faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor())
                    .then(detections => {
                        descriptions.push(detections.descriptor);
                    });

                return Promise.all([loadPassportImg, loadFacialRecognitionImg])
                    .then(() => {
                        return new faceapi.LabeledFaceDescriptors(name, descriptions);
                    });
            })
            .catch(error => {
                console.error('Error fetching labeled images:', error);
                return null;
            });
    }
</script>
@endsection