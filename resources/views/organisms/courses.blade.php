<div class="mt-10">
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @if(!empty($courses))
            @php
                $styles = ["card-purple", "card-red", "card-green", "card-blue"];
            @endphp
            @foreach($courses as $course)
                @include("atoms.course")
            @endforeach
         @endif
    </div>
</div>
