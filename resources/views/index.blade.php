<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Attendance Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .about-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Main Content -->
        <main class="col-md-12 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Welcome to the Attendance Management System</h1>
            </div>

            <!-- About SEMCOM College Section -->
            <div class="row mb-4">
                <div class="col-md-12 about-section">
                    <h3>About SEMCOM College</h3>
                    <p>SEMCOM College is a premier educational institution offering a diverse range of undergraduate and postgraduate programs. With a focus on academic excellence and student well-being, SEMCOM strives to foster a learning environment that is inclusive, innovative, and forward-thinking.</p>
                </div>
            </div>

            <!-- Dashboard Cards Section -->
            <div class="row">
                <!-- Card 1 for Students -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">View Attendance</h5>
                            <p class="card-text">Check your attendance records and details.</p>
                            <a href="login" class="btn btn-primary">View Attendance</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 for Teachers -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Manage Classes</h5>
                            <p class="card-text">Update and manage attendance for your classes.</p>
                            <a href="login" class="btn btn-primary">Manage Classes</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 for Counselors -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Student Counseling</h5>
                            <p class="card-text">Access and review counseling sessions and reports.</p>
                            <a href="login" class="btn btn-primary">View Counseling</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4 for Admins -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">System Administration</h5>
                            <p class="card-text">Manage users, permissions, and settings.</p>
                            <a href="login" class="btn btn-danger">Admin Panel</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login Button Section -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="login" class="btn btn-success btn-lg">Login</a>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
