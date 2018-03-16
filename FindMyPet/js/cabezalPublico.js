$(document).ready(inicializo);
$(function () {
    $('#name').focusout(function () {
        if ($('#name').val() == '' || $('#name').val() == null) {
            $("#name").addClass("invalido");
        } else {
            $("#name").removeClass("invalido");
        }
    });
});
$(function () {
    $('#surname').focusout(function () {
        if ($('#surname').val() == '' || $('#surname').val() == null) {
            $("#surname").addClass("invalido");
        } else {
            $("#surname").removeClass("invalido");
        }
    });
});
$(function () {
    $('#username').focusout(function () {
        if ($('#username').val() == '' || $('#username').val() == null) {
            $("#username").addClass("invalido");
        } else {
            $("#username").removeClass("invalido");
        }
    });
});
$(function () {
    $('#pass').focusout(function () {
        if ($('#pass').val() == '' || $('#pass').val() == null) {
            $("#pass").addClass("invalido");
        } else {
            $("#pass").removeClass("invalido");
        }
    });
});
$(function () {
    $('#repeatPassword').focusout(function () {
        var usuario = $("#repeatPassword").val();
        var password = $("#pass").val();
        if ($('#repeatPassword').val() !== $('#pass').val()) {
            $("#repeatPassword").addClass("invalido");
        } else {
            $("repeatPassword").removeClass("invalido");
        }
    });
});
function inicializo() {
    $(".myAlert-top").hide();
    $("#btnLogin").click(validarUsuario);
    $("#btnRegister").click(function () {
        username = $('#username').val();
        name = $('#name').val();
        surname = $('#surname').val();
        pass = $('#pass').val();
        repeatPass = $('#repeatPassword').val();
        if ((repeatPass == pass) &&
                (username !== '') &&
                (name !== '') &&
                (surname !== '') &&
                (pass !== '')) {
            newUser();
        } else {
            errorRegister();
        }
    });
}

function validarUsuario() {
    var usuario = $("#usuario").val();
    var password = $("#password").val();
    var remember = $("#remember").val();
    $.ajax({
        url: "Login.php",
        dataType: "JSON",
        type: "POST",
        data: "usuario=" + usuario + "&password=" + password,
        success: validoUsuario,
        timeout: 4000,
        error: errorLogin
    });
}

function newUser() {
    var name = $("#name").val();
    var surname = $("#surname").val();
    var usuario = $("#username").val();
    var password = $("#pass").val();
    $.ajax({
        url: "Register.php",
        dataType: "JSON",
        type: "POST",
        data: "usuario=" + usuario + "&password=" + password + "&name=" + name + "&surname=" + surname,
        success: registerOk,
        timeout: 4000,
        error: errorRegister
    });
}

function registerOk(respuesta) {
    esUsuario = respuesta;
    if (esUsuario['estado'] == "NO OK") {
        $("#error").html("No se pudo insertar nada");
        myAlertTop()
    } else {
        window.location = "index.php";
    }
}

function validoUsuario(respuesta) {
    esUsuario = respuesta;
    if (esUsuario['estado'] == "NO OK") {
        $("#error").html("El usuario o contraseña ingresados son incorrectos");
        myAlertTop()
    } else {
        location.reload();
    }
}

function errorRegister() {
    myAlertTop()
    $("#error").html("Ocurrio un problema");
}

function errorLogin() {
    myAlertTop()
    $("#error").html("El usuario o contraseña ingresados son incorrectos");
}

function estadistica() {
    window.location = "estadisticas.php";
}

function inicio() {
    window.location = "index.php";
}

function myAlertTop() {
    $(".myAlert-top").show();
    setTimeout(function () {
        $(".myAlert-top").hide();
    }, 20000);
}

$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
});
