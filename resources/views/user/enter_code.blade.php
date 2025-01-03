<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>User Details</h4>
                    </div>
                    <div class="card-body">
                        <!-- Display messages -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- User Information -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Roll Number:</label>
                            <p class="form-control-plaintext">{{$data->enrollment_number}}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name:</label>
                            <p class="form-control-plaintext">{{$data->name}}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Class/Semester:</label>
                            <p class="form-control-plaintext">{{ $data->class->program->name.'/'.$data->class->sem }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Batch:</label>
                            @php
                            $year=explode('/',$data->class->year);
                            $year1=explode('-',$year[0]);
                            $year2=explode('-',$year[1]);
                            @endphp
                            <p class="form-control-plaintext">{{ $year1[0].'/'.$year2[0] }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Division:</label>
                            <p class="form-control-plaintext">{{ $data->class->devision }}</p>
                        </div>

                        <!-- Form -->
                        <form action="code_enter" method="get">
                            <div class="mb-3">
                                <label for="code" class="form-label">Enter Code</label>
                                <input type="number" class="form-control" name="code" id="code" placeholder="Enter your code" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a href="/logout" class="btn btn-outline-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
