<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use  App\Models\Attendence;
use Excel;


class ExcelTeacher implements FromCollection,WithHeadings,WithMapping
{
    protected $id;
    protected $attendent;

    public function __construct($id)
    {
        $this->id = $id;
        
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $this->attendent= Attendence::with(['student','teaching_staff.subject'])->where('staff_id',$this->id)->get()
        ->groupBy('student_id')->
        map(function($data){
            return[
                'student'=>$data->first()->student,
                'total_classes' => $data->count(),
                'present' => $data->where('attendance', 'present')->count(),
            ];
        });

        return $this->attendent->values();
        
    }

    public function map($student):array{
       $totalClass=$student['total_classes'];
       $totalPresent= $student['present'];
       $sum=$totalPresent/$totalClass*100;
       $sum= number_format($sum,2).'%';
       return[
            $student['student']->enrollment_number,
            $student['student']->name,
            $student['total_classes'],
            $student['present'],
            $sum,
       ];
       
   
    }
    public function headings():array{
        
        return[
            'Enrollment Number',
            'Name',
            'Class',
            'Present',
            'Pertentage',
            
        ];
    
    }
}
