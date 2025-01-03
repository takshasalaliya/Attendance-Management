@extends('admin/layout')

@section('title', 'Optional Subject Maping')
@section('optional_subject')

<head>
    <style>.gradient-custom {
/* fallback for old browsers */
background: #ffffff;

/* Chrome 10-25, Safari 5.1-6 */
background: #ffffff;

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: #ffffff;
}

.card-registration .select-input.form-control[readonly]:not([disabled]) {
font-size: 1rem;
line-height: 2.15;
padding-left: .75em;
padding-right: .75em;
}
.card-registration .select-arrow {
top: 13px;
}</style>
</head>
<body>


<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Optional Subject</h3>
            @if(session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill"/>
              </svg>
              <div>
                {{ session('success') }}
              </div>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  <div>
    {{session('error')}}
  </div>

</div>
@endif


<form action="optionalgroup_admin" method="get">

    <select name="field" id="field" onchange="this.form.submit()">
                  <option value="">Select Program</option>
                  @foreach($programs as $program)
                  
                 
                  
                  <option value="{{$program->program->program_id}}" {{ $program->program->program_id == request('field') ? 'selected' : '' }}>{{$program->program->name}}</option>
                 
                  @endforeach
              </select>
    @if($sem)
    <select name="sem" id="sem" onchange="this.form.submit()">
        <option value="">Select Semester</option>
        @foreach($sem as $sem)
        
        <option value="{{$sem->sem}}" {{$sem->sem==request('sem') ? 'selected':''}}>{{'Semester'.$sem->sem}}</option>
        
        @endforeach
    </select>
    @endif
    @if($year)
    <select name="year" id="year" onchange="this.form.submit()">
        <option value="">Select Year</option>
        @foreach($year as $year)
      
        <option value="{{$year->year}}" {{$year->year==request('year') ? 'selected':''}}>{{$year->year}}</option>
       
        @endforeach
    </select>
    @endif
    @if($devision)
    <select name="devision" id="devision" onchange="this.form.submit()">
        <option value="">Select Devision</option>
        @foreach($devision as $devision)
       
        <option value="{{$devision->devision}}" {{$devision->devision==request('devision') ? 'selected':''}}>{{$devision->devision}}</option>
        
        @endforeach
    </select>
    @endif
</form>

            @if($valid)
            <form action="optionalgroup_admin" method="post"> 
                @csrf
              <div class="row">
                <div class="col-md-6 mb-4">

                  <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="subject">Subject Name</label><br>
                    @foreach($subject as $subject)
                    {{$subject->subject_name}}  <input type="checkbox" name="subject[]" value="{{$subject->subject_id}}" id="subject">
                    <br>
                    @endforeach
                    <span class="alert">@error('subject'){{"⚠️".$message}}@enderror</span>
                  </div>

                </div>
                <div class="col-md-6 mb-4">

                  <div data-mdb-input-init class="form-outline">
                  <label class="form-label" for="student">Student Name</label><br>
                  @foreach($students as $student)
                  @if($student->optional =='no')
                  
                    {{$student->name}}/{{$student->enrollment_number}} <input type="checkbox" name="student[]" value="{{$student->student_id}}" id="student">
                    <br>
                  @endif
                    @endforeach
                    <span class="alert">@error('student'){{"⚠️".$message}}@enderror</span>
                  </div>

                </div>
              </div>


              

           
              <div class="mt-4 pt-2">
                <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" value="Submit" />
              </div>

            </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
@endsection