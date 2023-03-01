@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ url('css/pages/homepage.css') }}" />
    <link rel="stylesheet" href="{{ url('css/includes/animation.css') }}" />
@endsection

@section('content')

@include('organisms.header')

<div class="bg-[#e5d8fd] overflow-hidden">
    <div class="h-[100vh] w-full bg-[#9E6BF5]">
        <img class="absolute left-1/2 transform -translate-x-1/2 top-[-30%] animated fadeInDown" src="{{ url('images/homepage/home-bg.png') }}" >
        <img class="absolute max-h-[90vh] top-1/2 transform -translate-y-1/2 animated fadeInLeft" src="{{ url('images/homepage/flag.png') }}">
        <div class="container mx-auto px-4 h-full flex flex-col md:flex-row justify-center items-center">
            <div class="w-full md:w-[70%] z-10 mb-6 md:mb-0">
                <h1 class="font-[900] text-7xl md:text-9xl md:leading-[155px] text-[#FFFFFF] animated fadeInUp">5HQ1P</h1>
                <p class="font-sans font-black text-xs md:text-2xl leading-[39px] text-[#FFFFFF] mt-2 max-w-[600px] animated fadeInUpDelay">
                    Welcome to our platform where young kids can learn programming in Albanian!
                    <br> <br>
                    Our platform is designed to introduce programming to kids in a fun and engaging way.
                    We believe that every child should have the opportunity to learn to code and to understand how technology works.</p>
            </div>
            <div class="w-full md:w-[45%]">
                @include("atoms.hero")
            </div>
        </div>
    </div>
    <div class="h-full pb-20 bg-no-repeat w-full bg-[url('{{ url('images/homepage/section.svg') }}')] ">
        @include("organisms.courses",
            ["title" => "Kodimi me Blloqe 9-18 vjet",
            "color" => "text-white-900",
            "bg" => "gradient bg-gradient-to-b from-transparent to-white",
            "group" => 1
        ])
    </div>

    <div class="h-full pb-20 bg-no-repeat w-full z-10 relative">
        <svg class="absolute inset-0 left-[-60%]" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="#8A3FFC" d="M47.1,-14.6C56.3,13,55.7,44.4,37.9,58.9C20.2,73.4,-14.8,71,-39.7,53.2C-64.6,35.5,-79.5,2.4,-71.2,-24C-62.9,-50.4,-31.4,-70.1,-6.2,-68C19,-66,37.9,-42.2,47.1,-14.6Z" transform="translate(100 100)" />
        </svg>
        @include("organisms.courses", [
            "title" => "Kodimi me Shkrim 9-18 vjet",
            "color" => "text-black-700",
            "bg" => "bg-white bg-opacity-50 backdrop-filter backdrop-blur-lg",
            "group" => 2
            ])
    </div>
</div>


@endsection
