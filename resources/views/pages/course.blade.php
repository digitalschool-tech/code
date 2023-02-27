@extends('layouts.app')

@section('content')
@include('organisms.header')

<div class="h-full w-full bg-[#9E6BF5]">
    <div class="container mx-auto px-4 h-full pt-[140px] pb-20">
        <h1 class="text-5xl text-white-900 mb-2">{{ $course["name"] }}</h1>
        <p class="text-white-900 mb-4">{{ $course["description"] }}</p>
        <table class="w-full text-left my-2 bg-white-900">
            <thead>
                <tr>
                    <th>Mesimi</th>
                    <th>Progresi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course["lessons"] as $lesson)
                    <div>
                        <td>{{ $lesson["name"] }}</td>
                        <td>
                            <div class="flex w-full gap-2">
                                @foreach ($lesson["levels"] as $index => $level)
                                    <a href="/kursi/{{ $course['id'] }}/mesimi/{{ $lesson["id"] }}/niveli/{{ $level["id"] }}">
                                        <div class="w-8 h-8 rounded-full bg-purp-100 border-black-900 flex justify-center items-center border-2">
                                            <span class="text-white-900">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </td>
                        </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
