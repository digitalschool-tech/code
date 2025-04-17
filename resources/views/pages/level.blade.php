@extends('layouts.app', ['style' => 'flex'])

@section('content')
    <!-- Preload images -->
    <div style="display:none;">
        <img id="down" src="{{ url('images/level/player/down.png') }}" width="40" height="40" />
        <img id="up" src="{{ url('images/level/player/up.png') }}" width="40" height="40" />
        <img id="left" src="{{ url('images/level/player/left.png') }}" width="40" height="40" />
        <img id="right" src="{{ url('images/level/player/speedster/test.gif') }}" width="40" height="40" />
        <img id="grass_1" src="{{ url('images/level/grass/grass_1.png') }}" width="40" height="40" />
        <img id="grass_2" src="{{ url('images/level/grass/grass_2.png') }}" width="40" height="40" />
        <img id="grass_3" src="{{ url('images/level/grass/grass_3.png') }}" width="40" height="40" />
        @for ($i = 1; $i < 7; $i++)
            <img id="rock1_{{ $i }}" src='{{ url("images/level/obstacles/Rock1_$i.png") }}' width="40" height="40" />
        @endfor
        <img id="goal" src="{{ url('images/level/goal/goal.png') }}" width="40" height="40" />
    </div>

    <!-- Custom CSS for Blockly -->
    <style>
        /* Blockly Custom Styling */
        .blocklyMainBackground {
            fill: #0A0A2A !important;
            stroke: none !important;
        }
        
        .blocklyFlyoutBackground {
            fill: #001E5F !important;
            stroke: #00417A !important;
        }
        
        .blocklyToolboxDiv {
            background-color: #001E5F !important;
            color: white !important;
            border-right: 1px solid #00417A !important;
        }
        
        .blocklyScrollbarHandle {
            fill: #7BFF00 !important;
            stroke: #124C00 !important;
        }
        
        .blocklyPath {
            stroke-width: 1px !important;
        }
        
        .blocklySelected>.blocklyPath {
            stroke: #7BFF00 !important;
            stroke-width: 3px !important;
        }
        
        .blocklyEditableText rect {
            fill: rgba(123, 255, 0, 0.2) !important;
        }
        
        .blocklyText {
            fill: white !important;
        }
        
        .blocklyDropdownText {
            fill: white !important;
        }
        
        /* House Character Animation */
        .house-character {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 120px;
            height: 120px;
            z-index: 5;
            transition: all 0.3s ease;
            filter: drop-shadow(0 0 10px rgba(0,0,0,0.5));
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .house-character:hover {
            transform: scale(1.1);
        }
        
        /* Run button pulse */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(123, 255, 0, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(123, 255, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(123, 255, 0, 0); }
        }
        
        .pulse-button {
            animation: pulse 2s infinite;
        }
        
        /* Update house character styling for new position */
        .house-character-small {
            position: relative;
            z-index: 5;
            filter: drop-shadow(0 0 5px rgba(0,0,0,0.5));
        }
        
        .house-character-small:hover .tooltip-text {
            display: block;
        }
        
        /* Add animation for the hint popup */
        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .pop-in {
            animation: popIn 0.3s forwards;
        }
    </style>

    <!-- Main Game Area -->
    <div id="main" class="w-full h-full overflow-hidden bg-[#001E5F]" data-player="{{ $level["player"] }}" data-goal="{{ $level["goal"] }}" data-route="{{ $level["route"] }}" data-blocks="{{ $level["blocks"] }}">
        <!-- Top Navigation Bar -->
        <div class="w-full flex items-center justify-between h-14 px-6 bg-gradient-to-r from-[#00417A] to-[#001E5F] border-b border-[#00417A] shadow-lg">
            <div class="flex items-center gap-4">
                <a href="{{ route('course.show', ['id' => request()->route('course_id')]) }}" class="flex items-center gap-2 text-white hover:text-[#7BFF00] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Back to Course</span>
                </a>
            </div>
            
            <div class="flex items-center">
                <h1 class="text-xl text-white font-bold px-4 py-1.5 bg-[#0A0A2A] rounded-lg border border-[#00417A]">
                    <span class="text-[#7BFF00]">Level {{ $level["index"] }}:</span> {{ $level->title ?? 'Coding Challenge' }}
                </h1>
                </div>
            
            <div class="flex items-center gap-3">
                <button id="help-button" class="text-white px-3 py-1.5 bg-[#3A005A] rounded-lg hover:bg-opacity-80 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Help</span>
                </button>
                
                <button id="reset-button" class="text-white px-3 py-1.5 bg-[#7A0025] rounded-lg hover:bg-opacity-80 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Reset</span>
                </button>
            </div>
        </div>

        <!-- Main Content Area with Instructions, Blockly, and Output -->
        <div class="flex flex-row h-[calc(100%-3.5rem)]">
            <!-- Left Panel: Instruction and Blockly -->
            <div class="w-[60%] h-full flex flex-col">
                <!-- Instructions Collapsible Panel -->
                <div class="bg-[#0A0A2A] border-b border-[#00417A] relative">
                    <div class="flex items-center justify-between px-6 py-3" id="instructions-container">
                        <div class="flex items-center gap-2 cursor-pointer" id="instructions-toggle">
                            <div class="w-6 h-6 bg-[#7BFF00] rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-white font-bold">Instructions</p>
                        </div>
                        
                        <!-- House Character moved here, positioned to the right -->
                        @php
                            $characters = [
                                [
                                    'image' => 'engineer.png',
                                    'bg' => 'bg-[#124C00]',
                                    'name' => 'Engineer'
                                ],
                                [
                                    'image' => 'speedsters.png',
                                    'bg' => 'bg-[#7A0025]',
                                    'name' => 'Speedster'
                                ],
                                [
                                    'image' => 'hipsters.png',
                                    'bg' => 'bg-[#3A005A]',
                                    'name' => 'Hipster'
                                ],
                                [
                                    'image' => 'shadows.png',
                                    'bg' => 'bg-[#00417A]',
                                    'name' => 'Shadow'
                                ]
                            ];
                            $character = $characters[array_rand($characters)];
                        @endphp
                        
                        <div class="flex items-center gap-3">
                            <div class="house-character-small cursor-pointer transition-all hover:scale-110" id="helper-character-container">
                                <div class="{{ $character['bg'] }} p-1.5 rounded-full w-10 h-10 flex items-center justify-center">
                                    <img src="{{ url('images/' . $character['image']) }}" alt="{{ $character['name'] }}" 
                                         class="w-8 h-8 object-contain" id="helper-character">
                                </div>
                                <div class="tooltip-text hidden absolute bg-white rounded-lg px-2 py-1 text-xs text-[#001E5F] font-bold -right-8 -bottom-8 shadow-lg whitespace-nowrap">
                                    {{ $character['name'] }} will help you!
                                </div>
                            </div>
                            
                            <svg class="w-5 h-5 text-white cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="instructions-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="px-6 pb-4 pt-1" id="instructions-panel">
                        <div class="rounded-lg bg-[#001E5F] bg-opacity-50 p-4 backdrop-blur-sm border border-[#00417A] shadow-lg">
                            <p class="text-blue-100">{{ $level["description"] }}</p>
                            
                            <!-- Hints section (initially hidden) -->
                            <div class="mt-4 pt-4 border-t border-[#00417A] hidden" id="hints-section">
                                <p class="text-[#7BFF00] font-medium mb-2">Hints from {{ $character['name'] }}:</p>
                                <ul class="list-disc pl-5 text-blue-100 space-y-1">
                                    <li>Remember to use the correct sequence of commands</li>
                                    <li>Check your path to make sure it reaches the goal</li>
                                    <li>You can always reset and try again!</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Blockly Container -->
                <div class="flex-grow relative">
                    <div class="w-full flex items-center h-10 px-6 bg-gradient-to-r from-[#002780] to-[#0062E3]">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#7BFF00] rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <p class="text-white font-bold">Code Editor</p>
                        </div>
                    </div>
                    
                    <div id="blocklyDiv" class="w-full h-[calc(100%-2.5rem)]">
                        <!-- Blockly will be injected here -->
                    </div>
                </div>
            </div>
            
            <!-- Right Panel: Level Selector and Game Output -->
            <div class="w-[40%] h-full flex flex-col bg-[#0A0A2A] border-l border-[#00417A]">
                <!-- Game Output -->
                <div class="flex-grow">
                    <div class="w-full flex items-center h-10 px-6 bg-gradient-to-r from-[#002780] to-[#0062E3]">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#7BFF00] rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-white font-bold">Game Output</p>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col items-center">
                        <div id="canvas" class="rounded-lg bg-black bg-opacity-30 p-3 backdrop-blur-sm border-2 border-[#00417A] shadow-lg mb-6">
                            {{-- <canvas  class="w-[400px] h-[400px]"></canvas> --}}
                        </div>
                        
                        <button id="generate" class="bg-[#7BFF00] text-[#001E5F] px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition-all shadow-lg flex items-center gap-2 pulse-button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Run Code
                        </button>
                    </div>
                </div>
                
                <!-- Level Selector -->
                <div class="h-1/3 border-t border-[#00417A] overflow-y-auto">
                    <div class="w-full flex items-center justify-between px-6 py-3 bg-gradient-to-r from-[#002780] to-[#0062E3]">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#7BFF00] rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <p class="text-white font-bold">Level Progress</p>
                        </div>
                        
                        <!-- Progress display -->
                        <div class="flex items-center gap-1.5">
                            <div class="h-1.5 w-24 bg-[#00417A] rounded-full overflow-hidden">
                                @php
                                    $totalLevels = count($levels);
                                    $currentIndex = $level["index"];
                                    $progressPercent = ($currentIndex / $totalLevels) * 100;
                                @endphp
                                <div class="h-full bg-[#7BFF00]" style="width: {{ $progressPercent }}%"></div>
                            </div>
                            <span class="text-white text-xs">{{ $level["index"] }}/{{ $totalLevels }}</span>
                        </div>
                    </div>
                    
                    <div class="p-4 grid grid-cols-3 gap-3 max-h-[calc(100%-3rem)] overflow-y-auto">
                        @foreach($levels as $levelItem)
                            @php
                                $isCurrentLevel = $levelItem->id == $level["id"];
                                $isCompleted = $levelItem->status === 'completed' || $levelItem->status === 'mastered';
                                $isAvailable = $levelItem->is_available ?? false;
                            @endphp
                            
                            @if($isAvailable)
                                <a href="{{ route('level.show', ['course_id' => request()->route('course_id'), 'lesson_id' => request()->route('lesson_id'), 'level_id' => $levelItem->id]) }}" 
                                   class="block">
                            @else
                                <div class="block cursor-not-allowed" title="Complete previous levels first">
                            @endif
                                <div class="aspect-square rounded-lg flex flex-col items-center justify-center p-2 transition-all transform hover:scale-105
                                          {{ $isCurrentLevel ? 
                                             'bg-[#7BFF00] bg-opacity-20 border-2 border-[#7BFF00] text-white' : 
                                             ($isCompleted ? 
                                                'bg-[#002780] bg-opacity-60 text-white' : 
                                                ($isAvailable ? 
                                                    'bg-[#001E5F] bg-opacity-40 text-white' : 
                                                    'bg-[#001E5F] bg-opacity-40 text-gray-400')) }}">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-1
                                              {{ $isCurrentLevel ? 
                                                 'bg-[#7BFF00] text-[#001E5F]' : 
                                                 ($isCompleted ? 
                                                    'bg-[#7BFF00] text-[#001E5F]' : 
                                                    ($isAvailable ? 
                                                        'bg-[#00417A] text-white' : 
                                                        'bg-[#222] text-gray-400')) }}">
                                        @if($isCompleted)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @elseif(!$isAvailable)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        @else
                                            <span class="font-bold">{{ $levelItem->index }}</span>
                                        @endif
                                    </div>
                                    <span class="text-xs font-medium text-center">Level {{ $levelItem->index }}</span>
                                </div>
                            @if(!$isAvailable)
                                </div>
                            @else
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("organisms.modal-won")
    @include("organisms.modal-lost")
@endsection

@section('scripts')
    <script src="{{ mix('js/level.js') }}"></script>
    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to all elements we need
            const instructionsToggle = document.getElementById('instructions-toggle');
            const instructionsIcon = document.getElementById('instructions-icon');
            const instructionsPanel = document.getElementById('instructions-panel');
            const helperCharacter = document.getElementById('helper-character-container');
            const hintsSection = document.getElementById('hints-section');
            
            // Set up event listener for instructions toggle
            instructionsToggle.addEventListener('click', toggleInstructions);
            instructionsIcon.addEventListener('click', toggleInstructions);
            
            // Separate event handler for the helper character
            helperCharacter.addEventListener('click', function(e) {
                // Important: Stop the event from bubbling up to parent elements
                e.stopPropagation();
                
                // Make sure instructions are visible
                if (instructionsPanel.classList.contains('hidden')) {
                    instructionsPanel.classList.remove('hidden');
                    instructionsIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>';
                }
                
                // Show hints with animation
                hintsSection.classList.remove('hidden');
                hintsSection.classList.add('pop-in');
                
                // Visual feedback for character click
                this.classList.add('scale-125');
                setTimeout(() => {
                    this.classList.remove('scale-125');
                }, 300);
            });
            
            // Reset button functionality
            document.getElementById('reset-button').addEventListener('click', function() {
                // This would need to be integrated with your Blockly reset functionality
                location.reload();
            });
            
            // Function to toggle instructions panel
            function toggleInstructions() {
                if (instructionsPanel.classList.contains('hidden')) {
                    instructionsPanel.classList.remove('hidden');
                    instructionsIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>';
                } else {
                    instructionsPanel.classList.add('hidden');
                    instructionsIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
                }
            }
        });
    </script>
@endsection

<head>
    <!-- Other meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
