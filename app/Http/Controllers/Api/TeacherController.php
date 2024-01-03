<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\TClass;


class TeacherController extends Controller
{

    public function login(Request $request){
        $credntials = $request->only(['username' , 'password']);
       // $token = Auth::guard('api-admin')->attempt($credntials);
        $token = auth('api-teacher')->attempt($credntials);

        if(!$token){
            return response()->json([
                'status' => false,
                'msg' =>'This Admin is Not Found',
            ]);
        }
        $teacher = Auth::guard('api-teacher')->user();
        $teacher -> api_token = $token;

        return response() -> json([
            'status' => true ,
            'teacher' => $teacher
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

    public function getTeachers(Request $request){
        $teachers = Teacher::get();
        return response() -> json([
            'status' => true ,
            'teachers' => $teachers,
        ]);
    }

    public function addTeacher(Request $request){

        if($request->image == "undefined"){
            $teacher = Teacher::create([
                'image' => "user.png" ,
                'subject' => $request->subject,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
            ]);

            $teacher_admin = Admin::create([
                'image' => "user.png" ,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'position' => 3,
            ]);

            return response() -> json([
                'status' => true ,
                'id' => $teacher->id,
                'msg' => "teacher added sucessfully"
            ]);
        }

            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);

            $teacher = Teacher::create([
                'image' => $fileName ,
                'subject' => $request->subject,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
            ]);
            
            $teacher_admin = Admin::create([
                'image' => $fileName ,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'position' => 3,
            ]);


            return response() -> json([
                'status' => true ,
                'id' => $teacher->id,
                'msg' => "teacher added sucessfully"
            ]);
    }

    public function addTeacherClass(Request $request){
        $existed = TClass::where("teacher_id" , $request->teacher_id)->where('year' , $request->year)->get();
        if(count($existed) == 0){
            TClass::create([
                'teacher_id' => $request-> teacher_id,
                'year' => $request->year,
            ]);    
            return response() -> json([
                'msg' => "teacher class added sucessfully"
            ]);
        }
    }

    public function removeTeacherClass(Request $request){
        $existed = TClass::where("teacher_id" , $request-> teacher_id)->where('year' , $request->year)->get();
        if(count($existed) != 0){
           $tclass = TClass::find($existed[0]->id);
           $tclass->delete();
           return response() -> json([
                'msg' => "teacher class removed sucessfully"
            ]);
        }
    }

    public function getTeacherId(Request $request){
        $teacher = Teacher::find($request->id);
        $teacher_classes = TClass::where("teacher_id" , $request->id)->get();
        return response() -> json([
            'status' => true ,
            'teacher' => $teacher,
            'teacher_classes' => $teacher_classes,
            
        ]);
    }

    public function updateTeacher(Request $request){
        $teacher = Teacher::find($request->id);

        if($request->image == "undefined"){
            $teacher ->update([
                'subject' => $request->subject,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
            ]);

            return response() -> json([
                'status' => true ,
                'msg' => "teacher updated sucessfully"
            ]);
        }

            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);

        $teacher->update([
            'image' => $fileName,
            'subject' => $request->subject,
            'name' => $request->name,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        return response() -> json([
            'status' => true ,
            'msg' => "teacher updated sucessfully"
        ]);
    }

    public function deleteTeacher(Request $request){
        $teacher = Teacher::find($request->id);
        $teacher->delete();

        return response() -> json([
            'status' => true ,
            'msg' => "teacher deleted sucessfully"
        ]);
    }
    
    public function getStudent(Request $request){
        $students = Student::where("year" , $request->year)->get();
        return response() -> json([
            'status' => true ,
            'students' => $students
        ]);
    }
}
