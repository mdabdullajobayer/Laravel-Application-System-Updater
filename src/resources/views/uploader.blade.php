<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Updater</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 2rem;
        }

        .progress {
            height: 30px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-success fw-bold">System Updater</h1>

        <!-- Success Message -->
        <div class="alert alert-success d-none">
            <p id="successMessage"></p>
        </div>

        <!-- Error Message -->
        <div class="alert alert-danger d-none">
            <p id="errorMessage"></p>
        </div>

        <!-- Update Form -->
        <form id="updateForm" action="{{ url('/system-updater') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="update_file" class="form-label">Upload Update File (ZIP):</label>
                <input type="file" class="form-control" name="update_file" id="update_file" required>
            </div>
            <button type="submit" class="btn btn-primary">Run Update</button>
        </form>

        <!-- Progress Bar -->
        <div id="progressContainer" class="mt-4" style="display: none;">
            <label>Update Progress:</label>
            <div class="progress">
                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    style="width: 0%;">0%</div>
            </div>
        </div>


        {{-- Requirment js --}}
        <div class="section mt-5">
            <h6 class="section-title">1. File Upload & Extraction</h6>
            <ul>
                <li>Upload a <code>.zip</code> file with updates.</li>
                <li>Extract files to the correct directories in the Laravel application.</li>
                <li>Replace existing files and add new ones.</li>
            </ul>
        </div>

        <div class="section">
            <h6 class="section-title">2. Database Update</h6>
            <ul>
                <li>Make sure <code>database/update-schema.sql</code> database is present.</li>
                <li>Execute custom SQL queries if provided in the zip.</li>
            </ul>
        </div>

        <div class="section">
            <h6 class="section-title">3. Logging</h6>
            <ul>
                <li>Log all update actions (successes, errors, changes).</li>
            </ul>
        </div>

        <div class="section">
            <h6 class="section-title">4. Version Control</h6>
            <ul>
                <li>Track the current application version and compare with the zip's version.</li>
                <li>Ensure compatibility between the current app version and updates.</li>
            </ul>
        </div>

        <div class="section">
            <h6 class="section-title">5. Security & Permissions</h6>
            <ul>
                <li>Validate uploaded zip files for authenticity.</li>
                <li>Ensure proper file permissions for security.</li>
            </ul>
        </div>

        <p class="copyright text-center mt-5">Copyright &copy; {{ date('Y') }} Developer <a
                href="https://github.com/mdabdullajobayer">Md
                Abdulla Jobayer.</a> All rights reserved.</p>
    </div>

    <!-- Include Bootstrap Bundle JS (for interactive elements) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.getElementById('updateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const progressBar = document.getElementById('progressBar');
            const progressContainer = document.getElementById('progressContainer');
            const success = document.querySelector('.alert-success');
            const error = document.querySelector('.alert-danger');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            progressContainer.style.display = 'block'; // Show the progress bar

            // Simulate progress for demonstration purposes
            let progress = 0;
            const interval = setInterval(() => {
                if (progress >= 100) {
                    clearInterval(interval);
                } else {
                    progress += 10; // Increase progress
                    progressBar.style.width = progress + '%';
                    progressBar.textContent = progress + '%';
                }
            }, 300);

            // Uncomment for actual AJAX file upload
            fetch("{{ url('/system-updater') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        success.classList.remove('d-none');
                        success.textContent = data.message;
                        clearInterval(interval);
                        progressBar.style.width = '100%';
                        progressBar.textContent = '100%';
                    } else {
                        error.classList.remove('d-none');
                        error.textContent = data.message;
                        clearInterval(interval);
                        progressBar.style.width = '0%';
                        progressBar.textContent = '0%';
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    error.classList.remove('d-none');
                    error.textContent = 'An error occurred during the update. Please try again.';
                    clearInterval(interval);
                    progressBar.style.width = '0%';
                    progressBar.textContent = '0%';
                });
        });
    </script>
</body>

</html>
