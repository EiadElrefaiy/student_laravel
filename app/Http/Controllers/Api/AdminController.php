<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;


use App\Models\Admin;

class AdminController extends Controller
{
    public function login(Request $request){
        $credntials = $request->only(['username' , 'password']);
       // $token = Auth::guard('api-admin')->attempt($credntials);
        $token = auth('api-admin')->attempt($credntials);

        if(!$token){
            return response()->json([
                'status' => false,
                'msg' =>'This Admin is Not Found',
            ]);
        }
        $admin = Auth::guard('api-admin')->user();
        $admin -> api_token = $token;

        return response() -> json([
            'status' => true ,
            'admin' => $admin
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



    public function getAdmins(Request $request){
        $admin = Admin::get();
        return response() -> json([
            'status' => true ,
            'admin' => $admin,
        ]);
    }

    public function addAdmin(Request $request){

            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);

            $admin = Admin::create([
                'image' => $fileName,
                'name' => $request->name,
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'position' => 2,
            ]);

            return response() -> json([
                'status' => true ,
                'id' => $admin->id,
                'msg' => "admin added sucessfully"
            ]);
    }


    public function getAdminId(Request $request){
        $admin = Admin::find($request->id);
        return response() -> json([
            'status' => true ,
            'admin' => $admin,
        ]);
    }



    public function updateAdmin(Request $request){
        $student = Admin::find($request->admin_id);
        $student->update([
            'image' => $request->image,
            'name' => $request->name,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        return response() -> json([
            'status' => true ,
            'msg' => "admin updated sucessfully"
        ]);
    }

    public function deleteAdmin(Request $request){
        $student = Admin::find($request->admin_id);
        $student->delete();

        return response() -> json([
            'status' => true ,
            'msg' => "admin deleted sucessfully"
        ]);
    }

}
