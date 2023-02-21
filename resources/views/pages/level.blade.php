@extends('layouts.app')

@section('content')
    <div style="display:none;">
        <img id="down" src="{{ url('images/level/player/down.png') }}" width="40" height="40" />
        <img id="up" src="{{ url('images/level/player/up.png') }}" width="40" height="40" />
        <img id="left" src="{{ url('images/level/player/left.png') }}" width="40" height="40" />
        <img id="right" src="{{ url('images/level/player/right.png') }}" width="40" height="40" />
        <img id="grass_1" src="{{ url('images/level/grass/grass_1.png') }}" width="40" height="40" />
        <img id="grass_2" src="{{ url('images/level/grass/grass_2.png') }}" width="40" height="40" />
        <img id="grass_3" src="{{ url('images/level/grass/grass_3.png') }}" width="40" height="40" />
        @for ($i = 1; $i < 7; $i++)
            <img id="rock1_{{ $i }}" src='{{ url("images/level/obstacles/Rock1_$i.png") }}' width="40" height="40" />
        @endfor
        <img id="goal" src="{{ url('images/level/goal/goal.png') }}" width="40" height="40" />
    </div>
    <div id="main" class="w-full h-full overflow-hidden" data-player="{{ $level["player"] }}" data-goal="{{ $level["goal"] }}" data-route="{{ $level["route"] }}">
        <div class="w-full">
            <div class="w-full flex items-center h-10 px-6 bg-purp-200">
                <p class="text-white-900 h-full border-b-4 border-white-900 flex items-center">Instruksionet</p>
            </div>
            <div class="bg-white-500 h-fit p-6 pb-10">
                <div class="rounded-2xl bg-white-900 p-4 ">
                    <p>{{ $level["description"] }}</p>
                </div>
            </div>
        </div>
        <div class="w-full flex h-full flex-row">
            <div class="w-[70%] h-full">
                <div class="w-full flex flex-col justify-start items-start h-10 px-6 bg-purp-200">
                    <p class="text-white-900 h-full border-b-4 border-white-900 flex items-center">Pjesa e kodit</p>
                </div>
                <div id="blocklyDiv" class="bg-white-100 w-full h-full">

                </div>
            </div>
            <div class="w-[30%] h-full">
                <div class="w-full flex flex-col justify-start items-start h-10 px-6 bg-purp-200">
                    <p class="text-white-900 h-full border-b-4 border-white-900 flex items-center">Rezultati</p>
                </div>
                <div class="bg-white-300 w-full h-full flex items-center flex-col">
                    <canvas id="canvas" class="w-[320px] h-[320px] my-4"></canvas>
                    <button id="generate">Generate</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('js/level.js') }}"></script>
@endsection
