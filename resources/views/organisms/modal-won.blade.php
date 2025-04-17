<!-- Modal container -->
<div class="fixed z-40 inset-0 overflow-y-auto hidden" id="modal-won" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <!-- Background overlay with blur -->
        <div class="fixed inset-0 bg-[#001E5F] bg-opacity-90 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

        <!-- Modal dialog box -->
        <div class="inline-block align-bottom rounded-2xl text-left transform transition-all sm:my-12 sm:align-middle sm:max-w-lg sm:w-full relative overflow-hidden">
            <!-- Confetti Animation Background -->
            <div class="absolute inset-0 z-0 opacity-20">
                <svg viewBox="0 0 1200 200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="h-full w-full">
                    <path d="M0,100 C150,200 350,0 500,100 C650,200 850,0 1000,100 C1150,200 1350,0 1500,100 V200 H0 Z" fill="#7BFF00"></path>
                </svg>
            </div>

            <!-- Close button -->
            <button type="button" class="absolute top-4 right-4 z-50 text-white hover:text-[#7BFF00] transition-colors focus:outline-none" onclick="document.getElementById('modal-won').classList.add('hidden')">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Success animation -->
            <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center pointer-events-none z-10">
                <div class="success-animation">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>
                </div>
            </div>

            <!-- Modal content -->
            <div class="relative z-20 bg-gradient-to-b from-[#002780] to-[#0A0A2A] shadow-2xl rounded-2xl overflow-hidden">
                <!-- Top section with character -->
                <div class="px-6 pt-8 pb-4 flex justify-between items-start relative">
                    <div>
                        <div class="bg-[#7BFF00] p-2 rounded-md inline-block mb-3">
                            <svg class="w-6 h-6 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2" id="modal-title">
                            You Did It!
                        </h2>
                        <p class="text-[#7BFF00] font-medium">
                            Level completed successfully
                        </p>
                    </div>

                    <!-- Random House Character Celebration -->
                    @php
                        $characters = [
                            ['image' => 'engineer.png', 'bg' => 'bg-[#124C00]', 'name' => 'Engineer'],
                            ['image' => 'speedsters.png', 'bg' => 'bg-[#7A0025]', 'name' => 'Speedster'],
                            ['image' => 'hipsters.png', 'bg' => 'bg-[#3A005A]', 'name' => 'Hipster'],
                            ['image' => 'shadows.png', 'bg' => 'bg-[#00417A]', 'name' => 'Shadow']
                        ];
                        $winner = $characters[array_rand($characters)];
                    @endphp
                    <div class="absolute -top-6 -right-6 transform rotate-12">
                        <div class="{{ $winner['bg'] }} p-3 rounded-full w-32 h-32 flex items-center justify-center">
                            <img src="{{ url('images/' . $winner['image']) }}" alt="{{ $winner['name'] }}" class="w-24 h-24 animate-bounce-slow">
                        </div>
                    </div>
                </div>

                <!-- Message section -->
                <div class="px-6 py-4">
                    <div class="bg-[#001E5F] bg-opacity-50 rounded-xl p-4 border border-[#00417A]">
                        <p class="text-blue-100 leading-relaxed">
                            Fantastic work! You've mastered this challenge and shown great problem-solving skills. The {{ $winner['name'] }} House is proud of your achievement!
                        </p>
                        <p class="text-blue-100 mt-3 leading-relaxed">
                            You've gained valuable coding skills that will help you tackle even more complex challenges ahead.
                        </p>
                    </div>
                </div>

                <!-- Stats and next actions -->
                <div class="bg-[#0A0A2A] p-6 border-t border-[#00417A]">
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="bg-[#001E5F] bg-opacity-70 rounded-lg px-4 py-2 flex-1">
                            <div class="text-xs text-[#7BFF00]">Code Quality</div>
                            <div class="text-white font-bold" id="code-quality-value">Excellent</div>
                        </div>
                        <div class="bg-[#001E5F] bg-opacity-70 rounded-lg px-4 py-2 flex-1" id="commands-used-stat">
                            <div class="text-xs text-[#7BFF00]">Commands Used</div>
                            <div class="text-white font-bold" id="commands-used-value">0</div>
                        </div>
                        <div class="bg-[#001E5F] bg-opacity-70 rounded-lg px-4 py-2 flex-1">
                            <div class="text-xs text-[#7BFF00]">Points Earned</div>
                            <div class="text-white font-bold" id="points-earned-value">+50</div>
                        </div>
                    </div>

                    <div class="flex justify-between gap-4">
                        <button type="button" onclick="document.getElementById('modal-won').classList.add('hidden')"
                                class="py-2.5 px-4 bg-[#00417A] hover:bg-[#00508F] text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Play Again
                        </button>
                        <div id="next-level-container">
                            <!-- Next level button will be added here dynamically -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Success Checkmark Animation */
    .success-animation {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: fadeInOut 3s forwards;
    }
    
    @keyframes fadeInOut {
        0% { opacity: 0; }
        30% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; }
    }
    
    .checkmark {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        stroke-width: 2;
        stroke: #7BFF00;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #7BFF00;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    
    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #7BFF00;
        fill: none;
        animation: stroke .6s cubic-bezier(0.650, 0.000, 0.450, 1.000) forwards;
    }
    
    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke .3s cubic-bezier(0.650, 0.000, 0.450, 1.000) .8s forwards;
    }
    
    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }
    
    @keyframes scale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.1, 1.1, 1); }
    }
    
    @keyframes fill {
        100% { box-shadow: inset 0px 0px 0px 80px rgba(123, 255, 0, 0.1); }
    }
    
    /* Slow bounce animation for character */
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite ease-in-out;
    }
</style>

