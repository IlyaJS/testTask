$("document").ready(function() {

    $("#userLogout").on("submit", function() {



        let arrDataAut = {
            "name": $('input[name="nameUser"]').val(),
            "massage": $('input[name="messageUser"]').val()

        }
        let jsonStrAut = JSON.stringify(arrDataAut);

        $.ajax({
            url: '/logout.php',
            method: 'post',
            dataType: 'json',
            data: {
                "dataQueryUser": jsonStrAut
            },
            success: function(data) {
                if (data.status === true) {
                    $('.vision').removeClass('userAutNone');
                    $('.userAut').addClass('userAutNone');
                    $('input[name="loginaut"]').val('');
                    $('input[name="passwordaut"]').val('');
                    $('.statusSession').text("Сессия очищены, вы вышли!");
                } else {
                    $('.responseLogout').text("Ссессия не удалена");
                }


            }
        });
    })
})