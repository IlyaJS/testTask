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
                $('.validErrorName').text("");
                $('.validErrorEmail').removeClass('none').text("");
                $('.validErrorLogin').removeClass('none').text("");
                $('.validErrorPassword').removeClass('none').text("");
                $('.validErrorConfirm_password').removeClass('none').text("");

                if (data.type === 3) {
                    $('.msg').removeClass('none').text(data.errormsg);
                    return;
                }
                if (data.type === 4) {
                    $('.msg').removeClass('none').text(data.errormsg);
                    return;
                } else {

                    if (data.type === 1) {
                        data.fields.forEach(function(field) {
                            $(`
                                input[name = "${field}"]
                                `).addClass('error');
                            return;
                        });
                    } else if (data.type === 2) {
                        data.fields.forEach(function(field) {
                            $(`
                                input[name = "${field}"]
                                `).addClass('error');
                        });
                        if (data.fieldsText.name !== '') {
                            $('.validErrorName').removeClass('none').text(data.fieldsText.name);
                        }
                        if (data.fieldsText.name !== '') {
                            $('.validErrorEmail').removeClass('none').text(data.fieldsText.email);
                        }
                        if (data.fieldsText.name !== '') {
                            $('.validErrorLogin').removeClass('none').text(data.fieldsText.login);
                        }
                        if (data.fieldsText.name !== '') {
                            $('.validErrorPassword').removeClass('none').text(data.fieldsText.password);
                        }
                        if (data.fieldsText.name !== '') {
                            $('.validErrorConfirm_password').removeClass('none').text(data.fieldsText.confirm_password);
                        }

                        /*$('.validErrorName').removeClass('none').text("???????????? ???????????? ???????? 2 ?????????????? ???????????? ??????????");
                        $('.validErrorEmail').removeClass('none').text("???????????? ?????????????? email ?? ?????????????? support@gmail.com");
                        $('.validErrorLogin').removeClass('none').text("???????????? ?????????????? 6 ????????????????, ?????? ????????????????");
                        $('.validErrorPassword').removeClass('none').text("???????????? ?????????????? 6 ???????????????? , ?????????????????????? ???????????? ???????????????? ???? ???????? ?? ????????");
                        $('.validErrorConfirm_password').removeClass('none').text("???????????? ?????????????? 6 ???????????????? , ?????????????????????? ???????????? ???????????????? ???? ???????? ?? ????????"); */
                    } else {


                        /* $('.validErrorName').addClass('none');
                        $('.validErrorEmail').addClass('none');
                        $('.validErrorLogin').addClass('none');
                        $('.validErrorPassword').addClass('none');
                        $('.validErrorConfirm_password').addClass('none'); */
                    }

                    $('.msg').removeClass('none').text(data.errormsg);

                }



            }
        });
    })
})