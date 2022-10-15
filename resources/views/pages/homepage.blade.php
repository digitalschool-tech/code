@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ url('css/pages/homepage.css') }}" />
    <link rel="stylesheet" href="{{ url('css/includes/animation.css') }}" />
@endsection

@section('content')

<div>
    <div class="h-[100vh] w-full bg-[#9E6BF5]">
        <img class="absolute left-1/2 transform -translate-x-1/2 top-[-30%] animated fadeInDown" src="{{ url('images/homepage/home-bg.png') }}" >
        <img class="absolute max-h-[90vh] top-1/2 transform -translate-y-1/2 animated fadeInLeft" src="{{ url('images/homepage/flag.png') }}">
        <div class="container mx-auto px-4 h-full flex justify-center items-center">
            <div class="w-[70%] z-10">
                <h1 class="font-[900] text-9xl leading-[155px] text-[#FFFFFF] animated fadeInUp">5HQ1P</h1>
                <p class="text-[32px] leading-[39px] text-[#FFFFFF] mt-2 max-w-[600px] animated fadeInUpDelay">During the last 6 months, I have developed my very own Albanian Programming Language, complete with its Python Interpreter.
                    The use cases could be varied from.</p>
            </div>
            @include("atoms.hero")
        </div>
    </div>
    <div class="h-[100vh] bg-no-repeat w-full bg-[url('{{ url('images/homepage/section.svg') }}')] ">

    </div>
</div>

@endsection
