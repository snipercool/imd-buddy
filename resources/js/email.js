$("input[name='email']").keyup(function () {
    let value = $(this).val();
    console.log(value);
    if (value.includes('@student.thomasmore.be') || value.length == 0) {
        $('#emailError').addClass('d-none');
    }
    else{
        $('#emailError').removeClass('d-none');
    }
})