<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Program;
use App\Models\Optional_subject;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Student_class;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Subject;
use App\Models\Teaching_staff;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\professor;
use Illuminate\Support\Carbon; 
use App\Imports\StudentImport;
use Excel;
use  App\Models\Attendence;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExcelTeacher;
use App\Models\Gcode;
use App\Models\Duplicated;




class CounselorController extends Controller
{
    //
       //student





   
 function add_student_excel(Request $request){
    Excel::import(new StudentImport,$request->file('excel_file'));
    return redirect()
    ->back()->with('success', 'Student added successfully!');   
 }


    function list_stud(){
        $students= Student::with('class.program')->get();
        return view('counselor/student_list',['students'=>$students]);
    }
    function edit_value ($id){
        
        $student= Student::with('class.program')->find($id);
        $class=Student_class::all();
        
        return view('counselor/edit_student',['students'=>$student,'classes'=>$class]);
        
       
    }
    function edit_success(Request $request, $id) {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'rollnumber' => 'required|min:2|max:20',
            's_phone' => 'required|digits_between:10,13',
            's_email' => 'required|email',
            'p_phone' => 'required|digits_between:10,13',
            'p_email' => 'email|required',
            'student_class' => 'required|exists:student_classes,id',
        ]);
        $student=Student::find($id);
        $student->name=$request->name;
        $student->enrollment_number=$request->rollnumber;  
        $student->phone_number=$request->s_phone;
        $student->email=$request->s_email;
        $student->parents_phone_number=$request->p_phone;
        $student->parents_email=$request->p_email;
        $student->class_id =$request->student_class;
        $userdata=User::where('email',$student->email)->where('short_name',$student->enrollment_number)->first();
        $userdata->name=$request->name;
        $userdata->short_name=$request->rollnumber;
        $userdata->email=$request->s_email;
        $userdata->phone_number=$request->s_phone;
        $userdata->plain_password=$request->rollnumber;
        $userdata->password=$request->rollnumber;
        $student->save();
        if ($userdata->save()) {
            return redirect('student_list')->with('success', 'Student edited successfully!');
        }
    
        return redirect('student_list')->with('error', 'Student was not edited!');
    }
    function delete_student($id) {
        $data = Student::find($id);
        if(empty($data)){
            return redirect()->back()->with('error', 'mulltiple request will be sent to delete student!');
        }
        $userdata=User::where('email',$data->email)->where('plain_password',$data->enrollment_number)->first();
        
        $userdata->delete();
        
  
        if ($data->delete()) {


            return redirect()->back()->with('success', 'Student deleted successfully!');
        }
        
        return redirect()->back()->with('error', 'Failed to delete student!');
    }

    function search_student(Request $request){
        $students=Student::where('enrollment_number','like',"%$request->search%")->get();
        
        return view('counselor/student_list',['students'=>$students]);
    }






//add teacher








//add class



   
    function Cdashboard(){
        
        $student=Student::count();
        $teacher=User::where('role','reader')->count();
        $counselor=User::where('role','counselor')->count();
        $class=Student_class::count();
        $class_name=Student_class::with(['teacher','program'])->get();

        return view('counselor/CDasboard',['students'=>$student,'teachers'=>$teacher,'counselors'=>$counselor,'classes'=>$class,'class_name'=>$class_name]);
       
    } 
    function find_class_subject(){
        $classes=Student_class::with(['teacher','program'])->get();
        // return $classes;
        return view('counselor/add_subject',['classes'=>$classes]);
    }





    function add_subject(Request $request){
        
        
        
        $class= new Subject();
        $request->validate([
            'name' => 'required',
            'shortname' => 'required',
            'code' => 'required',
            'class' => 'required',
            'category' => 'required',
        ]); 
        $sum=0;
        foreach($request->class as $class){
        
        
        $id[$sum]=intval($class);
        
        $sum++;
        }
        foreach($id as $id){
            $valid=Subject::where('subject_code',$request->code)->where('class_id',$id)->first();
            
            if(empty($valid)){
        $class= new Subject();
        $class->subject_name=$request->name;
        $class->short_name=$request->shortname;
        $class->subject_code=$request->code;
        $class->category=$request->category;
        $class->class_id=$id;
        $class->save();
        if(!$class->save()){
            return redirect()->back()->with('error','error will get occur on this class'.$id);
        }
        }
        
    }
        if($class->save()){
            return redirect()->back()->with('success','New Class Added Successfully');
        }
        return redirect()->back()->with('error','error will get occur');
    }

    function list_subject(){
        $subject=Subject::with('student_class.program')->get();
        $select="all";
        $program=Student_class::with('program')->get();
        return view('counselor/list_subject',['subjects'=>$subject,'select'=>$select,'programs'=>$program]);
    }

    function delete_subject($id){
        $data=Subject::destroy($id);
        if($data){
            return redirect('subject_list')->with('success','Successfull Delete Subject');
        }
        return redirect('subject_list')->with('error','Error Occur on Delete Subject');
    }

    function edit_subject($id){
        $datas=Subject::find($id);
        $classes=Student_class::with('program')->get();
        return view('counselor/edit_subject',['subjects'=>$datas,'classes'=>$classes  ]);
    }

    function edit_subject_final(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'shortname' => 'required',
            'code' => 'required',
            'class' => 'required',
            'category' => 'required',
        ]); 


         $class=Subject::find($id);
        $class->subject_name=$request->name;
        $class->short_name=$request->shortname;
        $class->subject_code=$request->code;
        $class->class_id=$request->class;
        $class->category=$request->category;
        if($class->save()){
            return redirect('subject_list')->with('success','Class Edit Successfully');
        }
        return redirect('subject_list')->with('error','error will occur');
        
    }

    function subject_list_filter(Request $request){
        if($request->field=='all'){
            $data=Subject::with('student_class')->get();
            $select="all";
            $program=Student_class::with('program')->get();
            return view('counselor/list_subject',['subjects'=>$data,'select'=>$select,'programs'=>$program]);
        }
        else{
            $data=Subject::with('student_class')->whereHas('student_class',function($query)use($request){
                $query->where('stream',$request->field);
            })->get();
            $program=Student_class::with('program')->get();
            $select=$request->field;
            return view('counselor/list_subject',['subjects'=>$data,'select'=>$select,'programs'=>$program]);
        }
    }


//subject allocated

    public function subjectallocateget(Request $request)
    {
        $sem = [];
        $year = [];
        $devision = [];
        $teacher = [];
        $subject = [];
        $program=[];
        $class_id=[];

        $program=Student_class::with('program')->get();
        if($request->has(['program'])&& !$request->program==""){
            $sem=Student_class::where('stream',$request->program)->get();
        }
        if($request->has(['program','sem'])&& !$request->program=="" && !$request->sem==""){
            $year=Student_class::where('stream',$request->program)
                                ->where('sem',$request->sem)
                                ->get();
        }
        if($request->has(['program','sem','year'])&& !$request->program=="" && !$request->sem=="" && !$request->year==""){
            $devision=Student_class::where('stream',$request->program)
                                           ->where('sem',$request->sem)
                                           ->where('year',$request->year)
                                           ->get();
        }
        if($request->has(['program','sem','year','devision'])&& !$request->program=="" && !$request->sem=="" && !$request->year=="" && !$request->devision==""){
            $teacher=User::all();
    
        }
        if($request->has(['program','sem','year','devision','teacher'])&& !$request->program=="" && !$request->sem=="" && !$request->year=="" && !$request->devision=="" && !$request->teacher==""){
           
            $class_id=Student_class::where('stream',$request->program)
            ->where('sem',$request->sem)
            ->where('year',$request->year)
            ->where('devision',$request->devision)
            ->first();
            if(!empty($class_id)){
                $class_id=$class_id->id;
            $subject=Subject::all();
            }
            
            
        }


        
        return view('counselor/subject_allocated', [
            'sem' => $sem,
            'year' => $year,
            'devision' => $devision,
            'teacher' => $teacher,
            'subject' => $subject,
            'programs'=>$program,
            'class_id' => $class_id,
        ]);
    }


    function subjectallocatedfinal(Request $request){
        $request->validate([
            'subject' => 'required',
        ]);
        foreach($request->subject as $subject){
            $valid=Teaching_staff::where('subject_id',$subject)->where('staff_id',$request->teacher)->first();
            if(empty($valid)){
            $data=new Teaching_staff();
            $data->subject_id=$subject;
            $data->staff_id=$request->teacher;
            if(!$data->save()){
                return redirect()->back()->with('error','error will occur try after some time');
            }
        }

        }
        return redirect()->back()->with('success','subject will linked successfully');

        
    }

  


    function list_teachingstaff(){
        $teachingstaff=Teaching_staff::with(['teacher','subject'])->get();
        $selete="all";
        $teacher=User::all();
        return view('counselor/list_teachingstaff',['teachingstaffs'=>$teachingstaff,'select'=>$selete,'teacher'=>$teacher]);
        // return $teachingstaff;
    }
    function delete_staff($id){

    $data = Teaching_staff::destroy($id);

    if ($data) {
        return redirect()->back()->with('success', 'Staff deleted successfully.');
    }

    return redirect()->back()->with('error', 'Staff deletion failed.');
}


function teachingstaff_list_filter(Request $request){
    if($request->teacher=="all"){
        $selete="all";
        $teachingstaff=Teaching_staff::with(['teacher','subject'])->get();
        $teacher=User::all();
        return view('counselor/list_teachingstaff',['teachingstaffs'=>$teachingstaff,'select'=>$selete,'teacher'=>$teacher]);    }
    else{
        $teachingstaff=Teaching_staff::with(['teacher','subject'])->where('staff_id',$request->teacher)->get();
        $teacher=User::all();
       $selete=$request->teacher;
       return view('counselor/list_teachingstaff',['teachingstaffs'=>$teachingstaff,'select'=>$selete,'teacher'=>$teacher]);    }
}



function optional(Request $request){
    $request->validate([
        'subject'=>'required',
        'student' => 'required',
    ]);

    $sum1=0;
    $sum2=0;
    foreach($request->subject as $sub){
        $subject[$sum1]= $sub;
        $sum1++;
    }
    foreach($request->student as $std){
        $student[$sum2]=$std;
        $sum2++;
    }
    
    foreach($subject as $sub){
        foreach($student as $std){
            $find=Optional_subject::where('student_id',$std)->where('subject_id',$sub)->first();
            if(empty($find)){
            $data= new Optional_subject();
            $data->student_id=$std;
            $data->subject_id=$sub;
            $data->save();
            
            if (!$data->save()) {
                return redirect()->back()->with('error', 'error will occur when will student adding ');
            }
            $id=Student::where('student_id',$std)->first();
            $id->optional='yes';
            $id->save();
            if (!$id->save()) {
                return redirect()->back()->with('error', 'error will occur when will student adding ');
            }
        }
        }
    }

    return redirect()->back()->with('success', 'Successfully student onptional subject added');
}
function optionalgroup(Request $request){
    $select=$request->field;
    $sem=[];
    $valid=[];
    $year=[];
    $devision=[];
    $subject=[];
    $id=[];
    $student=[];
    $optional=[];
    $program=Student_class::with('program')->get();
    if($request->has(['field']) && !$request->field == ""){
        $sem=Student_class::where('stream',$request->field)->get();
       
    }
    if($request->has(['field','sem']) && !$request->field == "" && !$request->sem == "" ){
        $year=Student_class::where('stream',$request->field)->where('sem',$request->sem)->get();
        }
        if($request->has(['field','sem','year'])  && !$request->field == "" && !$request->sem == ""  && !$request->year == ""){
            $devision=Student_class::where('stream',$request->field)->where('sem',$request->sem)->where('year',$request->year)->get();
           
        }
        if($request->has(['field','sem','year','devision'])  && !$request->field == "" && !$request->sem == ""  && !$request->year == "" && !$request->devision == "" ){
            if(!$request->sem==""&&!$request->field==""&&!$request->year==""&&!$request->devision==""){
            $id=Student_class::where('stream',$request->field)->where('sem',$request->sem)->where('year',$request->year)->where('devision',$request->devision)->first();
            if(!empty($id)){
            $subject=Subject::where('class_id',$id->id)->where('category','optional')->get();
            $student=Student::where('class_id',$id->id)->get();
            }
            }
            $valid=1;
           

        }
    
    return view('counselor/optional_subject_group',[
        'select' => $select,
        'sem'=>$sem,
        'valid'=>$valid,
        'year'=>$year,
        'devision' => $devision,
        'subject' => $subject,
        'students' => $student,
        'programs'=>$program,
    ]);
}

function optional_list(){
    $data=Optional_subject::with('student','subject.student_class.program')->get();
    // return $data;
    return view('counselor/optional_subject_list',[
        'datas' => $data,
    ]);
}
function delete_optional($id){
    $forward=Optional_subject::with('student')->find($id)->first();
    $forward->student->optional='no';
    $data=Optional_subject::destroy($id);
    if($data){
    $forward->student->save();
    return redirect()->back()->with('success','Student optional data will deleted');
    }
    return redirect()->back()->with('error','Student optional data will not deleted');

}


//attendent
  
function select_attendent(){
  
    
    $subject=Teaching_staff::with(['subject.student_class.program'])->where('staff_id',Auth::user()->id)->get();
    $teacher=User::find(Auth::user()->id);
    
           return view('counselor/select_operation',[
            'subjects'=>$subject,
            'teachers'=>$teacher,
            ]);
}



function selectes_data(Request $request){
  

    if($request->subject==""){
        return redirect()->back()->with('error','select subject');
    }
    
    $request->validate([
        'date'=>'required'
    ]);
    $sum=0;
    $yes=1;
    $attendent=0;
    $optional=[];
    $datas=Teaching_staff::with(['subject.student_class.program','teacher'])->get();
    $students=Student::all();
    $subject=Teaching_staff::where('id',$request->subject)->first();
    $subject=$subject->subject_id;
    $data_database=Attendence::where('leacture_no',$request->leacture)->where('created_at',$request->date)->get();
    // return $data_database;
    if (empty($data_database->leacture_no)) {
        $attendent = 1;
    } 
    $findoptinal=Subject::where('subject_id',$subject)->first();
    if($findoptinal->category=='optional'){
        $optional=Optional_subject::with('student')->where('subject_id',$subject)->get();
        $yes=0;
    }
    // return $attendent;
    if($request->submit=='edit'){
        $sum=0;
        $subject=$request->subject;
        $attendent=Attendence::with('student')->where('staff_id',$subject)->where('leacture_no',$request->leacture)->get();
        $datas=Teaching_staff::with(['subject.student_class.program','teacher'])->get();
        return view('counselor/edit_attendent',['pervious'=>$request,'datas'=>$datas,'attendent'=>$attendent,'sum'=>$sum]);
    }
    if($request->submit=='generate'){
        $code=Str::password(5,numbers: true,symbols: false,letters: false,spaces: false);
        
      
        $checks=Gcode::where('staff_id',$request->subject)->where('lecture_no',$request->leacture)->get();
        foreach($checks as $check){
            $delete=Gcode::destroy($check->id);
        }
        $data=new Gcode();
        $data->code=$code;
        $data->staff_id=$request->subject;
        $data->lecture_no=$request->leacture;
        $data->created_at=$request->date;
        
        if($data->save()){
            if($findoptinal->category=='optional'){
                $subject=Teaching_staff::with('subject')->where('id',$request->subject)->first();
                
                $student=Student::where('class_id',$subject->subject->class_id)->get();
                $optional=Optional_subject::with('student')->where('subject_id',$subject->subject->subject_id)->get();
                foreach($optional as $data){
                    $valid=Attendence::where('student_id',$data->student->student_id)->where('staff_id',$request->subject)->where('leacture_no',$request->leacture)->where('created_at',$request->date)->first();
                    if(empty($valid->id)){
                    $data1=new Attendence();
                    $data1->student_id=$data->student->student_id;
                    $data1->staff_id=$request->subject;
                    $data1->leacture_no=$request->leacture;
                    $data1->created_at=$request->date;
                    $data1->attendance='absent';
                    $data1->save();
                    }
                }
            }
            else{
                $subject=Teaching_staff::with('subject')->where('id',$request->subject)->first();
                
                $student=Student::where('class_id',$subject->subject->class_id)->get();
                foreach($student as $data){
                    $valid=Attendence::where('student_id',$data->student_id)->where('staff_id',$request->subject)->where('leacture_no',$request->leacture)->where('created_at',$request->date)->first();
                    if(empty($valid->id)){
                    $data1=new Attendence();
                    $data1->student_id=$data->student_id;
                    $data1->staff_id=$request->subject;
                    $data1->leacture_no=$request->leacture;
                    $data1->created_at=$request->date;
                    $data1->attendance='absent';
                    $data1->save();
                    }
                }
            }
            return view('counselor/generate_code',[
                'code' => $code,
            ]);
        }
        
    }
    return view('counselor/main_attendent',['pervious'=>$request,'datas'=>$datas,'students'=>$students,'sum'=>$sum,'optional'=>$optional,'yes'=>$yes,'attendent'=>$attendent]);
}




function delete_code($code){
    $data=Gcode::where('code',$code)->first();
    if($data->delete()){
     return redirect('select_counselor')->with('success','Code delete Successfully');
    }
    return redirect('select_counselor')->with('error','Code delete unSuccessfully');
 }





function final_attendent(Request $request){
   

    foreach($request->student as $std){
        $valid=Attendence::where('student_id',$std)->where('staff_id',$request->staff_id)->where('leacture_no',$request->leacture)->where('created_at',$request->date)->first();
        
        if(empty($valid)){
       
        $data=new Attendence();
        $save=0;
        $data->student_id=$std;
        $data->staff_id=$request->staff_id;
        $data->attendance=$request->$std;
        $data->leacture_no=$request->leacture;
        $data->created_at=$request->date;
       $save= $data->save();
       
        if($save != 1){
            return redirect()->back()->with('error','error will occur refill attendent');
        }
    }
    }
    return redirect()->back()->with('success','successfull added attendent');
    
}

function attendent_list(Request $request){
    
    $student=[];
    $id=[];
    $valid=[];
    $subject=Teaching_staff::with(['subject.student_class.program','teacher'])->where('staff_id',Auth::user()->id)->get();
    if($request->has('subject') && $request->subject !=""){
        // $student=Student::all();
        $student=Attendence::with(['student','teaching_staff'])->get();
        // return $student;
        $id=$request->subject;
        foreach($student as $std){
            if($std->staff_id == $id){
            $valid[]=$std->student->enrollment_number;
            }
        }
        $valid= array_unique($valid);
        
    // return;      
    }
    return view('counselor/attendent_list',[
        'subject' => $subject,
        'student'=>$student,
        'id' =>$id,
        'valid' => $valid,
        
    ]);
    
}

function edit_attendendent(Request $request){
    foreach($request->student as $std){
 
      
        $data=Attendence::where('student_id',$std)->where('staff_id',$request->staff_id)->where('leacture_no',$request->leacture)->where('created_at',$request->date)->first();
        
        $save=0;
        
        $data->attendance=$request->$std;
      
       $save= $data->save();
       
        if($save != 1){
            return redirect()->back()->with('error','error will occur refill attendent');
        }   
    }
    return redirect()->back()->with('success','successfull added attendent');
    
    }

    function generate_pdf($id){
        
        $student=[];
      
        $valid=[];

        
            $student=Attendence::with(['student','teaching_staff'])->get();
            // return $student;
            foreach($student as $std){
                if($std->staff_id == $id){
                $valid[]=$std->student->enrollment_number;
                }
            }
            // return view('teacher/pdf_attendent',[
            // 'student' =>$student,
            // 'valid' => $valid,
            // 'id' => $id
            // ]);
            $valid= array_unique($valid);
            $data=[
            'student' =>$student,
            'valid' => $valid,
            'id' => $id
            ];
            

    $pdf = PDF::loadView('counselor.pdf_attendent', $data);
    return $pdf->download('attendent.pdf');
    
}

function generate_excel($id){
    return Excel::download(new ExcelTeacher($id),'attendent.xlsx');
}


}
