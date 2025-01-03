@extends('admin/layout')
@section('title','Add Class')
@section('add_class')

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
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Add Class</h3>
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

            
<form action="add_class_admin" method="post"> 
                @csrf
              <div class="row">
                <div class="col-md-6 mb-4">
                 <label for="stream" class="form-label">Program</label>
                 
                 <div class="form-check">
                 <select name="stream" id="stream" >
                  @foreach($programs as $program)
                  <option value="{{$program->program_id}}">{{$program->name}}</option>
                  @endforeach
                 </select>
                </div>
               </div>
                <div class="col-md-6 mb-4">

                <label for="year" class="form-label">Year</label>
                 <div class="form-date">
                 <input class="form-date-input" type="month" name="date_from" id="From">
                 <label class="form-check-label" for="From">
                 From
                 </label>
                 <span class="alert">@error('date_from'){{"⚠️".$message}}@enderror</span>
                </div>
                <div class="form-check">
                 <input class="form-date-input" type="month" name="date_to" id="TO">
                 <label class="form-date-label" for="To">
                 To
                 </label>
                 <span class="alert">@error('date_to'){{"⚠️".$message}}@enderror</span>
                </div>
                
                </div>
              </div>

              <div class="row">
              <div class="col-md-6 mb-4">

                <label for="semnumber" class="form-label">Semester Number</label>
                 <div class="form-check">
                 <select name="semnumber" id="semnumber" >
                  <option value="1">semester 1</option>
                  <option value="2">semester 2</option>
                  <option value="3">semester 3</option>
                  <option value="4">semester 4</option>
                  <option value="5">semester 5</option>
                  <option value="6">semester 6</option>
                 </select>
                </div>
                
                
                </div>
                <div class="col-md-6 mb-4 pb-2">

               <div data-mdb-input-init class="form-outline">
               <label class="form-label" for="devision">Division</label>
                 <input type="text" id="devision" class="form-control form-control-lg" name="devision"/>
                 <span class="alert">@error('devision'){{"⚠️".$message}}@enderror</span>
               </div>
               
               </div>
              </div>

              <div class="row">

              
              
                <div class="col-md-6 mb-4 pb-2">

                  <div data-mdb-input-init class="form-outline">
                  <label class="form-label" name="counselor">Class Counselor</label><br>
                  <div class="form-check">
                    
                    <select name="counselor" id="counselor">
                    @foreach($datas as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                    
                    
<span class="alert">@error('counselor'){{"⚠️".$message}}@enderror</span>
                  </div>

                </div>
              </div>

              
              <div class="mt-4 pt-2">
                <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" value="Submit" />
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>


@endsection