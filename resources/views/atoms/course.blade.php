<div class="w-full group bg-white-900 rounded-2xl flex relative overflow-hidden {{ $styles[random_int(0, 7)] }} {{ in_array($loop->index, [0, 5, 6]) ? "col-span-2" : "" }}">
    <img class="h-auto min-w-[100%] absolute -translate-x-2/3" src="{{ url('images/courses/course.svg') }}" alt=""/>
    <div class="w-1/3"></div>
    <div class="w-2/3 ml-2 flex flex-col py-4 pr-5 text-white-900">
        <h2 class="text-[22px] font-semibold">{{$course["name"]}}</h2>
        <p class="text-[12px] mt-3">{{$course["description"]}}</p>
        <div class="flex text-[10px] mt-auto group-hover:translate-y-0 translate-y-8 transition-all duration-300">
            <div class="flex items-center">
                <svg width="12" viewBox="0 0 9 12" class="mr-1"><g fill="none" fill-rule="evenodd"><g class="fill-current"><g><g><g><path d="M2.858 5.15v4.415c0 .197-.11.371-.273.436-.231.092-.51.14-.808.14-.855 0-1.775-.396-1.775-1.266v-5.65c-.02-.389.1-1.074.676-1.445C.945 1.607 2.348.589 3.052.074c.125-.092.286-.098.417-.018.132.081.214.237.214.406v.669c0 .255-.183.462-.41.462-.175 0-.325-.125-.383-.302-.636.462-1.574 1.14-1.806 1.29-.21.136-.255.385-.264.52 0 .151.029.27.081.335.145.18.63.068 1.157-.29C2.566 2.802 5.067.92 5.092.902c.126-.095.287-.104.42-.023.133.08.216.237.216.408v.052c0 .155-.068.299-.182.385 0 0-1.736 1.31-1.89 1.42-.589.428-.798.953-.798 2.005zM9 2.92v5.998c0 .158-.072.306-.191.39 0 0-2.385 2.092-2.869 2.425-.254.175-.578.267-.936.267-.85 0-1.73-.52-1.73-1.389V4.878l.001-.006c.008-.338.078-.82.635-1.285.334-.278 2.321-1.809 2.406-1.873.125-.097.288-.107.421-.027.134.08.218.237.218.408v.67c0 .254-.183.461-.409.461-.169 0-.314-.115-.376-.28-.635.49-1.566 1.212-1.775 1.385-.263.22-.298.365-.303.551.001.138.034.243.101.313.209.216.77.125 1.324-.25.41-.278 2.176-1.819 2.822-2.389.124-.108.29-.128.431-.05.14.077.23.237.23.414zm-.818 2.059L6.137 6.77v.924l2.045-1.792v-.924z"></path></g></g></g></g></g></svg>
                <span>{{ $course["lesson_count"] }} Lessons</span>
            </div>
            <div class="flex items-center justify-center ml-2">
                <svg width="13" viewBox="0 0 10 13" class="mr-1"><g fill="none" fill-rule="evenodd"><g><g><g><g><path class="fill-current" d="M5 2C2.25 2 0 4.25 0 7s2.25 5 5 5 5-2.25 5-5-2.25-5-5-5zm2.282 6.923L4.615 7.318v-3.01h.77v2.608l2.307 1.355-.41.652z"></path></g></g></g></g></g></svg>
                <span>{{ $course["level_count"] }} Levels</span>
            </div>
        </div>
        <a href="{{ route('course.show', ['id' => $course['id']]) }}" class="w-full bg-white-900 flex justify-center items-center font-semibold group-hover:translate-y-2 translate-y-10 rounded-2xl h-8 transition-all duration-300 cursor-pointer">
            <p class="text-center text-black-900 text-[12px]">Start Now</p>
        </a>
    </div>
</div>
