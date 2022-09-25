@extends('layouts.app')
@section('content')

<form id="runCode">
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
            <span class="prompt inline">:\{{substr (Request::root(), 7)}}{{ '>' }}</span> <span id="result" class="prompt inline">run code to get the result </span>
        </div>
    </div>
</div>


<script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $(document).on('click', '#submit', function(e) {
        e.preventDefault();
        var code = $('#code').val();
        if(code == '' || code == ' '){
            return;
        }else{
            // runCode(code);
            const data = new FormData();
            data.append("text", "~ Function for Fizzbuzz(kafesheqer) in 5HQ1P\n\nprinto(\"Pershendetje Bote!\")\n\nper fizzbuzz = 0 deri 51 tani\n    nese fizzbuzz % 3 == 0 edhe fizzbuzz % 5 == 0 tani\n        printo(\"fizzbuzz\")\n        vazhdo\n\n    tjeter fizzbuzz % 3 == 0 tani\n        printo(\"fizz\")\n        vazhdo\n\n    tjeter fizzbuzz % 5 == 0 tani\n        printo(\"buzz\")\n        vazhdo\n    fund\n\n    printo(fizzbuzz)\nfund");

            const xhr = new XMLHttpRequest();
            xhr.withCredentials = true;

            xhr.addEventListener("readystatechange", function () {
            if (this.readyState === this.DONE) {
                console.log(this);
                // $('#result').html(this.responseText);
            }
            });

            xhr.open("POST", "http://127.0.0.1:8000/compile-sq");

            xhr.send(data);
        }
        
    })

    function runCode(code) {
        var baseUrl = 'http://127.0.0.1:8000/compile-sq';
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
                    url: baseUrl,
                    type:"POST",
                    // contentType: 'multipart/form-data',
                    data:{
                        text: code,
                        _token: _token,
                    },
                    success:function(result) {
                        console.log(result)
                        $('#result').html(result);
                    },
                    error:function (response) {
                        console.log(response);
                    }
                });
    }

</script>

@endsection