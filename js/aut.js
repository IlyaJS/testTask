$("document").ready(function() {

    $("#signin").on("submit", function() {

        $(`input`).removeClass('error');

        let arrDataAut = {
            "login": $('input[name="loginaut"]').val(),
            "password": $('input[name="passwordaut"]').val()

        }
        let jsonStrAut = JSON.stringify(arrDataAut);

        $.ajax({
            url: '/autquery.php',
            method: 'post',
            dataType: 'json',
            data: {
                "dataQueryAut": jsonStrAut
            },
            success: function(data) {
                $('.validErrorLoginAut').removeClass('none').text("");
                $('.validErrorPasswordAut').removeClass('none').text("");
                $('.msgaut').removeClass('none').text("");


                if (data.type === 1) {
                    data.fields.forEach(function(field) {
                        $(`input[name = "${field}"]`).addClass('error');
                    });
                    $('.msgaut').removeClass('none').text(data.errormsg);
                } else if (data.type === 2) {
                    data.fields.forEach(function(field) {
                        $(`input[name = "${field}"]`).addClass('error');
                    });
                    if (data.fieldsText.name !== '') {
                        $('.validErrorLoginAut').removeClass('none').text(data.fieldsText.login);
                    }
                    if (data.fieldsText.name !== '') {
                        $('.validErrorPasswordAut').removeClass('none').text(data.fieldsText.password);
                    }
                } else {

                    if (data.status === true) {
                        console.log(data);
                        $('.statusSession').text("Вы авторизованы");
                        $('.vision').addClass('userAutNone');
                        $('.userAut').removeClass('userAutNone');
                        $(`h1`).text(data.message + "-> User : " + data.name);
                        $('input[name="nameUser"]').val(data.name);
                        $('input[name="messageUser"]').val(data.message);

                    } else if (data.status === false) {
                        $('.msgaut').removeClass('none').text("Неверный логин или пароль");
                    }

                }




            }
        });
    })
})