$(document).ready(function () {
    $("#loginForm").submit(function (e) {
        e.preventDefault();
        validateForm();
    });
});

function validateForm() {
    const username = $("input#username").val();
    const password = $("input#password").val();
    const remember = $("input#remember").is(":checked") ?  true : false;
    const data =  { username : username, password : password, remember : remember };

    const url = $("#loginForm").attr('data-url')

    $.ajax({
        url: url,
        data: data,
        type: "GET",
        success: function (data) {
            data.username ? $('#email-error').html(data.username) : $('#email-error').html('');
            data.password ? $('#password-error').html(data.password) : $('#password-error').html('');
            data.incorrectLoginInfo ? $('#email-incorrectLoginInfo').html(data.incorrectLoginInfo) : $('#email-incorrectLoginInfo').html('');

            if(data.status){
                location.reload(true);
            }
        },
    });
}
