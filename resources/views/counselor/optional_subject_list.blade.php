@extends('counselor/layoutcounselor')
@section('title','Subject List')
@section('optional_subject_list')
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

</form>
<table class="table">
   <tr>
    <th>Enrollment</th>
    <th>Name</th>
    <th>Subject Code</th>
    <th>Subject Name</th>
    <th>Devision</th>
    <th>Semester</th>
    <th>Program</th>
    <th>Delete</th>
   </tr>
   
   @foreach($datas as $data)
   <tr>
    <td>{{$data->student->enrollment_number}}</td>
    <td>{{$data->student->name}}</td>
    <td>{{$data->subject->subject_code}}</td>
    <td>{{$data->subject->subject_name}}</td>
    <td>{{$data->subject->student_class->devision}}</td>
    <td>{{$data->subject->student_class->sem}}</td>
    <td>{{$data->subject->student_class->program->name}}</td>
    <td>
    <a href="{{'delete_optional/'.$data->id   }}"><button type="button" class="btn btn-primary">Delete</button></a></td>
    </td>
   </tr>
   @endforeach
</table>

@endsection