@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ url('css/pages/homepage.css') }}" />
    <link rel="stylesheet" href="{{ url('css/includes/animation.css') }}" />
@endsection

@section('content')
    @include('organisms.header')

    <div class="bg-[#001E5F] overflow-hidden">
        <!-- Hero Section with Houses Theme -->
        <div class="relative">
            <!-- Wave Pattern Background -->
            <div class="absolute inset-0 z-0 opacity-20">
                <svg viewBox="0 0 1200 200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                    class="h-full w-full">
                    <path d="M0,100 C150,200 350,0 500,100 C650,200 850,0 1000,100 C1150,200 1350,0 1500,100 V200 H0 Z"
                        fill="#4682B4"></path>
                </svg>
            </div>

            <!-- Main Hero Content -->
            <div class="container mx-auto px-4 relative z-10 py-36">
                <div class="flex flex-col lg:flex-row items-center">
                    <div class="w-full lg:w-1/2 text-white mb-10 lg:mb-0">
                        <div class="inline-block bg-[#7BFF00] p-2 mb-4">
                            <svg class="w-8 h-8 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-bold mb-6">Mësim si<br>dhe argëtim</h1>
                        <p class="text-xl text-blue-300 max-w-xl mb-8">
                            Nxënësit mësojnë si të programojnë lojëra, programe, webfaqe dhe aplikacione mobile.
                        </p>
                        <p class="text-gray-300 max-w-xl mb-8">
                            Përmev aktiviteteve të ndryshme, ata zhvillojnë edhe aftësi të rrjetësehimit përveç programimit
                            si: mendimi kritik, puna ekipore, aftësi udhëheqëse etj.
                        </p>

                        @guest
                            <!-- Show registration button for guests -->
                            <a href="{{ route('register') }}"
                                class="bg-[#7BFF00] text-[#001E5F] py-3 px-8 inline-block font-bold rounded-lg hover:bg-opacity-90 transition-all">
                                Regjistrohu Tani
                            </a>
                        @else
                            <!-- Show dashboard button for logged in users -->
                            <div class="flex items-center gap-4">
                                <a href="{{ route('dashboard') }}"
                                    class="bg-[#7BFF00] text-[#001E5F] py-3 px-8 inline-block font-bold rounded-lg hover:bg-opacity-90 transition-all">
                                    Vazhdo Mësimin
                                </a>

                                @if (auth()->user()->hasSelectedHouse())
                                    <!-- Show user's house info -->
                                    <div class="flex items-center bg-[#00417A] bg-opacity-50 rounded-lg pl-3 pr-4 py-2">
                                        <div
                                            class="w-10 h-10 {{ auth()->user()->getHouseColor() }} rounded-full flex items-center justify-center mr-3">
                                            <img src="{{ url('images/' . auth()->user()->getHouseIcon()) }}" alt="Your House"
                                                class="w-8 h-8 object-contain">
                                        </div>
                                        <div>
                                            <p class="text-sm text-blue-300">Your House</p>
                                            <p class="font-medium">{{ ucfirst(auth()->user()->house) }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endguest
                    </div>

                    <!-- Houses Shield Banner -->
                    <div class="w-full lg:w-1/2 flex justify-center">
                        <div class="grid grid-cols-2 gap-4 max-w-md">
                            <div
                                class="bg-[#124C00] p-3 rounded-lg transform hover:scale-105 transition-all shadow-lg max-w-40 max-h-40 overflow-hidden group">
                                <style>
                                    .engineers-outline {
                                        filter: drop-shadow(1px 0 0 white) drop-shadow(-1px 0 0 white) drop-shadow(0 1px 0 white) drop-shadow(0 -1px 0 white);
                                    }

                                    .group:hover .engineers-outline {
                                        filter: drop-shadow(2px 0 0 #7BFF00) drop-shadow(-2px 0 0 #7BFF00) drop-shadow(0 2px 0 #7BFF00) drop-shadow(0 -2px 0 #7BFF00) drop-shadow(1.5px 1.5px 0 #7BFF00) drop-shadow(-1.5px -1.5px 0 #7BFF00) drop-shadow(1.5px -1.5px 0 #7BFF00) drop-shadow(-1.5px 1.5px 0 #7BFF00);
                                    }
                                </style>
                                <img src="{{ url('images/engineer.png') }}" alt="Engineers House"
                                    class="w-full h-full object-contain transition-all duration-300 engineers-outline">
                            </div>
                            <div
                                class="bg-[#7A0025] p-3 rounded-lg transform hover:scale-105 transition-all shadow-lg max-w-40 max-h-40 overflow-hidden group">
                                <style>
                                    .speedsters-outline {
                                        filter: drop-shadow(1px 0 0 white) drop-shadow(-1px 0 0 white) drop-shadow(0 1px 0 white) drop-shadow(0 -1px 0 white);
                                    }

                                    .group:hover .speedsters-outline {
                                        filter: drop-shadow(2px 0 0 #FF5252) drop-shadow(-2px 0 0 #FF5252) drop-shadow(0 2px 0 #FF5252) drop-shadow(0 -2px 0 #FF5252) drop-shadow(1.5px 1.5px 0 #FF5252) drop-shadow(-1.5px -1.5px 0 #FF5252) drop-shadow(1.5px -1.5px 0 #FF5252) drop-shadow(-1.5px 1.5px 0 #FF5252);
                                    }
                                </style>
                                <img src="{{ url('images/speedsters.png') }}" alt="Speedsters House"
                                    class="w-full h-full object-contain transition-all duration-300 speedsters-outline">
                            </div>
                            <div
                                class="bg-[#3A005A] p-3 rounded-lg transform hover:scale-105 transition-all shadow-lg max-w-40 max-h-40 overflow-hidden group">
                                <style>
                                    .hipsters-outline {
                                        filter: drop-shadow(1px 0 0 white) drop-shadow(-1px 0 0 white) drop-shadow(0 1px 0 white) drop-shadow(0 -1px 0 white);
                                    }

                                    .group:hover .hipsters-outline {
                                        filter: drop-shadow(2px 0 0 #A034D9) drop-shadow(-2px 0 0 #A034D9) drop-shadow(0 2px 0 #A034D9) drop-shadow(0 -2px 0 #A034D9) drop-shadow(1.5px 1.5px 0 #A034D9) drop-shadow(-1.5px -1.5px 0 #A034D9) drop-shadow(1.5px -1.5px 0 #A034D9) drop-shadow(-1.5px 1.5px 0 #A034D9);
                                    }
                                </style>
                                <img src="{{ url('images/hipsters.png') }}" alt="Hipsters House"
                                    class="w-full h-full object-contain transition-all duration-300 hipsters-outline">
                            </div>
                            <div
                                class="bg-[#00417A] p-3 rounded-lg transform hover:scale-105 transition-all shadow-lg max-w-40 max-h-40 overflow-hidden group">
                                <style>
                                    .shadows-outline {
                                        filter: drop-shadow(1px 0 0 white) drop-shadow(-1px 0 0 white) drop-shadow(0 1px 0 white) drop-shadow(0 -1px 0 white);
                                    }

                                    .group:hover .shadows-outline {
                                        filter: drop-shadow(2px 0 0 #00A0FF) drop-shadow(-2px 0 0 #00A0FF) drop-shadow(0 2px 0 #00A0FF) drop-shadow(0 -2px 0 #00A0FF) drop-shadow(1.5px 1.5px 0 #00A0FF) drop-shadow(-1.5px -1.5px 0 #00A0FF) drop-shadow(1.5px -1.5px 0 #00A0FF) drop-shadow(-1.5px 1.5px 0 #00A0FF);
                                    }
                                </style>
                                <img src="{{ url('images/shadows.png') }}" alt="Shadows House"
                                    class="w-full h-full object-contain transition-all duration-300 shadows-outline">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-16 bg-gradient-to-b from-[#001E5F] to-[#0A0A2A]">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    @foreach ($courses as $index => $course)
                        @if ($index < 4)
                            <a href="{{ auth()->check() ? route('course.show', $course['id']) : route('login', ['redirect' => 'course/' . $course['id']]) }}"
                                class="bg-{{ $index == 0 ? '[#0062E3]' : ($index == 1 ? '[#7BFF00] text-[#001E5F]' : ($index == 2 ? '[#A034D9]' : '[#E03131]')) }} {{ $index != 1 ? 'text-white' : '' }} p-6 rounded-lg relative overflow-hidden group">
                                <div class="z-10 relative">
                                    <h3 class="text-3xl font-bold mb-2">{{ $course['name'] }}</h3>
                                    <p
                                        class="opacity-80 mb-4 text-sm transform transition-all duration-300 group-hover:translate-y-0">
                                        {{ $course['description'] }}
                                    </p>

                                    <!-- Stats that appear on hover -->
                                    <div
                                        class="flex text-xs mt-4 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <div class="flex items-center">
                                            <svg width="12" viewBox="0 0 9 12" class="mr-1 fill-current">
                                                <g fill="none" fill-rule="evenodd">
                                                    <g class="fill-current">
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="M2.858 5.15v4.415c0 .197-.11.371-.273.436-.231.092-.51.14-.808.14-.855 0-1.775-.396-1.775-1.266v-5.65c-.02-.389.1-1.074.676-1.445C.945 1.607 2.348.589 3.052.074c.125-.092.286-.098.417-.018.132.081.214.237.214.406v.669c0 .255-.183.462-.41.462-.175 0-.325-.125-.383-.302-.636.462-1.574 1.14-1.806 1.29-.21.136-.255.385-.264.52 0 .151.029.27.081.335.145.18.63.068 1.157-.29C2.566 2.802 5.067.92 5.092.902c.126-.095.287-.104.42-.023.133.08.216.237.216.408v.052c0 .155-.068.299-.182.385 0 0-1.736 1.31-1.89 1.42-.589.428-.798.953-.798 2.005zM9 2.92v5.998c0 .158-.072.306-.191.39 0 0-2.385 2.092-2.869 2.425-.254.175-.578.267-.936.267-.85 0-1.73-.52-1.73-1.389V4.878l.001-.006c.008-.338.078-.82.635-1.285.334-.278 2.321-1.809 2.406-1.873.125-.097.288-.107.421-.027.134.08.218.237.218.408v.67c0 .254-.183.461-.409.461-.169 0-.314-.115-.376-.28-.635.49-1.566 1.212-1.775 1.385-.263.22-.298.365-.303.551.001.138.034.243.101.313.209.216.77.125 1.324-.25.41-.278 2.176-1.819 2.822-2.389.124-.108.29-.128.431-.05.14.077.23.237.23.414zm-.818 2.059L6.137 6.77v.924l2.045-1.792v-.924z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                            </svg>
                                            <span>{{ $course['lesson_count'] }} Mësime</span>
                                        </div>
                                        <div class="flex items-center ml-3">
                                            <svg width="13" viewBox="0 0 10 13" class="mr-1 fill-current">
                                                <g fill="none" fill-rule="evenodd">
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path class="fill-current"
                                                                        d="M5 2C2.25 2 0 4.25 0 7s2.25 5 5 5 5-2.25 5-5-2.25-5-5-5zm2.282 6.923L4.615 7.318v-3.01h.77v2.608l2.307 1.355-.41.652z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                            <span>{{ $course['level_count'] }} Nivele</span>
                                        </div>

                                        <!-- Start Now button - Update text for auth state -->
                                        <div
                                            class="mt-4 transform translate-y-8 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                            <div
                                                class="inline-flex items-center bg-white {{ $index == 1 ? 'text-[#001E5F]' : 'text-' . ($index == 0 ? '[#0062E3]' : ($index == 2 ? '[#A034D9]' : '[#E03131]')) }} px-4 py-2 rounded-lg font-bold text-sm">
                                                {{ auth()->check() ? 'Fillo Tani' : 'Login për të Filluar' }}
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute -bottom-6 -right-6 w-24 h-24 {{ $index == 0 ? 'bg-[#00417A]' : ($index == 1 ? 'bg-[#124C00]' : ($index == 2 ? 'bg-[#3A005A]' : 'bg-[#7A0025]')) }} rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110">
                                        <img src="{{ url('images/' . ($index == 0 ? 'shadows.png' : ($index == 1 ? 'engineer.png' : ($index == 2 ? 'hipsters.png' : 'speedsters.png')))) }}"
                                            class="w-20 h-20 {{ $index == 0 ? 'shadows-outline' : ($index == 1 ? 'engineers-outline' : ($index == 2 ? 'hipsters-outline' : 'speedsters-outline')) }} transition-all duration-300 group-hover:thick-outline">
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="flex justify-center mb-12">
                    <div class="flex items-center space-x-2 bg-white bg-opacity-10 text-white px-6 py-3 rounded-full">
                        <span class="font-bold">CODE</span>
                        <span class="text-[#7BFF00] font-bold">•</span>
                        <span class="font-bold">IMPROVISE</span>
                        <span class="text-[#7BFF00] font-bold">•</span>
                        <span class="font-bold">OVERCOME</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Section with Blue Gradient -->
        <div class="bg-gradient-to-b from-[#00417A] to-[#001E5F] py-16">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="w-full md:w-1/2 mb-8 md:mb-0">
                        <div class="bg-[#7BFF00] p-2 inline-block mb-4">
                            <svg class="w-8 h-8 text-[#001E5F]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <h2 class="text-5xl text-white font-bold mb-6">Keni nevojë për ndihmë?</h2>
                        <p class="text-blue-200 text-xl mb-6">NA LEJONI TË JU NDIHMOJMË.<br>
                            @guest
                                Lini numrin tuaj me poshtë dhe ne ju kontaktojmë.
                            @else
                                Faleminderit që jeni pjesë e MSO Academy, {{ auth()->user()->name }}!
                            @endguest
                        </p>

                        <div class="flex">
                            @guest
                                <a href="{{ route('contact') }}"
                                    class="bg-[#A034D9] text-white px-6 py-3 rounded-l-md font-bold">Contact</a>
                                <a href="tel:044666666"
                                    class="bg-[#A034D9] bg-opacity-70 text-white px-6 py-3 rounded-r-md font-bold">044 666
                                    666</a>
                            @else
                                <a href="{{ route('support') }}"
                                    class="bg-[#A034D9] text-white px-6 py-3 rounded-l-md font-bold">Support Center</a>
                                <a href="{{ route('dashboard') }}"
                                    class="bg-[#A034D9] bg-opacity-70 text-white px-6 py-3 rounded-r-md font-bold">My
                                    Dashboard</a>
                            @endguest
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 flex justify-center">
                        <img src="{{ url('images/logo.png') }}" alt="Student" class="max-w-full md:max-w-md">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
