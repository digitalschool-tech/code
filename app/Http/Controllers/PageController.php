<?php

namespace App\Http\Controllers;

use App\Models\course;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request){
        if($request->getPathInfo() == "/"){
            return self::homepage();
        }
    }

    public static function homepage(){
        $courses = course::all()->toArray();
        return view("pages.homepage", compact("courses"));
    }
}
