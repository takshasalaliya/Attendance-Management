@extends('admin/layout')
@section('title','Teacher List')
@section('teacher')
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

<form action="filter_teacher_list" method="get">
    <select name="filter" id="filter" onchange="this.form.submit()">
        <option value="all" {{$select=='all'?'selected':''}}>All</option>
        <option value="reader" {{$select=='reader'?'selected':''}}>Reader</option>
        <option value="counselor" {{$select=='counselor'?'selected':''}}>Counselor</option>
        <option value="admin" {{$select=='admin'?'selected':''}}>Admin</option>
    </select>
 
</form>

<table class="table">
   <tr>
    
    <th>Name</th>
    <th>Short Name</th>
    <th>Mobile No.</th>
    <th>Email</th>
    <th>Counselor</th>
    <th>Password</th>
    <th>Last Updated</th>
    <th>Operation</th>
    </tr>
    @foreach($teachers as $teacher)
    @if($teacher->role!='student')
    <tr>
        <td>{{$teacher->name}}</td>
        <td>{{$teacher->short_name}}</td>
        <td>{{$teacher->phone_number}}</td>
        <td>{{$teacher->email}}</td>
        <td>{{$teacher->role=='counselor'?'yes':'no'}}</td>
        <td>{{$teacher->plain_password}}</td>
        <td>{{$teacher->updated_at}}</td>
        <td>
        <a href="{{'/edit_teacher/'.$teacher->id}}"><button type="button" class="btn btn-info">Edit</button></a>
        <a href="{{'/delete_teacher/'.$teacher->id}}"><button type="button" class="btn btn-primary">Delete</button></a>
    </td>
    </tr>
    @endif
    @endforeach
</table>
@endsection
