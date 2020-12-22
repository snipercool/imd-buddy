let patt = new RegExp(/(.*)\/(.*)\/(.*)/, 'g');
let execute = patt.exec(window.location.href);
let url = (execute && execute.length > 0 ? execute[1] : '') + "/api/createtags";

$(document).on('click', '#createSkill', function (e) {
    let value = $('#types').val();
    const _token = window.Laravel.csrfToken;
    $.ajax({
        url: url,
        method: "POST",
        data: {
            value: value,
            _token: _token
        },
        success: function (result){
            
            $('#types').val('');
            $('#traits').append(value + ',').show();
            console.log(result['success']);
            console.log('this logged');
            
            $('#message').html(result['success']);
        },
        error: function (result) {
            $('#message').html(result['error']);
        }
    })

    e.preventDefault();
});
