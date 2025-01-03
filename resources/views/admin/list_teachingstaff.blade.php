@extends('admin/layout')

@section('title','TeachingStaff List')
@section('subject_table')
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


<form action="teachingstaff_list_filter_admin" method="get">
    <select name="teacher" id="teacher" onchange="this.form.submit()">
        <option value="all" {{$select=='all'?'selected':''}}>All</option>
        @foreach($teacher as $teacher)
        @if($teacher->role != 'admin' && $teacher->role != 'student')
        <option value="{{$teacher->id}}" {{$teacher->id==$select?'selected':''}}>{{$teacher->name}}</option>
        @endif
        @endforeach
    </select>
</form>

<table class="table"> 
   
    <tr>
    <th>Subject Name</th>
    <th>Subject Short Name</th>
    <th>Subject Code</th>
    <th>Proffersor Name</th>
    <th>Short Name</th>
    <th>Email</th>
    <th>Last Updated</th>
    <th>Operation</th>
    </tr>
    @foreach($teachingstaffs as $data)

    <tr>
        <td>{{$data->subject->subject_name}}</td>
        <td>{{$data->subject->short_name }}</td>
        <td>{{$data->subject->subject_code}}</td>
        <td>{{$data->teacher->name}}</td>
        <td>{{$data->teacher->short_name}}</td>
        <td>{{$data->teacher->email}}</td>
        <td>{{$data->updated_at}}</td>
        <td><a href="{{'delete_staff_admin/'.$data->id}}"><button type="button" class="btn btn-primary">Delete</button></a></td>
        </tr>

    @endforeach
    
</table>

@endsection