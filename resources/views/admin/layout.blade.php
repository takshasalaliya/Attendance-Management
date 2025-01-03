    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>@yield('title')</title>  
    </head>
    <body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="/admin" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#field" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-box"></i> <span class="ms-1 d-none d-sm-inline">Field</span></a>
                            <ul class="collapse nav flex-column ms-1" id="field" data-bs-parent="#menu">
                            <li class="w-100">
                                    <a href="/field" class="nav-link px-0 bi bi-file-plus-fill"> <span class="d-none d-sm-inline">Add</span></a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                        <a href="#teacher" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Teacher</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="teacher" data-bs-parent="#menu">
                            <li class="w-100">
                                    <a href="/add_teacher" class="nav-link px-0 bi bi-file-plus-fill"> <span class="d-none d-sm-inline">Add</span></a>
                                </li>
                                <li>
                                    <a href="/teacher_list" class="nav-link px-0 bi bi-eye-fill"> <span class="d-none d-sm-inline">View</span></a>
                                </li>
                                
                            </ul>

                        </li>

                        <li>
                            <a href="#class" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-hospital"></i> <span class="ms-1 d-none d-sm-inline">Class</span></a>
                            <ul class="collapse nav flex-column ms-1" id="class" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="add_class" class="nav-link px-0 bi bi-file-plus-fill"> <span class="d-none d-sm-inline">Add</span></a>
                                </li>
                                <li>
                                    <a href="/class_list" class="nav-link px-0 bi bi-eye-fill"> <span class="d-none d-sm-inline">View</span></a>
                                </li>
                            </ul>
                        </li>

                      
                    
                        <li>
                            <a href="#student" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Student</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="student" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="add_student_admin" class="nav-link px-0 bi bi-file-plus-fill"> <span class="d-none d-sm-inline">Add</span> </a>
                                </li>
                                <li>
                                    <a href="/student_list_admin" class="nav-link px-0 bi bi-eye-fill"> <span class="d-none d-sm-inline">View</span></a>
                                </li>
                                
                            </ul>
                        </li>
                        
                        
                        <li>
                            <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Subject</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="/add_subject_admin" class="nav-link px-0 bi bi-file-plus-fill"> <span class="d-none d-sm-inline">Add</span></a>
                                </li>
                                <li>
                                    <a href="subject_list_admin" class="nav-link px-0 bi bi-eye-fill"> <span class="d-none d-sm-inline">View</span> </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#submenu4" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-box"></i> <span class="ms-1 d-none d-sm-inline">Subject And Teacher Maping</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu4" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="/subjectallocated_admin" class="nav-link px-0 bi bi-file-plus-fill"> <span class="d-none d-sm-inline">Add</span></a>
                                </li>
                                <li>
                                    <a href="/list_teachingstaff_admin" class="nav-link px-0 bi bi-eye-fill"> <span class="d-none d-sm-inline">View</span> </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#submenu5" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="bi bi-option"></i> <span class="ms-1 d-none d-sm-inline">Student and Subject Maping</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu5" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="/optionalgroup_admin" class="nav-link px-0 bi bi-file-plus-fill"> <span class="d-none d-sm-inline">Add</span></a>
                                </li>
                                <li>
                                    <a href="optionallist_admin" class="nav-link px-0 bi bi-eye-fill"> <span class="d-none d-sm-inline">View</span> </a>
                                </li>
                            </ul>
                        </li>
                        
                    
                        <li>
                            <a href="/logout" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi bi-box-arrow-left "></i> <span class="ms-1 d-none d-sm-inline">Logout</span> </a>
                        </li>
                    </ul>
                    <hr>
                    
                </div>
            </div>
            <div class="col py-3">

        
            @section('add_teacher')
            @show
            @section('teacher')
            @show
            @section('edit_teacher')
            @show
            @section('dashboard')
            @show
            @section('add_class')
            @show
            @section('edit_class')
            @show
            @section('add_field')
            @show
            @section('addsubject')
            @show
            @section('subject_table')
            @show
            @section('teachingstaff')
            @show
            @section('editteachingstaff')
            @show
            @section('optional_subject')
            @show
            @section('optional_subject_list')
            @show
            @section('add_form')
            @show
            @section('student_table')
            @show
            @section('edit_form')
            @show
            @section('add_class')
            @show   
            @section('class_list')
            @show
            @section('edit_class')
            @show
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap Icons (Optional for icons) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    </body>
    </html>