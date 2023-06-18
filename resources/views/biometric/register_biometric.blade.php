@extends('layouts.app')
<a class="text-danger" href="javascript:history.go(-1)" style="display: block; padding: 10px">
    <i class="material-icons text-danger">&#xE879;</i> Back </a>
@section('content')

<div class="container">
    <ul class="steps">
        <li class="step step--complete step--inactive">
            <span class="step__icon"></span>
            <span class="step__label">Step 1: User details</span>
        </li>
        <li class="step step--incomplete step--active">
            <span class="step__icon"></span>
            <span class="step__label">Step 2: Capture Picture</span>
        </li>
        <li class="step step--incomplete step--inactive">
            <span class="step__icon"></span>
            <span class="step__label">Step 3: Finish</span>
        </li>
    </ul>
    <br>

    <div class="card">
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

                                window.location.href = '/finish-form';

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

<style>
    @import "color-schemer";

    /* Mixins */
    /* Color Variables */
    /* Theme Variables */
    /* Animations */
    @keyframes bounce {
        0% {
            transform: scale(1);
        }

        33% {
            transform: scale(0.9);
        }

        66% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }


    /* Component Styles - Steps */
    .steps {
        display: flex;
        width: 100%;
        margin: 0;
        padding: 0 0 2rem 0;
        list-style: none;
        justify-content: space-between;
    }

    .step {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        flex: 1;
        position: relative;
        pointer-events: none;
        text-align: center;
    }

    .step--active,
    .step--complete {
        cursor: pointer;
        pointer-events: all;
    }

    .step:not(:last-child):before,
    .step:not(:last-child):after {
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        height: 0.25rem;
        content: '';
        transform: translateY(-50%);
        will-change: width;
        z-index: -1;
    }

    .step:before {
        width: 100%;
        background-color: #b6b8ba;
    }

    .step:after {
        width: 0;
        background-color: #007bff;
    }

    .step--complete:after {
        width: 100% !important;
        opacity: 1;
        transition: width 0.6s ease-in-out, opacity 0.6s ease-in-out;
    }

    .step__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        width: 3rem;
        height: 3rem;
        background-color: #292627;
        border: 0.25rem solid #b6b8ba;
        border-radius: 50%;
        color: transparent;
        font-size: 2rem;
    }

    .step__icon:before {
        display: block;
        color: #fff;
        content: '\2713';
    }

    .step--complete.step--active .step__icon {
        color: #fff;
        transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    .step--incomplete.step--active .step__icon {
        border-color: #007bff;
        transition-delay: 0.5s;
    }

    .step--complete .step__icon {
        animation: bounce 0.5s ease-in-out;
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .step__label {
        position: absolute;
        bottom: -2rem;
        left: 50%;
        margin-top: 1rem;
        font-size: 0.8rem;
        text-transform: uppercase;
        transform: translateX(-50%);
    }

    @media (max-width: 768px) {
        .step__label {
            bottom: -4rem;
        }

        .card {
            margin-top: 20px;
        }
    }

    .step--incomplete.step--inactive .step__label {
        color: #b6b8ba;
    }

    .step--incomplete.step--active .step__label {
        color: #000;
    }

    .step--active .step__label {
        transition: color 0.3s ease-in-out;
        transition-delay: 0.5s;
    }
</style>