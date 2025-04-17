<!-- Modal container -->
<div class="fixed z-40 inset-0 overflow-y-auto hidden" id="modal-lost" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <!-- Background overlay with blur -->
        <div class="fixed inset-0 bg-[#001E5F] bg-opacity-90 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

        <!-- Modal dialog box -->
        <div class="inline-block align-bottom rounded-2xl text-left transform transition-all sm:my-12 sm:align-middle sm:max-w-lg sm:w-full relative overflow-hidden">
            <!-- Close button -->
            <button type="button" class="absolute top-4 right-4 z-50 text-white hover:text-[#7BFF00] transition-colors focus:outline-none" onclick="document.getElementById('modal-lost').classList.add('hidden')">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Modal content -->
            <div class="relative z-20 bg-gradient-to-b from-[#002780] to-[#0A0A2A] shadow-2xl rounded-2xl overflow-hidden">
                <!-- Top section with character -->
                <div class="px-6 pt-8 pb-4 flex justify-between items-start relative">
                    <div>
                        <div class="bg-[#FF5252] p-2 rounded-md inline-block mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2" id="modal-title">
                            Not Quite There Yet
                        </h2>
                        <p class="text-[#FF5252] font-medium">
                            Something didn't work as expected
                        </p>
                    </div>

                    <!-- Random House Character - Concerned Expression -->
                    @php
                        $characters = [
                            ['image' => 'engineer.png', 'bg' => 'bg-[#124C00]', 'name' => 'Engineer'],
                            ['image' => 'speedsters.png', 'bg' => 'bg-[#7A0025]', 'name' => 'Speedster'],
                            ['image' => 'hipsters.png', 'bg' => 'bg-[#3A005A]', 'name' => 'Hipster'],
                            ['image' => 'shadows.png', 'bg' => 'bg-[#00417A]', 'name' => 'Shadow']
                        ];
                        $helper = $characters[array_rand($characters)];
                    @endphp
                    <div class="absolute -top-6 -right-6 transform -rotate-12">
                        <div class="{{ $helper['bg'] }} p-3 rounded-full w-32 h-32 flex items-center justify-center relative">
                            <img src="{{ url('images/' . $helper['image']) }}" alt="{{ $helper['name'] }}" class="w-24 h-24 animate-pulse-slow">
                            <div class="absolute top-1 right-1 bg-[#FF5252] rounded-full w-8 h-8 flex items-center justify-center border-2 border-white">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message section -->
                <div class="px-6 py-4">
                    <div class="bg-[#001E5F] bg-opacity-50 rounded-xl p-4 border border-[#00417A]">
                        <p class="text-blue-100 leading-relaxed">
                            Don't worry! Learning to code is all about trial and error. The {{ $helper['name'] }} says that even the best programmers make mistakes.
                        </p>
                        <p class="text-blue-100 mt-3 leading-relaxed">
                            Let's analyze what went wrong and try a different approach. You're getting closer to the solution with each attempt!
                        </p>
                    </div>

                    <!-- Error details section -->
                    <div class="mt-4 bg-[#240000] bg-opacity-30 rounded-xl p-4 border border-[#FF5252] border-opacity-30">
                        <p class="text-[#FF5252] text-sm font-medium mb-1">Possible issues:</p>
                        <ul class="list-disc text-sm text-blue-100 pl-5 space-y-1">
                            <li>Check if your character reached the goal</li>
                            <li>Make sure you've used the right sequence of commands</li>
                            <li>Verify that you haven't hit any obstacles along the way</li>
                        </ul>
                    </div>
                </div>

                <!-- Actions section -->
                <div class="bg-[#0A0A2A] p-6 border-t border-[#00417A]">
                    <div class="flex justify-between gap-4">
                        <button type="button" onclick="document.getElementById('modal-lost').classList.add('hidden')"
                                class="py-2.5 px-4 bg-[#00417A] hover:bg-[#00508F] text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Get Hints
                        </button>
                        <button type="button" id="retry-button" onclick="location.reload()"
                                class="py-2.5 px-6 bg-[#FF5252] hover:bg-opacity-90 text-white font-bold rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Try Again
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Slow pulse animation for character */
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(0.95); }
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 2s infinite ease-in-out;
    }
</style>

