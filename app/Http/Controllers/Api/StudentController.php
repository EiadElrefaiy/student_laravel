<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

use App\Models\Survey;
use App\Models\Result;
use App\Models\Student;
use App\Models\Notification;


class StudentController extends Controller
{

    public function login(Request $request){
        $credntials = $request->only(['username' , 'password']);
       // $token = Auth::guard('api-admin')->attempt($credntials);
        $token = auth('api-student')->attempt($credntials);

        if(!$token){
            return response()->json([
                'status' => false,
                'msg' =>'This Admin is Not Found',
            ]);
        }
        $student = Auth::guard('api-student')->user();
        $student -> api_token = $token;

        return response() -> json([
            'status' => true ,
            'student' => $student
        ]);
    }

    public function logout(Request $request){
        $token = $request -> header('auth-token');
        if($token){
            try{
                JWTAuth::setToken($token)->invalidate();
            }catch(TokenInvalidException $e){
                return response()->json([
                    'status' => false,
                    'msg' =>'something went wrong',
                ]);
            }

            return response()->json([
                'status' => true,
                'msg' =>'logout successfully',
            ]);

        }
        else{
            return response()->json([
                'status' => false,
                'msg' =>'something went wrong',
            ]);
        }
    }

    public function getStudents(Request $request){
        $students = Student::get();
        for($n = 0; $n < count($students); $n++){
            $students[$n]->sum_degrees = Result::where("student_id" , $students[$n]->id)->sum('degree');
            $students[$n]->sum_full_degrees = Result::where("student_id" , $students[$n]->id)->sum('full_degree');
        }
        return response() -> json([
            'status' => true ,
            'students' => $students,
        ]);
    }

    public function addStudent(Request $request){
        if($request->image == "undefined"){
            $student = Student::create([
                'image' => "user.png" ,
                'year' => $request->year,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'attendance' => 0,
            ]);

            return response() -> json([
                'status' => true ,
                'id' => $student->id,
                'msg' => "student added sucessfully"
            ]);
        }

            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);

            $student = Student::create([
                'image' => $fileName ,
                'year' => $request->year,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'attendance' => 0,
            ]);

            return response() -> json([
                'status' => true ,
                'id' => $student->id,
                'msg' => "student added sucessfully"
            ]);
    }

    public function getStudentId(Request $request){
        $student = Student::find($request->id);
        $results = Result::where("student_id" , $request->id)->get();
        return response() -> json([
            'status' => true ,
            'student' => $student,
            'results' => $results,
        ]);
    }

    public function getStudentSurveys(Request $request){
        $student = Student::find($request->id);
        $results = Result::Where("student_id" , $student->id)->get();

        $degrees = 0;
        $full_degrees = 0;


        for($n = 0; $n < count($results); $n++){

            $survey_subject = Survey::find($results[$n]->survey_id)->subject;
            $survey_year = Survey::find($results[$n]->survey_id)->year;
            $survey_title = Survey::find($results[$n]->survey_id)->title;

            $results[$n]->subject = $survey_subject;
            $results[$n]->year = $survey_year;
            $results[$n]->title = $survey_title;        
        
            $degrees = $degrees + $results[$n]->degree;
            $full_degrees = $full_degrees + $results[$n]->full_degree;
        }

        if($request->type == "student"){
            $results = $results->where("subject" , $request->subject);
        }


        return response() -> json([
            'status' => true ,
            'results' => $results,
            'degrees' => $degrees,
            'full_degrees' => $full_degrees,
        ]);
        
    }

    public function updateStudent(Request $request){
        $student = Student::find($request->id);

        if($request->image == "undefined"){
            $student ->update([
                'year' => $request->year,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'attendance' => $request->attendance,
            ]);

            return response() -> json([
                'status' => true ,
                'msg' => "student updated sucessfully"
            ]);
        }

            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);

        $student->update([
            'image' => $fileName,
            'year' => $request->year,
            'name' => $request->name,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'attendance' => $request->attendance,
        ]);

        return response() -> json([
            'status' => true ,
            'msg' => "order updated sucessfully"
        ]);
    }

    public function deleteStudent(Request $request){
        $student = Student::find($request->id);
        $student->delete();

        return response() -> json([
            'status' => true ,
            'msg' => "student deleted sucessfully"
        ]);
    }


    public function sendNotification(Request $request){
        $student = Notification::create([
            'student_id' =>  $request->id,
            'message' => $request->message,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => "notification sent sucessfully"
        ]);
    }
}
