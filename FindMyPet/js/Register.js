$(document).ready(inicializo);

function inicializo() {
    $(".myAlert-top").hide();
    $("#btnRegister").click(checkCampos);
    $("#name").focusout(cleanInvalidField);
    $("#surname").focusout(cleanInvalidField);
    $("#username").focusout(cleanInvalidField);
    $("#pass").focusout(cleanInvalidField);
    $("#repeatPassword").focusout(cleanInvalidField);
}

//Oculta el mensaje de error al cliquear la cruz
$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
}
);

function cleanInvalidField() {
    if ($(this).val() !== '') {
        $(this).removeClass("invalido");
    }
}

function checkCampos() {
    cleanInvalidFields();
    var username = $('#username').val();
    var name = $('#name').val();
    var surname = $('#surname').val();
    var pass = $('#pass').val();
    var repeatPass = $('#repeatPassword').val();
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    if (name === '') {
        camposInvalidos("Por favor ingrese un nombre");
        $("#name").addClass("invalido");
    } else {
        if (surname === '') {
            camposInvalidos("Por favor ingrese un apellido");
            $("#surname").addClass("invalido");
        } else {
            if (username === '' || !username.match(pattern)) {
                camposInvalidos("El email ingresado no es valido");
                $("#username").addClass("invalido");
            } else {
                if (pass === '' || !pass.match(/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/)) {
                    camposInvalidos("La contraseña debe ser de al menos 8 caracteres y contener al menos una letra y un numero");
                    $("#pass").addClass("invalido");
                } else {
                    if (pass !== repeatPass) {
                        camposInvalidos("Las contraseñas no coinciden");
                        $("#repeatPass").addClass("invalido");
                    } else {
                        newUser();
                    }
                }
            }
        }
    }
}

function camposInvalidos(mensaje) {
    myAlertTop(mensaje);
}
function cleanInvalidFields() {
    $("#name").removeClass("invalido");
    $("#surname").removeClass("invalido");
    $("#username").removeClass("invalido");
    $("#pass").removeClass("invalido");
    $("#repeatPassword").removeClass("invalido");
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
        myAlertTop(respuesta["mensaje"]);
    } else {
        window.location = "index.php";
    }
}

function errorRegister() {
    myAlertTop("La pagina se encuentra en mantenimiento, por favor reintente mas tarde. Disculpe las molestias");
}

function myAlertTop(mensaje) {
    $(".myAlert-top").show();
    setTimeout(function () {
        $(".myAlert-top").hide();
    }, 8000);
    $("#error").html(mensaje);
}


