let patt = new RegExp(/(.*)\/(.*)\/(.*)/, 'g');
let execute = patt.exec(window.location.href);
let url = (execute && execute.length > 0 ? execute[1] : '') + "/api/autocomplete";
placement = document.getElementById('suggestions');

$('#types').keyup(function (e) {
    let value = $(this).val();    
    if (value == '') {
        $('#suggestions').html('');
    } else {
        const _token = window.Laravel.csrfToken;
        $.ajax({
            url: url,
            method: "POST",
            data: {
                value: value,
                _token: _token
            },
            success: function (result) {
                $('#suggestions').css('display', 'block');
                $('#message').html('');

                let option = [];
                for (let i = 0; i < result.length; i++) {
                    option.push(`<li for="skill" class="list-group-item suggestion-label skill" value="${result[i].value}">${result[i].value}</li>`);
                }
                option.push(`<li id="createSkill" class="list-group-item suggestion-label" ><i class="fa fa-plus"></i> Add new skill</li>`);

                placement.innerHTML = option.join('');

            }
        })
        e.preventDefault();
    }
});

$(document).on('click', '.skill', function (e) {
    $('#message').html('<div class="alert alert-success text-left" role="alert">Tag Added</div>');
    $('#types').val('');
    console.log($('#traits').text());
    
    if ($('#traits').text().length == 0) {
        $('#traits').append($(this).text()).show();
    }
    else{
        $('#traits').append(', ' + $(this).text()).show();
    }
    $('#hiddenTags').val($('#traits').text());
    $('#suggestions').css('display', 'none');
    
    e.preventDefault();
})
