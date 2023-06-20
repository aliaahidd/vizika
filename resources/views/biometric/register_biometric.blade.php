@extends('layouts.app')
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
            <div class="row justify-content-start">
                <p>Instructions</p><br>
            </div>
            <div class="row justify-content-start mt-1">
                <h7>1. Find a well-lit area for capturing the photo.</h7>
                <h7>2. Position yourself facing a natural light source, such as a window, or utilize artificial lighting to ensure sufficient illumination.</h7>
                <h7>3. Avoid strong backlighting or shadows on your face.</h7>
                <h7>4. Maintain a comfortable distance from the camera, allowing your face to fill the frame adequately.</h7>
                <h7>5. Avoid extreme close-ups or being too far away, ensuring your facial features are clearly visible.</h7>
                <h7>6. Remove any objects, accessories, or items that may obstruct your face. (Hats, sunglasses, or hair covering significant parts of your face).</h7>
            </div>
            <div class="row justify-content-center mt-3">
                <!-- Display webcam stream -->
                <video id="videoElement" width="640" height="480" autoplay></video>
                <div id="guideOverlay"></div> <!-- Guide overlay -->
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
            const guideOverlay = document.getElementById('guideOverlay');

            // Set canvas dimensions based on video dimensions
            videoElement.addEventListener('loadedmetadata', () => {
                canvasElement.width = videoElement.videoWidth;
                canvasElement.height = videoElement.videoHeight;

                // Set guide overlay position
                const videoRect = videoElement.getBoundingClientRect();
                const videoWidth = videoRect.width;
                const videoHeight = videoRect.height;
                const guideSize = 1750; // Size of the guide overlay
                const guideSizeL = 1400; // Size of the guide overlay
                const guideLeft = (guideSize - videoWidth) / 2;
                const guideTop = (guideSizeL - videoHeight) / 2;
                guideOverlay.style.left = `${guideLeft}px`;
                guideOverlay.style.top = `${guideTop}px`;
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
    #videoContainer {
        position: relative;
    }

    #guideOverlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 200px;
        border: 2px solid red;
        pointer-events: none;
        /* Make the overlay non-interactable */
    }


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
    }

    .step {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        flex: 1;
        position: relative;
        pointer-events: none;
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