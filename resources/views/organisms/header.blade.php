<nav id="menu" class="fixed container top-[40px] flex items-center py-4 px-6 left-1/2 transform shadow-xl -translate-x-1/2 duration-500 transition-all z-20 h-16 w-full bg-[#001E5F] rounded-3xl">
    <!-- Logo Area -->
    <div class="flex items-center">
        <div class="bg-[#7BFF00] p-1.5 rounded-lg mr-3">
            <svg class="w-6 h-6 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
        </div>
        <a href="{{ route('home') }}" class="text-2xl text-white font-bold">ACADEMY</a>
    </div>
    
    <!-- Navigation Menu -->
    <ul class="ml-auto flex items-center gap-6 text-white font-medium">
        <li>
            <a href="{{ route('home') }}" class="hover:text-[#7BFF00] transition-colors">Home</a>
        </li>
        <li>
            <a href="{{ route('courses') }}" class="hover:text-[#7BFF00] transition-colors">Courses</a>
        </li>
        
        @auth
            <!-- House Icon -->
            @if(auth()->user()->hasSelectedHouse())
                <li>
                    <div class="w-8 h-8 {{ auth()->user()->getHouseColor() }} rounded-full flex items-center justify-center transform hover:scale-110 transition-all">
                        <img src="{{ url('images/' . auth()->user()->getHouseIcon()) }}" alt="Your House" class="w-6 h-6 object-contain">
                    </div>
                </li>
            @endif
            
            <!-- User dropdown -->
            <li class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 hover:text-[#7BFF00] transition-colors focus:outline-none">
                    <span>{{ auth()->user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-[#001E5F] rounded-lg shadow-lg py-2 border border-[#00417A] z-50">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-white hover:bg-[#00417A] transition-colors">
                        Dashboard
                    </a>
                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-white hover:bg-[#00417A] transition-colors">
                        My Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-[#00417A] mt-1 pt-1">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-white hover:bg-[#00417A] transition-colors">
                            Log Out
                        </button>
                    </form>
                </div>
            </li>
        @else
            <!-- Guest links -->
            <li>
                <a href="{{ route('login') }}" class="hover:text-[#7BFF00] transition-colors">Log In</a>
            </li>
            
            <!-- Register Button -->
            <li>
                <a href="{{ route('register') }}" class="bg-[#7BFF00] text-[#001E5F] px-4 py-2 rounded-lg font-bold hover:bg-opacity-90 transition-all">Join Us!</a>
            </li>
        @endauth
    </ul>
</nav>