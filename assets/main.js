jQuery(document).ready(function ($) {
    $('#cvForm').submit(function (e) {

        e.preventDefault();

        var form = $(this);
        var formData = new FormData();

        formData.append('cv-file', form.find('input[name=cv-file]')[0].files[0]);
        formData.append('firstname', form.find('input[name=firstname]').val());
        formData.append('secondname', form.find('input[name=secondname]').val());
        formData.append('email', form.find('input[name=email]').val());
        $.ajax({
            type: "POST",
            url: myajax.url,
            data: formData,
            mimeType: 'multipart/form-data',
            dataType: 'json',
            processData: false,
            contentType: false,
            contentType: false,
            cache: false,
            success: function (responce) {
                if (true == responce.success) {
                    $('#error-message').hide()
                    $('#form_container').html(responce.data.message)
                    setTimeout(function () {
                        window.location.href = '/';
                    }, 3000)
                }
                $('#error-message').html(responce.data.error);
                $('#error-message').show();
            },
            error: function (responce, textStatus, errorThrown) {
                $('#error-message').html(textStatus);
                $('#error-message').show();
            }
        });

    });

})
