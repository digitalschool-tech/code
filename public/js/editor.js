$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const resetCodeBtn = document.querySelector('.editor__reset');

let codeEditor = ace.edit("editorCode");


let editorLib = {
    init() {
        // Configure Ace

        // Theme
        codeEditor.setTheme("ace/theme/dreamweaver");

        // Set language
        codeEditor.session.setMode("ace/mode/python");

        // Set Options
        codeEditor.setOptions({
            // fontFamily: 'Inconsolata',
            fontSize: '12pt',
            enableBasicAutocompletion: true,
            enableLiveAutocompletion: true,
        });

        // Set Default Code
        codeEditor.setValue(`per i = 0 deri 10 hap 2 tani
    printo(i)
fund`);

    }
}

$(document).on('click', '#submit', function(e) {
    e.preventDefault();
    var code = $('#code').val();
    if(code == '' || code == ' '){
        return;
    }else{
        $.post("/sandbox/runCode", {
            code: codeEditor.getValue()
        },
        function(data){
            $('.editor__console-logs').html(data.replace(/\r\n|\r|\n/g,"<br>"));
        });
    }
})


resetCodeBtn.addEventListener('click', () => {
    // Clear ace editor
    codeEditor.setValue('');
})

editorLib.init();
