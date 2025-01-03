@extends('counselor/layoutcounselor')
@section('title', 'Subject and Teaching Staff')
@section('teachingstaff')

<head>
    <style>
        .gradient-custom {
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
        }
    </style>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div>
            <div>
                <div>
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Subject Techer Maping</h3>
                            @if(session('success'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                            @endif
                            @if(session('error'))
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Error:">
                                    <use xlink:href="#exclamation-circle-fill" />
                                </svg>
                                <div>
                                    {{ session('error') }}
                                </div>
                            </div>
                            @endif

                            <form action="subjectallocated" method="GET">
                                @csrf

                                <label for="program">Program</label>
                                <select name="program" id="program" onchange="this.form.submit()">
                                    <option value="">Select Program</option>
                                    @foreach($programs as $program)
                                    @if($program->coundelor_id==Auth::user()->id)
                                    <option value="{{$program->program->program_id}}" {{request('program')==$program->program->program_id?'selected':''}}>{{$program->program->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @if($sem)
                                <label for="semester">Semester</label>
                                <select name="sem" id="sem" onchange="this.form.submit()">
                                    <option value="">Select Semester</option>
                                    @foreach($sem as $sem)
                                    @if($sem->coundelor_id == Auth::user()->id)
                                    <option value="{{$sem->sem}}" {{request('sem')==$sem->sem?'selected':''}}>Semester{{$sem->sem}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @endif

                                @if($year)
                                <label for="year">Batch</label>
                                <select name="year" id="year" onchange="this.form.submit()">
                                    <option value="">Select Year</option>
                                    @foreach($year as $year)
                                    @if($year->coundelor_id==Auth::user()->id)
                                    @php
                                    $ye=$year->year;
                                    $ye=explode('/',$ye);
                                    $year1=explode('-',$ye[0]);
                                    $year2=explode('-',$ye[1]);
                                    @endphp
                                    <option value="{{$year->year}}" {{request('year')==$year->year?'selected' : ''}}>{{$year1[0].'/'.$year2[0]}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                
                                @endif

                                @if($devision)
                                <label for="devision">Devision</label>
                                <select name="devision" id="devision" onchange="this.form.submit()">
                                    <option value="">Select Devision</option>
                                    @foreach($devision as $devision)
                                    @if($devision->coundelor_id == Auth::user()->id)
                                    <option value="{{$devision->devision}}" {{request('devision')==$devision->devision?'selected':''}}>{{$devision->devision}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @endif

                                @if($teacher)
                                <label for="teacher">Teacher</label>
                                <select name="teacher" id="teacher" onchange="this.form.submit()">
                                    <option value="">Select Teacher</option>
                                    @foreach($teacher as $teacher)
                                    @if($teacher->role != 'admin' && $teacher->role != 'student')
                                    <option value="{{$teacher->id}}" {{request('teacher')==$teacher->id?'selected':''}}>{{$teacher->name}}</option>
                                    @endif
                                    @endforeach
                                </select>   
                                @endif
                            </form>

                            @if($class_id)
                            <form action="/subjectallocated" method="post">
                                @csrf
                                <input type="number" value="{{request('teacher')}}" name="teacher" hidden>
                                <label for="subject">Subject</label>
                                <br>
                                @foreach($subject as $subject)
                                @if($subject->class_id == $class_id)
                                <label for="{{$subject->subject_id}}">{{$subject->subject_name.'/'.$subject->subject_code}}</label>
                                <input type="checkbox" value="{{$subject->subject_id}}" name="subject[]" id="{{$subject->subject_id}}">
                                <br>
                                @endif
                                @endforeach
                                <input type="submit" class="submit">
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
@endsection
