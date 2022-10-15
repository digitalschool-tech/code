@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ url('css/pages/sandbox.css') }}" />
@endsection

@section('content')

<div class="editor">
  <div class="editor__wrapper">
      <div class="editor__body">
          <div id="editorCode" class="editor__code"></div>
      </div>
      <div class="editor__footer">
          <div class="editor__footer--left">
              <button id="submit" class="editor__btn editor__run">Run ></button>
              <button class="editor__btn editor__reset">Reset ></button>
          </div>
          <div class="editor__footer--right">
              <div class="editor__console">
                  <ul class="editor__console-logs"></ul>
              </div>
          </div>
      </div>
  </div>
</div>


{{-- <form id="runCode">
<div class="flex justify-center">
    <div class="mb-3 xl:w-96">
      <label for="exampleFormControlTextarea1" class="form-label inline-block mb-2 text-gray-700"
        >Code Here:</label>
      <textarea id="code"
        class="
          form-control
          block
          w-full
          px-3
          py-1.5
          text-base
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
        "
        id="exampleFormControlTextarea1"
        rows="3"
        value=""
        placeholder="Your message" required
      ></textarea>
    </div>
  </div>
  <div class="flex space-x-2 justify-center">
    <button id="submit"
      type="button"
      class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
    >Submit Code</button>
  </div>

</form>

<div class="col-span-8">
    <div class="terminal-window w-full mt-4">
        <div class="terminal-body">
            <span class="prompt inline ">:\{{substr (Request::root(), 7)}}{{ '>' }}</span>
            <span id="result" class="prompt inline whitespace-pre-line">run code to get the result </span>
        </div>
    </div>
</div> --}}


<script>


</script>

@endsection
