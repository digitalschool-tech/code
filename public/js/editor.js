
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
        // codeEditor.setValue(defaultCode);
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
            console.log(data)
            $('.editor__console-logs').html(data);
        });
    }

})


resetCodeBtn.addEventListener('click', () => {
    // Clear ace editor
    codeEditor.setValue('');
})

editorLib.init();