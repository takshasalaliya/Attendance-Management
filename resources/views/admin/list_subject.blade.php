@extends('admin/layout')

@section('title','Subject List')
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

<form action="subject_list_filter_admin" method="get">
    <select name="field" id="field" onchange="this.form.submit()">
        <option value="all" {{$select=='all'?'selected':''}}>ALL</option>
        @foreach($programs as $program)
       
         <option value="{{$program->program->program_id}}" {{ $select == $program->program->program_id ? 'selected' : '' }}>{{$program->program->name.'/'.$program->devision}}</option>
       
        @endforeach
    </select>
</form>
<table class="table">
   <tr>
    <th>Subjec Name</th>
    <th>Subject Short Name</th>
    <th>Subject Code</th>
    <th>Field</th>
    <th>Category</th>
    <th>Last Updated</th>
    <th>Operation</th>
    </tr>
    @foreach($subjects as $subject)
   
                 @php
                $data=explode('/',$subject->student_class->year);
                $year1=explode('-',$data[0]);
                $year2=explode('-',$data[1]);
                @endphp
    <tr>
        <td>{{$subject->subject_name}}</td>
        <td>{{$subject->short_name }}</td>
        <td>{{$subject->subject_code}}</td>
        <td>{{$subject->student_class->program->name.'/'.$year1[0].'-'.$year2[0].'/'.$subject->student_class->sem.'/'.$subject->student_class->devision}}</td>
        <td>{{$subject->category}}</td>
        <td>{{$subject->updated_at}}</td>
        <td><a href="{{'/edit_subject_admin/'.$subject->subject_id}}"><button type="button" class="btn btn-info">Edit</button></a>
        <a href="{{'delete_subject_admin/'.$subject->subject_id   }}"><button type="button" class="btn btn-primary">Delete</button></a></td>
        </tr>
    
    @endforeach
    
</table>

@endsection