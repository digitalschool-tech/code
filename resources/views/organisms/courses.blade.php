@php
    $styles = ["card-purple", "card-red", "card-green", "card-blue", "card-yellow", "card-pink", "card-orange", "card-dark-blue"];
@endphp
<div class="container mx-auto px-4 pb-4 rounded-2xl h-full flex flex-col justify-start items-start z-10 {{ $bg ?? "" }}">
    <div class="mt-10">
        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @if(!empty($courses))
                @foreach($courses as $course)
                    @include("atoms.course")
                @endforeach
             @endif
        </div>
    </div>
</div>
