
$('#passwordConfirm').keyup(function (e) {
    password= $('#password').val();
    passwordConfirm = $(this).val();
    if (password == passwordConfirm) {
        $('#message').html('<div class="alert alert-success" role="alert">Tag Added</div>');
    }
    else{
        $('#message').html('<div class="alert alert-danger" role="alert">Tag Added</div>');
    }
})