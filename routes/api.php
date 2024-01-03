<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api' /*, 'checkAdminToken:api-admin'*/] ,'prefix' =>'admins'] , function(){


    Route::post('get-home' , [App\Http\Controllers\Api\AdminController::class , 'getHome']);

    Route::post('login' , [App\Http\Controllers\Api\AdminController::class , 'login']);
    Route::post('logout' , [App\Http\Controllers\Api\AdminController::class , 'logout']);
    Route::post('get-admins' , [App\Http\Controllers\Api\AdminController::class , 'getAdmins']);
    Route::post('get-admin-id' , [App\Http\Controllers\Api\AdminController::class , 'getAdminId']);
    Route::post('add-admin' , [App\Http\Controllers\Api\AdminController::class , 'addAdmin']);
    Route::post('update-admin' , [App\Http\Controllers\Api\AdminController::class , 'updateAdmin']);
    Route::post('delete-admin' , [App\Http\Controllers\Api\AdminController::class , 'deleteAdmin']);


    Route::post('login-student' , [App\Http\Controllers\Api\StudentController::class , 'login']);
    Route::post('logout-student' , [App\Http\Controllers\Api\StudentController::class , 'logout']);
    Route::post('get-students' , [App\Http\Controllers\Api\StudentController::class , 'getStudents']);
    Route::post('get-student-id' , [App\Http\Controllers\Api\StudentController::class , 'getStudentId']);
    Route::post('get-student-surveys' , [App\Http\Controllers\Api\StudentController::class , 'getStudentSurveys']);
    Route::post('add-student' , [App\Http\Controllers\Api\StudentController::class , 'addStudent']);
    Route::post('update-student' , [App\Http\Controllers\Api\StudentController::class , 'updateStudent']);
    Route::post('delete-student' , [App\Http\Controllers\Api\StudentController::class , 'deleteStudent']);
    Route::post('send-notification' , [App\Http\Controllers\Api\StudentController::class , 'sendNotification']);


    Route::post('login-teacher' , [App\Http\Controllers\Api\TeacherController::class , 'login']);
    Route::post('logout-teacher' , [App\Http\Controllers\Api\TeacherController::class , 'logout']);
    Route::post('get-teachers' , [App\Http\Controllers\Api\TeacherController::class , 'getTeachers']);
    Route::post('get-teacher-id' , [App\Http\Controllers\Api\TeacherController::class , 'getTeacherId']);
    Route::post('add-teacher' , [App\Http\Controllers\Api\TeacherController::class , 'addTeacher']);
    Route::post('add-teacher-class' , [App\Http\Controllers\Api\TeacherController::class , 'addTeacherClass']);
    Route::post('remove-teacher-class' , [App\Http\Controllers\Api\TeacherController::class , 'removeTeacherClass']);
    Route::post('update-teacher' , [App\Http\Controllers\Api\TeacherController::class , 'updateTeacher']);
    Route::post('delete-teacher' , [App\Http\Controllers\Api\TeacherController::class , 'deleteTeacher']);
    Route::post('get-student-year' , [App\Http\Controllers\Api\TeacherController::class , 'getStudent']);


    Route::post('get-surveys' , [App\Http\Controllers\Api\SurveysController::class , 'getSurveys']);
    Route::post('get-survey-id' , [App\Http\Controllers\Api\SurveysController::class , 'getSurveyId']);
    Route::post('add-survey' , [App\Http\Controllers\Api\SurveysController::class , 'addSurvey']);
    Route::post('update-survey' , [App\Http\Controllers\Api\SurveysController::class , 'updateSurvey']);
    Route::post('delete-survey' , [App\Http\Controllers\Api\SurveysController::class , 'deleteSurvey']);
    Route::post('get-result-id' , [App\Http\Controllers\Api\SurveysController::class , 'getResultId']);
    Route::post('edit-result' , [App\Http\Controllers\Api\SurveysController::class , 'editResult']);


    Route::post('get-questions' , [App\Http\Controllers\Api\AdminController::class , 'getQuestions']);
    Route::post('get-question-id' , [App\Http\Controllers\Api\AdminController::class , 'getQuestionId']);
    Route::post('add-question' , [App\Http\Controllers\Api\AdminController::class , 'addQuestion']);
    Route::post('update-question' , [App\Http\Controllers\Api\AdminController::class , 'updateQuestion']);
    Route::post('delete-question' , [App\Http\Controllers\Api\AdminController::class , 'deleteQuestion']);


    Route::post('get-specalist' , [App\Http\Controllers\Api\AdminController::class , 'getSpecalists']);
    Route::post('get-specalist-id' , [App\Http\Controllers\Api\AdminController::class , 'getspecalistId']);
    Route::post('add-specalist' , [App\Http\Controllers\Api\AdminController::class , 'addSpecalist']);
    Route::post('update-specalist' , [App\Http\Controllers\Api\AdminController::class , 'updatespecalist']);
    Route::post('delete-specalist' , [App\Http\Controllers\Api\AdminController::class , 'deleteSpecalist']);

});
