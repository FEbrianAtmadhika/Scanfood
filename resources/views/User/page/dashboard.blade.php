@extends('User.layout.app')

@section('title', 'Dashboard')

@section('main_content')
<div class="card m-5 h-100 p-5 d-flex justify-content-center align-items-center">
    <h2>Confirm Upload</h2>

    <img src="{{ asset("images/1/006498.jpg") }}" alt="" id="image">

    <button type="button" id="confirm-button" class="btn btn-primary mt-3">Confirm</button>

    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go Back</a>

    <!-- Container for displaying detection results -->
    <ul id="detection-results" class="list-group mt-3"></ul>

    <!-- Canvas for displaying the predicted image -->
    <canvas id="canvas" width="640" height="640" style="border:1px solid #000000;"></canvas>

    <!-- Hidden form for submitting results -->
    <form id="result-form" method="POST" action="{{ route('deteksi') }}" style="display: none;">
        @csrf
        <input type="hidden" name="image" id="hidden-image">
        <input type="hidden" name="results" id="hidden-results">
        <button type="submit" class="btn btn-primary mt-3">Submit Results</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.9.0/dist/tf.min.js"></script>
<script>
const modelUrl = '{{ asset("train8/weights/best_web_model/model.json") }}';
const metadataUrl = '{{ asset("train8/weights/best_web_model/metadata.yaml") }}';
const weightBaseUrl = '{{ asset("train8/weights/best_web_model/") }}';

async function loadModel() {
    const model = await tf.loadGraphModel(modelUrl);
    return model;
}

// Function to detect objects in an image
async function detectObjects(imageElement) {
    const model = await loadModel();
    const tensor = tf.browser.fromPixels(imageElement)
        .resizeBilinear([640, 640]) // Resize the image to the expected shape
        .expandDims(0) // Add a batch dimension
        .toFloat()
        .div(tf.scalar(255.0)); // Normalize the image to [0, 1]

    const predictedTensor = model.predict(tensor);

    // Check the shape of the predicted tensor
    console.log('Predicted Tensor Shape:', predictedTensor.shape);

    const predictedArray = predictedTensor.dataSync();

    // Convert tensor values to image data
    const width = 640;
    const height = 640;
    const imageData = new ImageData(width, height);
    for (let i = 0; i < predictedArray.length; i++) {
        const value = predictedArray[i] * 255; // Assuming the output is normalized between 0 and 1
        imageData.data[i * 4] = value;       // R
        imageData.data[i * 4 + 1] = value;   // G
        imageData.data[i * 4 + 2] = value;   // B
        imageData.data[i * 4 + 3] = 255;     // A (opacity)
    }

    // Get the canvas context and draw the image
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    ctx.putImageData(imageData, 0, 0);

    // For object detection results, we need to handle the predictions
    const numAnchors = predictedTensor.shape[1];
    const numClasses = predictedTensor.shape[2] - 5;
    const boxes = [];
    const scores = [];
    const classes = [];

    for (let i = 0; i < numAnchors; i++) {
        const xy = predictedTensor.slice([0, i, 0], [1, 1, 2]);
        const wh = predictedTensor.slice([0, i, 2], [1, 1, 2]);
        const objectness = predictedTensor.slice([0, i, 4], [1, 1, 1]);
        const classScores = predictedTensor.slice([0, i, 5], [1, 1, numClasses]);

        // Convert the coordinates and wh to [x1, y1, x2, y2] format
        const x1y1 = xy.sub(wh.div(2));
        const x2y2 = xy.add(wh.div(2));

        // Calculate the score for the anchor box
        const score = objectness.mul(tf.max(classScores));

        // Find the class with the highest score
        const classId = tf.argMax(classScores, 2).dataSync()[0];

        // Add the box, score, and class to the arrays
        boxes.push(x1y1.dataSync());
        boxes.push(x2y2.dataSync());
        scores.push(score.dataSync());
        classes.push(classId);
    }

    return {
        boxes: boxes,
        scores: scores,
        classes: classes
    };
}

// Function to display detection results
function displayResults(detectionResults) {
    const resultsContainer = document.getElementById('detection-results');
    resultsContainer.innerHTML = '';

    detectionResults.boxes.forEach((box, index) => {
        const score = detectionResults.scores[index];
        const classId = detectionResults.classes[index];

        const resultItem = document.createElement('li');
        resultItem.classList.add('list-group-item');
        resultItem.textContent = `Class: ${classId}, Score: ${score.toFixed(2)}, Box: ${box.join(', ')}`;
        resultsContainer.appendChild(resultItem);
    });
}

// Function to create and show the result form
function createResultForm(imageDataUrl, detectionResults) {
    const resultForm = document.getElementById('result-form');
    const hiddenImage = document.getElementById('hidden-image');
    const hiddenResults = document.getElementById('hidden-results');

    hiddenImage.value = imageDataUrl;
    hiddenResults.value = JSON.stringify(detectionResults);

    resultForm.style.display = 'block';
}

// Event listener for confirm button
document.getElementById('confirm-button').addEventListener('click', async function() {
    const fileInput = document.getElementById('file');

    const file = fileInput.files[0];
    console.log(file);
});
</script>


@endsection
