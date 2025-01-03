@extends('admin/layout')

@section('title','Class List')
@section('class_list')

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

<form action="class_list_filter" method="get">
    <select name="field" id="field" onchange="this.form.submit()">
        <option value="all" {{$select=='all'?'selected':''}}>ALL</option>
        @foreach($programs as $program)
         <option value="{{$program->program_id}}" {{ $select == $program->program_id ? 'selected' : '' }}>{{$program->name}}</option>
        @endforeach
    </select>
</form>

<table class="table">
   <tr>
    <th>Class ID</th>
    <th>Stream</th>
    <th>Year</th>
    <th>Semeter Oder</th>
    <th>Division</th>
    <th>Counselor Name</th>
    <th>Last Updated</th>
    <th>Operation</th>
    </tr>
    @foreach($classes as $class)
    <tr>
        <td>{{$class->id}}</td>
        <td>{{$class->program->name}}</td>
        <td>{{$class->year}}</td>
        <td>{{$class->sem}}</td>
        <td>{{$class->devision}}</td>
        <td>{{$class->teacher->name}}</td>
        <td>{{$class->updated_at}}</td>
        <td>
        <a href="{{'edit_class/'.$class->id}}"><button type="button" class="btn btn-info">Edit</button></a>
        <a href="{{'/delete_class/'.$class->id}}"><button type="button" class="btn btn-primary">Delete</button></a>
    </td>
    </tr>
    @endforeach
</table>
@endsection