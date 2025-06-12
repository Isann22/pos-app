<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Uang Rupiah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .method-card {
            transition: all 0.3s;
            cursor: pointer;
            height: 100%;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .method-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .method-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        #cameraContainer {
            position: relative;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        #cameraPreview {
            width: 100%;
            background: #f8f9fa;
            display: block;
        }

        #captureBtn {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .hidden-section {
            display: none;
        }

        .result-img {
            max-height: 300px;
            object-fit: contain;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-area:hover {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

        #preview {
            max-width: 100%;
            border-radius: 8px;
            display: none;
            margin: 1rem auto;
        }

        #result {
            padding: 1rem;
            border-radius: 8px;
            background-color: #f8f9fa;
            margin-top: 1rem;
        }

        .loading {
            color: #6c757d;
            font-style: italic;
        }

        .error {
            color: #dc3545;
        }

        .success {
            color: #198754;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-primary">Deteksi Uang Rupiah</h1>
                    <p class="lead text-muted">Pilih metode deteksi yang Anda inginkan</p>
                </div>

                <!-- Method Selection -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card method-card p-4" onclick="showSection('cameraSection')">
                            <div class="card-body text-center py-4">
                                <div class="method-icon">
                                    <i class="bi bi-camera-video-fill"></i>
                                </div>
                                <h3 class="card-title">Deteksi Kamera</h3>
                                <p class="card-text text-muted">Gunakan kamera perangkat untuk deteksi langsung</p>
                                <span class="badge bg-primary">Live</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card method-card p-4" onclick="showSection('uploadSection')">
                            <div class="card-body text-center py-4">
                                <div class="method-icon">
                                    <i class="bi bi-upload"></i>
                                </div>
                                <h3 class="card-title">Upload Gambar</h3>
                                <p class="card-text text-muted">Upload gambar uang untuk diperiksa</p>
                                <span class="badge bg-success">Offline</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Camera Section -->
                <div id="cameraSection" class="hidden-section">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="bi bi-camera-video me-2"></i>Deteksi dengan Kamera</h4>
                        </div>
                        <div class="card-body">
                            <div id="cameraContainer">
                                <video id="cameraPreview" autoplay playsinline></video>
                                <button id="captureBtn" class="btn btn-danger btn-lg rounded-circle">
                                    <i class="bi bi-camera-fill"></i>
                                </button>
                            </div>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button id="startCameraBtn" class="btn btn-primary px-4">
                                    <i class="bi bi-camera-video me-2"></i> Hidupkan Kamera
                                </button>
                                <button id="stopCameraBtn" class="btn btn-secondary px-4" disabled>
                                    <i class="bi bi-camera-video-off me-2"></i> Matikan Kamera
                                </button>
                                <a href="{{ route('deteksi') }}" class="btn btn-success px-4">
                                    <i class="bi bi-arrow-right me-2"></i> Lanjutkan ke Deteksi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Section -->
                <div id="uploadSection" class="hidden-section">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="bi bi-upload me-2"></i>Upload Gambar</h4>
                        </div>
                        <div class="card-body">
                            <div class="upload-area" onclick="document.getElementById('imageInput').click()">
                                <i class="bi bi-cloud-arrow-up" style="font-size: 2.5rem; color: #0d6efd;"></i>
                                <h5 class="mt-3">Seret dan lepas gambar di sini</h5>
                                <p class="text-muted">atau klik untuk memilih file</p>
                                <small class="text-muted">Format yang didukung: JPG, PNG</small>
                            </div>

                            <input type="file" id="imageInput" accept="image/*" class="d-none" required>

                            <div class="text-center">
                                <img id="preview" src="#" alt="Preview Gambar" class="img-fluid">
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button onclick="predictImage()" id="predictBtn" class="btn btn-primary btn-lg">
                                    <i class="bi bi-search me-2"></i> Deteksi Keaslian
                                </button>
                            </div>

                            <div id="result" class="mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle between sections
        function showSection(sectionId) {
            document.querySelectorAll('.hidden-section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';

            // Stop camera if switching away from camera section
            if (sectionId !== 'cameraSection') {
                stopCamera();
            }
        }

        // Image prediction functionality
        async function predictImage() {
            const input = document.getElementById('imageInput');
            const resultDiv = document.getElementById('result');
            const preview = document.getElementById('preview');
            const predictBtn = document.getElementById('predictBtn');

            const file = input.files[0];

            if (!file) {
                alert('Silakan pilih gambar terlebih dahulu');
                return;
            }

            // Show image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);

            // Show loading state
            resultDiv.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="loading mt-2">Memproses gambar...</p>
                </div>
            `;

            predictBtn.disabled = true;
            predictBtn.innerHTML = '<i class="bi bi-hourglass me-2"></i> Memproses...';

            try {
                const formData = new FormData();
                formData.append('file', file);

                // Send request to Flask API
                const response = await fetch('http://localhost:5000/predict', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || 'Terjadi kesalahan pada server');
                }

                const data = await response.json();
                displayResults(data);

            } catch (error) {
                console.error('Error:', error);
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Terjadi Kesalahan</h5>
                        <p>${error.message}</p>
                    </div>
                `;
            } finally {
                predictBtn.disabled = false;
                predictBtn.innerHTML = '<i class="bi bi-search me-2"></i> Deteksi Keaslian';
            }
        }

        function displayResults(data) {
            const resultDiv = document.getElementById('result');

            if (data.error) {
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <p>${data.error}</p>
                    </div>
                `;
                return;
            }

            // Determine badge color based on prediction
            const badgeColor = data.prediction.toLowerCase().includes('asli') ? 'success' : 'danger';

            let html = `
                <div class="alert alert-${badgeColor}">
                    <h4 class="alert-heading">Hasil Deteksi</h4>
                    <hr>
                    <p><strong>Prediksi:</strong> <span class="badge bg-${badgeColor}">${data.prediction}</span></p>
            `;

            if (data.confidence !== null && data.confidence !== undefined) {
                html += `
                    <p><strong>Tingkat Kepercayaan:</strong> 
                        <div class="progress mt-2">
                            <div class="progress-bar bg-${badgeColor}" 
                                 role="progressbar" 
                                 style="width: ${data.confidence * 100}%" 
                                 aria-valuenow="${data.confidence * 100}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                ${(data.confidence * 100).toFixed(2)}%
                            </div>
                        </div>
                    </p>
                `;
            }

            html += `</div>`;

            resultDiv.innerHTML = html;
        }

        // Camera functionality
        const cameraPreview = document.getElementById('cameraPreview');
        const startCameraBtn = document.getElementById('startCameraBtn');
        const stopCameraBtn = document.getElementById('stopCameraBtn');
        const captureBtn = document.getElementById('captureBtn');
        let stream = null;

        // Start camera
        startCameraBtn.addEventListener('click', async () => {
            try {
                startCameraBtn.innerHTML = '<i class="bi bi-hourglass me-2"></i> Membuka Kamera...';
                startCameraBtn.disabled = true;

                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment',
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        }
                    },
                    audio: false
                });

                cameraPreview.srcObject = stream;
                startCameraBtn.style.display = 'none';
                stopCameraBtn.disabled = false;
                captureBtn.style.display = 'block';

            } catch (err) {
                console.error("Error accessing camera: ", err);
                startCameraBtn.innerHTML = '<i class="bi bi-camera-video me-2"></i> Hidupkan Kamera';
                startCameraBtn.disabled = false;

                alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin.");
            }
        });

        // Stop camera
        stopCameraBtn.addEventListener('click', stopCamera);

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                cameraPreview.srcObject = null;
                startCameraBtn.style.display = 'block';
                startCameraBtn.disabled = false;
                startCameraBtn.innerHTML = '<i class="bi bi-camera-video me-2"></i> Hidupkan Kamera';
                stopCameraBtn.disabled = true;
                captureBtn.style.display = 'none';
            }
        }

        // Capture image
        captureBtn.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = cameraPreview.videoWidth;
            canvas.height = cameraPreview.videoHeight;
            canvas.getContext('2d').drawImage(cameraPreview, 0, 0);

            // You can save or process the captured image here
            const imageData = canvas.toDataURL('image/jpeg');

            // For now, just show an alert
            alert("Gambar berhasil diambil! Silakan lanjutkan ke deteksi.");

            // In a real app, you would send this imageData to your backend
            // Example: sendImageForDetection(imageData);
        });

        // Clean up camera when leaving page
        window.addEventListener('beforeunload', stopCamera);
    </script>
</body>

</html>
