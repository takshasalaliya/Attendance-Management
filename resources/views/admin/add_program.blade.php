@extends('admin/layout')
@section('title','Class List')
@section('add_field')

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

<form action="field" method="post">
    @csrf
    <label for="field">Field</label>
    <input type="text" name="field" id="field">
    <input type="submit" value="submit">
</form>

<table class="table">
   <tr>
    <th>Program</th>
    <th>Delete</th>
    </tr>
    @foreach($datas as $data)
    <tr>
        <td>{{ $data->name }}</td>
        <td><a href="{{'/delete_program/'.$data->program_id}}"><button type="button" class="btn btn-primary">Delete</button></a></td>
    </tr>
    @endforeach
    
</table>
@endsection