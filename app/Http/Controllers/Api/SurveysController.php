<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Survey;
use App\Models\Result;
use App\Models\Student;

class SurveysController extends Controller
{

    public function getSurveys(Request $request){
        $survey = Survey::get();
        return response() -> json([
            'status' => true ,
            'surveys' => $survey,
        ]);
    }

    public function addSurvey(Request $request){
            $survey = Survey::create([
                'subject' => $request->subject ,
                'year' => $request->year,
                'title' => $request->title,
                'degree' => $request->degree,
            ]);

            $yearStudent = Student::where("year" , $request->year)->get();
            for($n = 0; $n < count($yearStudent); $n++){
              Result::create([
                'survey_id' => $survey->id,
                'student_id' => $yearStudent[$n]->id,
                'degree' => 0,
                'full_degree' => $request->degree,
              ]);
            }
            return response() -> json([
                'status' => true ,
                'id' => $survey->id,
                'msg' => "survey added sucessfully"
            ]);
    }

    public function getSurveyId(Request $request){
        $survey = Survey::find($request->id);
        $results = Result::where("survey_id" , $survey->id)->get();
        for($n = 0; $n < count($results); $n++){
            $student_name = Student::find($results[$n]->student_id)->name;
            $student_image = Student::find($results[$n]->student_id)->image;
            $student_year = Student::find($results[$n]->student_id)->year;
            $student_username = Student::find($results[$n]->student_id)->username;

            $results[$n]->student_name = $student_name;
            $results[$n]->student_image = $student_image;
            $results[$n]->student_year = $student_year;
            $results[$n]->student_username = $student_username;
        }
        return response() -> json([
            'status' => true ,
            'survey' => $survey,
            'results' => $results,
        ]);
    }

    public function updateSurvey(Request $request){
        $survey = Survey::find($request->id);
        $survey->update([
            'subject' => $request->subject ,
            'year' => $request->year,
            'title' => $request->title,
            'degree' => $request->degree,
    ]);
        return response() -> json([
            'status' => true ,
            'msg' => "survey updated sucessfully"
        ]);
    }

    public function getResultId(Request $request){
        $result = Result::find($request->id);
        return response() -> json([
            'status' => true ,
            'result' => $result
        ]);
    }

    public function editResult(Request $request){
        $result = Result::find($request->id);
        $result->update([
            'degree' => $request->degree,
    ]);
        return response() -> json([
            'status' => true ,
            'msg' => "result updated sucessfully"
        ]);
    }

    public function deleteSurvey(Request $request){
        $survey = Survey::find($request->id);
        $survey->delete();
        return response() -> json([
            'status' => true ,
            'msg' => "survey deleted sucessfully"
        ]);
    }
}
