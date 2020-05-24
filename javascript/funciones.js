/// <reference path="libs/jquery/index.d.ts" />
//Funciones con AJAX
function MostrarAjax() {
    var pagina = "mostrar.php";
    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "text",
        async: true
    })
        .done(function (datos) {
        $("#divMostrar").html(datos);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function EliminarEmpleado(legajo) {
    $("#divMostrar").html("");
    var pagina = "eliminar.php";
    $.ajax({
        type: 'GET',
        url: pagina,
        data: { "legajo": legajo },
        dataType: "text",
        async: true
    })
        .done(function (datos) {
        alert(datos);
        MostrarAjax();
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function AdministrarValidaciones() {
    var dni = document.getElementById("txtDni").value;
    var apellido = document.getElementById("txtApellido").value;
    var nombre = document.getElementById("txtNombre").value;
    var legajo = document.getElementById("txtLegajo").value;
    var sueldo = document.getElementById("txtSueldo").value;
    var sexo = document.getElementById("cboSexo").value;
    var minDni = document.getElementById("txtDni").min;
    var maxDni = document.getElementById("txtDni").max;
    var minLegajo = document.getElementById("txtLegajo").min;
    var maxLegajo = document.getElementById("txtLegajo").max;
    var minSueldo = document.getElementById("txtSueldo").min;
    var turno = ObtenerTurnoSeleccionado();
    document.getElementById("txtSueldo").max = ObtenerSueldoMaximo(turno).toString();
    var maxSueldo = document.getElementById("txtSueldo").max;
    var foto = document.getElementById("imageFoto").value;
    if (ObtenerTurnoSeleccionado() == "") {
        alert("Por favor elija un turno");
    }
    AdministrarSpanError("spanDni", ValidarCamposVacios(dni));
    AdministrarSpanError("spanApellido", ValidarCamposVacios(apellido));
    AdministrarSpanError("spanNombre", ValidarCamposVacios(nombre));
    AdministrarSpanError("spanLegajo", ValidarCamposVacios(legajo));
    AdministrarSpanError("spanSueldo", ValidarCamposVacios(sueldo));
    AdministrarSpanError("spanSexo", ValidarCombo(sexo, ""));
    AdministrarSpanError("spanFoto", ValidarCamposVacios(foto));
    AdministrarSpanError("spanDni", ValidarRangoNumerico(Number(dni), Number(minDni), Number(maxDni)));
    AdministrarSpanError("spanLegajo", ValidarRangoNumerico(Number(legajo), Number(minLegajo), Number(maxLegajo)));
    AdministrarSpanError("spanSueldo", ValidarRangoNumerico(Number(sueldo), Number(minSueldo), Number(maxSueldo)));
    var validar = false;
    if (dni == $("#hdDni").val()) {
        validar = true;
    }
    if (!ValidarCamposVacios(dni)) {
        if (!ValidarCamposVacios(apellido)) {
            if (!ValidarCamposVacios(nombre)) {
                if (!ValidarCamposVacios(legajo)) {
                    if (!ValidarCamposVacios(sueldo)) {
                        if (!ValidarCombo(sexo, "")) {
                            if (!ValidarCamposVacios(foto)) {
                                if (!ValidarRangoNumerico(Number(dni), Number(minDni), Number(maxDni))) {
                                    if (!ValidarRangoNumerico(Number(legajo), Number(minLegajo), Number(maxLegajo))) {
                                        if (!ValidarRangoNumerico(Number(sueldo), Number(minSueldo), Number(maxSueldo))) {
                                            document.getElementById("hdDni").value = "";
                                            document.getElementById("txtDni").readOnly = false;
                                            document.getElementById("txtLegajo").readOnly = false;
                                            $("#btnEnviar").val("Enviar");
                                            $("#divTitulo").html("<h2>Alta de Empleados</h2>");
                                            $("#divMostrar").html("");
                                            var fotoP = $("#imageFoto")[0];
                                            var formData = new FormData();
                                            formData.append("dni", dni);
                                            formData.append("nombre", nombre);
                                            formData.append("apellido", apellido);
                                            formData.append("legajo", legajo);
                                            formData.append("sueldo", sueldo);
                                            formData.append("sexo", sexo);
                                            formData.append("rdoTurno", turno);
                                            formData.append("archivo", fotoP.files[0]);
                                            if (validar) {
                                                formData.append("hdnModificar", "true");
                                            }
                                            var pagina = "administracion.php";
                                            $.ajax({
                                                type: 'POST',
                                                url: pagina,
                                                dataType: "text",
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                data: formData,
                                                async: true
                                            })
                                                .done(function (dato) {
                                                alert(dato);
                                                MostrarAjax();
                                            })
                                                .fail(function (jqXHR, textStatus, errorThrown) {
                                                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
function ValidarCamposVacios(campo) {
    var validar = false;
    if (campo == "") {
        validar = true;
    }
    return validar;
}
function ValidarRangoNumerico(numero, min, max) {
    var validar = true;
    if (numero >= min && numero <= max) {
        validar = false;
    }
    return validar;
}
function ValidarCombo(primerValor, SegundoValor) {
    var validar = true;
    if (primerValor != SegundoValor) {
        validar = false;
    }
    return validar;
}
function ObtenerTurnoSeleccionado() {
    var checks = document.getElementsByTagName("input");
    var seleccionado = "";
    for (var index = 0; index < checks.length; index++) {
        var input = checks[index];
        if (input.type == "radio") {
            if (input.checked == true) {
                seleccionado = input.value;
                break;
            }
        }
    }
    return seleccionado;
}
function ObtenerSueldoMaximo(turno) {
    var maximo = 0;
    if (turno == "M") {
        maximo = 20000;
    }
    if (turno == "T") {
        maximo = 18500;
    }
    if (turno == "N") {
        maximo = 25000;
    }
    return maximo;
}
//FUNCIONES DE LA PARTE 4
function AdministrarValidacionesLogin() {
    var dni = document.getElementById("txtDni").value;
    var apellido = document.getElementById("txtApellido").value;
    var minDni = document.getElementById("txtDni").min;
    var maxDni = document.getElementById("txtDni").max;
    AdministrarSpanError("spanDni", ValidarCamposVacios(dni));
    AdministrarSpanError("spanDni", ValidarRangoNumerico(Number(dni), Number(minDni), Number(maxDni)));
    AdministrarSpanError("spanApellido", ValidarCamposVacios(apellido));
    if (VerificarValidacionesLogin()) {
        alert("Todo Ok");
    }
}
function AdministrarSpanError(id, validar) {
    if (validar) {
        document.getElementById(id).style.display = "block";
    }
    else {
        document.getElementById(id).style.display = "none";
    }
}
function VerificarValidacionesLogin() {
    var validar = false;
    if (document.getElementById("spanDni").style.display == "none")
        if (document.getElementById("spanApellido").style.display == "none") {
            validar = true;
        }
    return validar;
}
//FUNCION DE LA PARTE 5
function AdministrarModificar(dni, nombre, apellido, sexo, legajo, sueldo, turno) {
    document.getElementById("hdDni").value = dni;
    //(<HTMLFormElement>document.getElementById("formModificar")).submit(); <-Codigo para la Parte 5 sin ajax
    document.getElementById("txtDni").readOnly = true;
    document.getElementById("txtLegajo").readOnly = true;
    $("#txtDni").val(dni);
    $("#txtNombre").val(nombre);
    $("#txtApellido").val(apellido);
    $("#cboSexo").val(sexo);
    $("#txtLegajo").val(legajo);
    $("#txtSueldo").val(sueldo);
    if (turno == "M") {
        $("#rdoMañana").prop("checked", true);
    }
    if (turno == "T") {
        $("#rdoTarde").prop("checked", true);
    }
    if (turno == "N") {
        $("#rdoNoche").prop("checked", true);
    }
    $("#btnEnviar").val("Modificar");
    $("#divTitulo").html("<h2>Modificar Empleado</h2>");
}
