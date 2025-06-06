<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request){
        if($request->getPathInfo() == "/"){
            return self::homepage();
        }
    }

    public static function homepage(){
        $courses = Course::with("lessons.levels")->get()->toArray();
        foreach ($courses as &$course){
            $level_count = 0;
            foreach ($course["lessons"] as $lesson){
                $level_count += count($lesson["levels"]);
            }

            $course["lesson_count"] = count($course['lessons']);
            $course["level_count"] = $level_count;
        }

        return view("pages.homepage", compact("courses"));
    }
}
