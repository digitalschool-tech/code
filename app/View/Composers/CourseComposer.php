<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Helpers\CourseStyleHelper;
use Illuminate\Support\Facades\Auth;

class CourseComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Add user house style if they have selected one
            if ($user->hasSelectedHouse()) {
                $view->with('userHouseStyle', CourseStyleHelper::getHouseStyle($user->house));
            }
        }
    }
} 