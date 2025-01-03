@extends('admin/layout')
@section('title','Dashboard')
@section('dashboard')


    <style>
        .info-box {
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .info-box i {
            font-size: 30px;
            margin-bottom: 10px;
        }
    </style>

<body>
    <div class="container mt-5">
        <div class="row g-3">
            <!-- Box 1 -->
            <div class="col-md-3">
                <div class="info-box" style="background-color: #7A3B8E;">
                    <i class="bi bi-person-lines-fill"></i>
                    <h2>{{$students}}</h2>
                    <p>STUDENTS</p>
                </div>
            </div>
            <!-- Box 2 -->
            <div class="col-md-3">
                <div class="info-box" style="background-color: #E74C3C;">
                    <i class="bi bi-people"></i>
                    <h2>{{$teachers}}</h2>
                    <p>TEACHER</p>
                </div>
            </div>
            <!-- Box 3 -->
            <div class="col-md-3">
                <div class="info-box" style="background-color: #17A589;">
                    <i class="bi bi-book"></i>
                    <h2>{{$counselors}} </h2>
                    <p>COUNCELOR</p>
                </div>
            </div>
            <!-- Box 4 -->
            <div class="col-md-3">
                <div class="info-box" style="background-color: #2980B9;">
                    <i class="bi-classbi bi-hospital"></i>
                    <h2>{{$classes}}</h2>
                    <p>CLASS</p>
                </div>
            </div>
        </div>
    </div>

    
    
    </body>

@endsection