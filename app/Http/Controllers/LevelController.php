<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorelevelRequest;
use App\Http\Requests\UpdatelevelRequest;
use App\Models\level;
use App\Models\lesson;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.level");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorelevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorelevelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(level $level, $course_id, $lesson_id, $level_id)
    {
        $level = level::where("lesson_id", $lesson_id)->where("index", $level_id)->first();

        if(empty($level)){
            abort(404);
        }

        $lesson = lesson::where("id", $lesson_id)->with("levels")->first();
        $levels = $lesson["levels"];
        return view("pages.level", compact("level", "levels"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelevelRequest  $request
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatelevelRequest $request, level $level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(level $level)
    {
        //
    }
}
