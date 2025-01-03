@extends('counselor/layoutcounselor')
@section('title','Attendent List')
@section('subject_table_attendent')
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

<form action="attendent_list_counselor" method="get">
    <label for="subject">Subject</label>
    <select name="subject" id="subject" onchange="this.form.submit()">
        <option value="">Select Subject</option>
        @foreach($subject as $subj)
        @php
        $year=explode('/',$subj->subject->student_class->year);
        $year1=explode('-',$year[0]);
        $year2=explode('-',$year[1]);
        @endphp
        <option value="{{$subj->id}}" {{request('subject')==$subj->id?'selected':''}}>{{$subj->subject->short_name.'/'.$subj->subject->student_class->program->name.'/'.$subj->subject->student_class->sem.'/'.$subj->subject->student_class->devision.'/'.$year1[0].'-'.$year2[0]}}</option>
                     
        @endforeach
    </select>
</form>
@if($student)
<a href="{{'generate_pdf_counselor/'.request('subject')}}"><button type="button" class="btn btn-info">PDF</button></a>
<a href="{{'generate_excel_counselor/'.request('subject')}}"><button type="button" class="btn btn-info">Excel</button></a>
<table class="table">
<tr>
    <th>Enrollment Number</th>
    <th>Name</th>
    <th>Total Class</th>
    <th>From</th>
    <th>To</th>
    <th>Present</th>
    <th>Pertentage</th>
</tr>   
@foreach($valid as $data)

<tr>
    
    <?php
    $sum=0;
    $present=0;
    $enter=0;
    $date=[];
    foreach ($student as $d) {
        if ($d->student->enrollment_number == $data && $d->staff_id == $id) {
            $date[]=$d->created_at;
            $sum++;
            $to=explode(" ",$d->created_at);
            $name=$d->student->name;
            if($d->attendance=='present'){
                $present++;
            }
        }

        
    }
    sort($date);
    $from=$date[0]; 
    $from=explode(" ",$from);
    $to = end($date);
    $to=explode(" ",$to);
    $pertentage=number_format($present/$sum*100,2);
    ?>
    <td>{{$data}}</td>
    <td>{{$name}}</td>
    <td>{{$sum}}</td>
    <td>{{$from[0]}}</td>
    <td>{{$to[0]}}</td>
   <td>{{$present}}</td>
   <td>{{$pertentage}}%</td>
</tr>

@endforeach
</table>
@endif

@endsection