@extends('admin/layout')

@section('title','Student List')
@section('student_table')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="search_student_admin" method="GET">
    <label for="search" class="search">Search</label>
    <input type="text" class="search" name="search" id="search" placeholder="Enter Student Enrollment number">
    <input type="submit" class="btn btn-search" style="border:2px solid black;" >
</form>

<table class="table">
   <tr>
    <th>Name</th>
    <th>Roll No.</th>
    <th>Student Phone Number</th>
    <th>Email ID</th>
    <th>Parent Phone Number</th>
    <th>Parent Email ID</th>
    <th>Class</th>
    <th>Last Updated</th>
    <th>Operation</th>
    </tr>
    @php
    $src=0;
    @endphp
    @if($students)
    @foreach($students as $student)
    
   
    <tr>
        <td>{{$student->name}}</td>
        <td>{{$student->enrollment_number }}</td>
        <td>{{$student->phone_number}}</td>
        <td>{{$student->email}}</td>
        <td>{{$student->parents_phone_number}}</td>
        <td>{{$student->parents_email}}</td>
        <td>{{$student->class->program->name.'/'.$student->class->year.'/'.$student->class->sem}}</td>
        <td>{{$student->updated_at}}</td>
        <td><a href="{{'/edit_student_admin/'.$student->student_id}}"><button type="button" class="btn btn-info">Edit</button></a>
        <a href="{{'delete_student_admin/'.$student->student_id}}"><button type="button" class="btn btn-primary">Delete</button></a></td>
    </tr>
    @php
    $src=1;
    @endphp
    
    @endforeach
    @endif
   @if(!$src)
   <center><h2>no data found</h2></center>
   @endif
</table>

@endsection