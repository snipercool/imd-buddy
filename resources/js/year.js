$('#year_id').change(function () {
    console.log($(this).val() );
     
    if ($(this).val() != '') {
        if ($(this).val() == 1) {
            $('#warning').removeClass('d-none');
            $('#warning2').addClass('d-none');
        }
        else {
            $('#warning2').removeClass('d-none');
            $('#warning').addClass('d-none');
            
        }
    }
    else {
        $('#warning2').addClass('d-none');
        $('#warning').addClass('d-none');
        
    }
})