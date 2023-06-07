@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title ml-3">Profile</h1>
    </div>
</div>
<!-- display all from registration -->
<div class="row justify-content-center">
    <div class="col-md-12">
        @if ($usertype->category == 'Contractor')
        <div class="card" style="padding: 20px;">
            <div class="form-row">
                <div class="col-4">
                    <img src="/assets/{{$usertype->name}}/{{$usertype->passportPhoto}}" width="200px" style="float: left">
                </div>
                <div class="col-7">
                    <h5>Contact Details</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Name</label>
                        </div>
                        <div class="col">
                            <label for="name">{{ $usertype->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->email }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Phone Number</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->phoneNo }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @elseif ($usertype->category == 'Visitor')
        <div class="card" style="padding: 20px;">
            <div class="form-row">
                <div class="col-4">
                    <img src="/assets/{{$usertype->name}}/{{$usertype->passportPhoto}}" width="200px" style="float: left">
                </div>
                <div class="col-7">
                    <h5>Contact Details</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Name</label>
                        </div>
                        <div class="col">
                            <label for="name">{{ $usertype->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->email }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Phone Number</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->phoneNo }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <div class="row justify-content-center mt-3">
            <!-- Display webcam stream -->
            <video id="videoElement" width="640" height="480" autoplay></video>
        </div>

        <div class="row justify-content-center mt-3">
            <!-- Button to capture image -->
            <button class="btn btn-primary" id="captureButton">Capture Image</button>
        </div>

        <div class="row justify-content-center mt-3">
            <!-- Canvas element to display the captured image -->
            <canvas id="canvasElement"></canvas>
        </div>
        <div class="row justify-content-center mt-3">
            <!-- Button to save  -->
            <button class="btn btn-primary" id="saveButton" disabled>Save</button>
        </div>
    </div>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/face-api.js"></script>
<script>
    // webcam.js

    navigator.mediaDevices.getUserMedia({
            video: true
        })
        .then(stream => {
            const videoElement = document.getElementById('videoElement');
            videoElement.srcObject = stream;

            const captureButton = document.getElementById('captureButton');
            const canvasElement = document.getElementById('canvasElement');
            const context = canvasElement.getContext('2d');


            // Set canvas dimensions based on video dimensions
            videoElement.addEventListener('loadedmetadata', () => {
                canvasElement.width = videoElement.videoWidth;
                canvasElement.height = videoElement.videoHeight;
            });

            captureButton.addEventListener('click', () => {
                context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

                // Convert the captured image to a data URL
                const imageData = canvasElement.toDataURL();

                // Enable the Save button
                saveButton.disabled = false;

                // Store the captured image data in a variable accessible within the save button event listener
                let capturedImageData = imageData;

                // Save button event listener
                saveButton.addEventListener('click', () => {
                    const userId = extractUserIdFromUrl(); // Replace with your logic to extract the user ID from the URL
                    function extractUserIdFromUrl() {
                        const url = window.location.pathname; // Assuming the user ID is specified in the URL path, e.g., http://example.com/users/123
                        const pathSegments = url.split('/');
                        return pathSegments[2]; // Assuming the user ID is the third segment in the path
                    }

                    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

                    // Send the captured image data to the server for processing or storing in the database
                    fetch('/save-image', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                image: capturedImageData,
                                userId: userId
                            }),
                        })
                        .then(response => {
                            if (response.ok) {
                                // Success message or further actions
                                console.log('Image saved successfully');
                            } else {
                                throw new Error('Image save failed');
                            }
                        })
                        .catch(error => {
                            // Handle errors
                            console.error(error);
                        });
                });
            });
        })
        .catch(error => {
            console.error('Error accessing webcam:', error);
        });

    
</script>