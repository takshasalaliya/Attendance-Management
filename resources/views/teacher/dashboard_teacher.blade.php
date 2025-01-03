@extends('teacher/layout_teacher')
@section('title','Teacher Dashboard')
@section('dashboard')

               <!-- Main Content -->
            <main class="col-md ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Welcome, Teacher</h1>
                </div>

                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Manage Attendance</h5>
                                <p class="card-text">Track and manage attendance records for your students.</p>
                                <a href="/select" class="btn btn-primary">Go to Attendance</a>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Card 2 -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Generate Reports</h5>
                                <p class="card-text">Create detailed reports for analysis and review.</p>
                                <a href="/attendent_list" class="btn btn-primary">View Reports</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection