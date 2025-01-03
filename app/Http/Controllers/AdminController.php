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
use App\Models\Gcode;

class AdminController extends Controller
{
 
    
    function add_teacher(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:100',
            'shortname' => 'required|min:1|max:20',
            'phone' => 'required',
            'email' => 'required|email',
           
            'role' => 'required',
           
        ]);
        $data= new User();
        $data->name=$request->name;
        $data->short_name=$request->shortname;
        $data->phone_number=$request->phone;
        $data->email=$request->email;
        $data->role=$request->role;
        $password=Str::random(10);
        $data->plain_password=$password;
        
        $data->password= $password;
        

            $message=[
                'name'=> $request->name,
                'phone'=>$request->phone,
                'shortname'=>$request->shortname,
                'counselor'=>$request->role,
                'password'=>$password
                

            ];
        
        $subject="Add In Attendent Management";
            if($data->save()){
            Mail::to($request->email)->send(new professor($message,$subject));   
            return redirect()->back()->with('success','Teacher information will added!');
        }
        return redirect()->back()->with('error','Teacher information will not added!');
    }    



    function list_teach(){
        $data=User::all();
        $select="all";
        return view('admin/teacher_list',['teachers'=>$data,'select'=>$select]);
    }



    function delete_teacher($id){
        $data= User::destroy($id);
        
        if($data){
            if($data){
            return redirect()->back()->with('success','Teacher Information Deleted!');
            }
        
    }
        return redirect()->back()->with('error','Teacher Information is not Deleted!');
    }

    function edit_teacher_success(Request $request, $id){
        $data= User::find($id);
        $request->validate([
            'name' => 'required|min:3|max:100',
            'shortname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required',
           
        ]);
        $data->name=$request->name;
        $data->short_name=$request->shortname;
        $data->phone_number=$request->phone;
        $data->email=$request->email;
        $data->role=$request->role;
        $data->plain_password=$request->password;
        $data->password= $request->password;

        $message=[
            'name'=> $request->name,
            'phone'=>$request->phone,
            'shortname'=>$request->shortname,
            'counselor'=>$request->role,
            'password'=>$request->password,
            

        ];
    
    $subject="YOur Profile Will Updated";

        if($data->save()){
            Mail::to($request->email)->send(new professor($message,$subject));   
            return redirect('teacher_list')->with('success','Teacher information will added!');
        }
    
        return redirect('teacher_list')->with('error','Teacher information will not added!');
    }

    function edit_teacher($id){
        $data= User::find($id);
        
        return view('admin/edit_teacher',['teacher'=>$data]);
        
        return redirect('login')->with('error','First Login With same Conselor Account');
    }


    function teacher_list_filter(Request $request){
        if($request->filter=='all'){
            $data=User::all();
            $select="all";
        return view('admin/teacher_list',['teachers'=>$data,'select'=>$select]);
        }
        else{
            $data=User::where('role',$request->filter)->get();
            $select=$request->filter;
        return view('admin/teacher_list',['teachers'=>$data,'select'=>$select]);
                
        }
    }


//login


    function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            $role=Auth::user()->role;
            if($role=='admin'){
                return redirect('/admin');
            }
            if($role=='reader'){
                return redirect('/reader');
            }
            if($role=='counselor'){
                return redirect('/counselor');
            }
            if($role=='student'){
                return redirect('/student');
            }
        }
        return redirect()->back()->with('error','Invalid Data');
    }
    function logout(){
        Auth::logout();
        return view('login');
    }

//dashboard


    function dashboard(){
        
        $student=Student::count();
        $teacher=User::where('role','reader')->count();
        $counselor=User::where('role','counselor')->count();
        $class=Student_class::count();

        return view('admin/welcome',['students'=>$student,'teachers'=>$teacher,'counselors'=>$counselor,'classes'=>$class]);
        
    }

    




//add class

function add_class(Request $request){
    $request->validate([
        'date_from' => 'required',
        'date_to' => 'required',
        'semnumber' => 'required',
        'stream' => 'required',
        'devision' => 'required',
        'counselor' => 'required',
    ]);
   

$year=$request->date_from.'/'.$request->date_to;
$data= new Student_class();
$data->stream=$request->stream;
$data->year=$year;
$data->sem=$request->semnumber;
$data->devision=$request->devision;
$data->coundelor_id=$request->counselor;


if($data->save()){
    return redirect()->back()->with('success','Class Information Added!');
}
return redirect()->back()->with('error','Class Information is not Added!');
}

function list_class(){

$data= Student_class::with(['teacher','program'])->get();
$program=Program::all();
// return $data;
$select='all';
return view('admin/class_list',['classes'=>$data,'select'=>$select,'programs'=>$program]);
}


function get_counselor(){
$data = User::where('role','counselor')->get();
$program=Program::all();
return view('admin/add_class',['datas'=>$data,'programs'=>$program]);
}

function edit_class($id){
$data = Student_class::find($id);
$program=Program::all();
$class = User::where('role','counselor')->get();

return view('admin/edit_class',['datas'=>$data,'classes'=>$class,'programs'=>$program]);

}

function edit_class_success(Request $request,$id){
$request->validate([
    'date_from' => 'required',
    'date_to' => 'required',
    'semnumber' => 'required',
    'stream' => 'required',
    'devision' => 'required',
    'counselor' => 'required',
]);
$year=$request->date_from.'/'.$request->date_to;
$data=Student_class::find($id);
$data->stream=$request->stream;
$data->year=$year;
$data->sem=$request->semnumber;
$data->devision=$request->devision;
$data->coundelor_id=$request->counselor;
if($data->save()){
    return redirect('class_list')->with('success','Class Information Edit!');
}
return redirect()->back()->with('error','Class Information is not Edit!');
}

function delete_class($id){
$data = Student_class::destroy($id);
if($data){
    return redirect('class_list')->with('success','Class Information Delete!');
}
return redirect()->back()->with('error','Class Information is not Delete!');  
}

function class_list_filter(Request $request){
if($request->field=='all'){
    $data= Student_class::with(['teacher','program'])->get();
    $select='all';
    $program=Program::all();
    return view('admin/class_list',['classes'=>$data,'select'=>$select,'programs'=>$program]);
}
else{
    $data= Student_class::with(['teacher','program'])->whereHas('program',function($query)use($request){
        $query->where('program_id',$request->field);
    })->get();
    // return $request;
    $select=$request->field;
    $program=Program::all();
    return view('admin/class_list',['classes'=>$data,'select'=>$select,'programs'=>$program]);
}
}

  
//add field

function field_list(){
    $data=Program::all();
    return view('admin/add_program',['datas'=>$data]);
}
function add_field_success(Request $request){
    $data=new Program();
    $data->name=$request->field;
    if($data->save()){
        return redirect()->back()->with('success','Program add successfully');
    }
    return redirect()->back()->with('error','Program will not added');

}
function delete_program($id){
    $data=Program::destroy($id);
    if($data){
        return redirect()->back()->with('success','Program delete successfully');
    }
    return redirect()->back()->with('error','Program will not delete');
}


   
function add_student_excel(Request $request){
    Excel::import(new StudentImport,$request->file('excel_file'));
    return redirect()
    ->back()->with('success', 'Student added successfully!');   
 }


    function list_stud(){
        $students= Student::with('class.program')->get();
        return view('admin/student_list',['students'=>$students]);
    }
    function edit_value ($id){
        
        $student= Student::with('class.program')->find($id);
        $class=Student_class::all();
        
        return view('admin/edit_student',['students'=>$student,'classes'=>$class]);
        
       
    }
    function edit_success(Request $request, $id) {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'rollnumber' => 'required|min:2|max:20',
            's_phone' => 'required',
            's_email' => 'required|email',
            'p_phone' => 'required',
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
            return redirect('student_list_admin')->with('success', 'Student edited successfully!');
        }
    
        return redirect('student_list_admin')->with('error', 'Student was not edited!');
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
        
        return view('admin/student_list',['students'=>$students]);
    }






//add teacher








//add class



function find_class_subject(){
    $classes=Student_class::with(['teacher','program'])->get();
    // return $classes;
    return view('admin/add_subject',['classes'=>$classes]);
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
    return view('admin/list_subject',['subjects'=>$subject,'select'=>$select,'programs'=>$program]);
}

function delete_subject($id){
    $data=Subject::destroy($id);
    if($data){
        return redirect('subject_list_admin')->with('success','Successfull Delete Subject');
    }
    return redirect('subject_list_admin')->with('error','Error Occur on Delete Subject');
}

function edit_subject($id){
    $datas=Subject::find($id);
    $classes=Student_class::with('program')->get();
    return view('admin/edit_subject',['subjects'=>$datas,'classes'=>$classes  ]);
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
        return redirect('subject_list_admin')->with('success','Class Edit Successfully');
    }
    return redirect('subject_list_admin')->with('error','error will occur');
    
}

function subject_list_filter(Request $request){
    if($request->field=='all'){
        $data=Subject::with('student_class')->get();
        $select="all";
        $program=Student_class::with('program')->get();
        return view('admin/list_subject',['subjects'=>$data,'select'=>$select,'programs'=>$program]);
    }
    else{
        $data=Subject::with('student_class')->whereHas('student_class',function($query)use($request){
            $query->where('stream',$request->field);
        })->get();
        $program=Student_class::with('program')->get();
        $select=$request->field;
        return view('admin/list_subject',['subjects'=>$data,'select'=>$select,'programs'=>$program]);
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


    
    return view('admin/subject_allocated', [
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
    return view('admin/list_teachingstaff',['teachingstaffs'=>$teachingstaff,'select'=>$selete,'teacher'=>$teacher]);
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
    return view('admin/list_teachingstaff',['teachingstaffs'=>$teachingstaff,'select'=>$selete,'teacher'=>$teacher]);    }
else{
    $teachingstaff=Teaching_staff::with(['teacher','subject'])->where('staff_id',$request->teacher)->get();
    $teacher=User::all();
   $selete=$request->teacher;
   return view('admin/list_teachingstaff',['teachingstaffs'=>$teachingstaff,'select'=>$selete,'teacher'=>$teacher]);    }
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
    // return "f";
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

return view('admin/optional_subject_group',[
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
return view('admin/optional_subject_list',[
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

}

