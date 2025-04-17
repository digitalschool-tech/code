<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LevelButton extends Component
{
    public $level;
    public $isLocked;
    public $isCompleted;
    public $isCurrent;
    public $courseId;
    public $lessonId;
    public $index;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($level, $isLocked, $isCompleted, $isCurrent, $courseId, $lessonId, $index)
    {
        $this->level = $level;
        $this->isLocked = $isLocked;
        $this->isCompleted = $isCompleted;
        $this->isCurrent = $isCurrent;
        $this->courseId = $courseId;
        $this->lessonId = $lessonId;
        $this->index = $index;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.level-button');
    }
} 