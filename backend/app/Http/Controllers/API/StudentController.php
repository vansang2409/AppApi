<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function index(){
        $students = Student::all();
        return response()->json([
            'status'=> 200,
            'students'=>$students,
        ]);
    }
    public function store(Request $request){
         
        $validator = Validator::make($request->all(),[
           'name' => 'required|max:191',
           'course' => 'required|max:191',
           'email' => 'required|email|max:191',
           'phone' => 'required|max:15|min:10',
           
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validate_err'=> $validator->messages(),
            ]);
        } else {
        
                $student = new Student();
                $student->name = $request->input('name');
                $student->course = $request->input('course');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->save();

                return response()->json([
                    'status'=> 200,
                    'message'=>'Student had been added successfully !',
                ]);
        }        
    }

    public function edit($id)
    {
        $student = Student::find($id);
        if($student)
        {
            return response()->json([
                'status'=> 200,
                'student'=>$student,
            ]);
        }else
        {
            return response()->json([
                'status'=> 404,
                'message'=>'Student not found!',
            ]); 
        }
        
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'course' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|max:15|min:10',
            
         ]);
         if ($validator->fails()) {
             return response()->json([
                 'validate_err'=> $validator->messages(),
             ]);
         } else {
            $student = Student::find($id);
            if($student)
            {
                $student->name = $request->input('name');
                $student->course = $request->input('course');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->update();
    
                return response()->json([
                    'status'=> 200,
                    'message'=>'Student had been updated successfully !',
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message'=>'Student not found!',
                ]); 
            }
            
        }   
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status'=> 200,
            'message'=>'Student had been deleted successfully !',
        ]);
    }
}
