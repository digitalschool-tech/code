@extends('layouts.app')

@section('content')
    <div class="w-full h-full overflow-hidden">
        <div class="w-full">
            <div class="w-full flex items-center h-10 px-6 bg-purp-200">
                <p class="text-white-900 h-full border-b-4 border-white-900 flex items-center">Instruksionet</p>
            </div>
            <div class="bg-white-500 h-fit p-6 pb-10">
                <div class="rounded-2xl bg-white-900 p-4 ">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
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