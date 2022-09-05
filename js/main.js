$("document").ready(function() {

    $("#signup").on("submit", function() {

        $(`input`).removeClass('error');

        let arrData = {
            "name": $('input[name="name"]').val(),
            "email": $('input[name="email"]').val(),
            "login": $('input[name="login"]').val(),
            "password": $('input[name="password"]').val(),
            "confirm_password": $('input[name="confirm_password"]').val()

        }
        let jsonStr = JSON.stringify(arrData);

        $.ajax({
            url: '/query.php',
            method: 'post',
            dataType: 'json',
            data: {
                "dataQuery": jsonStr
            },
            success: function(data) {


                if (data.type === 3) {
                    $('.msg').removeClass('none').text(data.errormsg);
                } else {

                    if (data.type === 1) {
                        data.fields.forEach(function(field) {
                            $(`
                                input[name = "${field}"]
                                `).addClass('error');
                        });
                    } else if (data.type === 2) {
                        data.fields.forEach(function(field) {
                            $(`
                                input[name = "${field}"]
                                `).addClass('error');
                        });

                        $('.validErrorName').removeClass('none').text("Ошибка должно быть 2 символа только буквы");
                        $('.validErrorEmail').removeClass('none').text("Ошибка ввдение email в формате support@gmailcom");
                        $('.validErrorLogin').removeClass('none').text("Ошибка минимум 6 символов");
                        $('.validErrorPassword').removeClass('none').text("Ошибка минимум 6 символов , обязательно должны состоять из цифр и букв");
                        $('.validErrorConfirm_password').removeClass('none').text("Ошибка минимум 6 символов , обязательно должны состоять из цифр и букв");
                    } else {
                        $('.validErrorName').addClass('none');
                        $('.validErrorEmail').addClass('none');
                        $('.validErrorLogin').addClass('none');
                        $('.validErrorPassword').addClass('none');
                        $('.validErrorConfirm_password').addClass('none');
                    }


                    $('.msg').removeClass('none').text(data.errormsg);

                }



            }
        });
    })
})