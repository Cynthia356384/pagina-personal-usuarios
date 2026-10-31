

// ---------- 1. FECHA Y HORA  ----------
function mostrar_fecha() {
    var hoy = new Date();

    var diasSemana = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
    var meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

    var diaSemana = diasSemana[hoy.getDay()];
    var diaMes = hoy.getDate();
    var mes = meses[hoy.getMonth()];
    var horas = hoy.getHours();
    var minutos = hoy.getMinutes();

    if (diaMes < 10) {
        diaMes = "0" + diaMes;
    }
    if (minutos < 10) {
        minutos = "0" + minutos;
    }

    document.write("Hoy es " + diaSemana + " " + diaMes + " de " + mes + "<br>");
    document.write("Son las " + horas + ":" + minutos + " horas");
}


// ---------- SALUDO SEGÚN LA HORA  ----------
function mostrar_saludo() {
    var hoy = new Date();
    var horas = hoy.getHours();
    var saludo;

    if (horas < 6) {
        saludo = "¡Buenas noches!";
    } else {
        if (horas < 12) {
            saludo = "¡Buenos días!";
        } else {
            if (horas < 19) {
                saludo = "¡Buenas tardes!";
            } else {
                saludo = "¡Buenas noches!";
            }
        }
    }

    document.write(saludo + "<br>");
}


// ---------- 2. COOKIES  ----------
function setCookie(c_name, value, expiredays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + escape(value) +
        ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1)
                c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}


// ---------- 3. CONVERSOR DE PESOS  ----------
// Cuántos pesos cuesta 1 unidad (cámbialos por el tipo de cambio del día)
var pesosPorDolar = 17.50;
var pesosPorEuro = 20.50;

// Deja solo 2 decimales
function redondear(numero) {
    return parseInt(numero * 100) / 100;
}

function convertir() {
    var pesos = document.getElementById("pesos").value;

    if (pesos == "") {
        alert("Escribe una cantidad de pesos");
        return;
    }
    if (pesos <= 0) {
        alert("La cantidad debe ser mayor a 0");
        return;
    }

    var dolares = redondear(pesos / pesosPorDolar);
    var euros = redondear(pesos / pesosPorEuro);

    document.getElementById("resultado").innerHTML =
        pesos + " pesos mexicanos son " + dolares + " dólares<br>" +
        pesos + " pesos mexicanos son " + euros + " euros";
}


// ---------- 4. CALCULADORA  ----------
function elevar_cuadrado() {
    var texto = document.getElementById("num1").value;

    if (texto == "") {
        alert("Escribe un número");
        return;
    }

    var numero = parseInt(texto);
    var resultado = numero * numero;

    document.getElementById("resultado").innerHTML =
        numero + " al cuadrado es " + resultado;
}


// ---------- 5. CUESTIONARIO  ----------
var respuestasQuiz = ["castillo", "2007", "pibil", "serpiente", "dinosaurios"];
var textosQuiz = ["El Castillo", "2007", "Cochinita pibil", "La sombra de una serpiente", "La extinción de los dinosaurios"];
var datosQuiz = [
    "El Castillo, o pirámide de Kukulcán, tiene 365 escalones entre sus cuatro escalinatas, uno por cada día del año.",
    "Chichén Itzá fue elegida en 2007 como una de las Nuevas 7 Maravillas del Mundo.",
    "La palabra pibil viene de pib, el horno bajo tierra donde se cocinaba la carne envuelta en hoja de plátano.",
    "En los equinoccios, la luz y la sombra forman en la escalinata la figura de una serpiente que desciende.",
    "El cráter de Chicxulub, en Yucatán, tiene cerca de 180 kilómetros de diámetro."
];

function calificar() {
    var total = respuestasQuiz.length;

    // 1. Verificar que todas estén contestadas
    for (var i = 0; i < total; i++) {
        var eleccion = document.getElementById("preg" + (i + 1)).value;
        if (eleccion == "") {
            alert("Contesta la pregunta " + (i + 1));
            return;
        }
    }

    // 2. Calificar automáticamente
    var puntos = 0;
    var detalle = "";

    for (var j = 0; j < total; j++) {
        var respuesta = document.getElementById("preg" + (j + 1)).value;

        if (respuesta == respuestasQuiz[j]) {
            puntos += 1;
            detalle += "Pregunta " + (j + 1) + ": Correcta<br>";
        } else {
            detalle += "Pregunta " + (j + 1) + ": Incorrecta (la respuesta era: " + textosQuiz[j] + ")<br>";
        }
        detalle += "Dato curioso: " + datosQuiz[j] + "<br><br>";
    }

    var calificacion = puntos * 2;   

    var mensaje = "Lee los datos curiosos e inténtalo otra vez.";
    if (puntos >= 3) {
        mensaje = "¡Muy bien! Conoces bastante de Yucatán.";
    }
    if (puntos == total) {
        mensaje = "¡Excelente! Eres toda una experta en la cultura maya.";
    }

    document.getElementById("resultado").innerHTML =
        "Aciertos: " + puntos + " de " + total + "<br>" +
        "Calificación: " + calificacion + " / 10<br><br>" +
        detalle + mensaje;
}

function reiniciar() {
    for (var i = 1; i <= respuestasQuiz.length; i++) {
        document.getElementById("preg" + i).value = "";
    }
    document.getElementById("resultado").innerHTML = "";
}


// ---------- 6. FORMULARIO DE CONTACTO  ----------


function saludar() {
    var guardado = getCookie('nombre');

    if (guardado != "") {
        document.getElementById("saludo").innerHTML =
            "¡Hola de nuevo, " + guardado + "!<br>Tu último registro fue: " + getCookie('ultimoregistro');
        document.getElementById("nombre").value = guardado;
    } else {
        document.getElementById("saludo").innerHTML =
            "Bienvenido, aún no te has registrado en este sitio.";
    }
}

// true si hay al menos un radiobutton/checkbox marcado en ese grupo
function hayMarcado(nombre) {
    var opciones = document.getElementsByName(nombre);
    for (var i = 0; i < opciones.length; i++) {
        if (opciones[i].checked) {
            return true;
        }
    }
    return false;
}

function validar() {
    var mensajes = "";

    var nombre = document.getElementById("nombre").value;
    var apellidos = document.getElementById("apellidos").value;
    var comentarios = document.getElementById("comentarios").value;

    // input de texto
    if (nombre == "") {
        mensajes += "• Escribe tu nombre.<br>";
    }
    if (apellidos == "") {
        mensajes += "• Escribe tus apellidos.<br>";
    }

    // radiobutton
    if (hayMarcado("radio1") == false) {
        mensajes += "• Selecciona tu género.<br>";
    }

    // checkbox
    if (hayMarcado("intereses") == false) {
        mensajes += "• Marca al menos un interés.<br>";
    }

    // select
    if (document.getElementById("licenciatura").value == "") {
        mensajes += "• Selecciona qué estás estudiando.<br>";
    }

    // input con datalist
    if (document.getElementById("navegador").value == "") {
        mensajes += "• Indica qué navegador usas.<br>";
    }

    // textarea (mínimo 10 caracteres)
    if (comentarios.length < 10) {
        mensajes += "• Escribe un comentario de al menos 10 caracteres.<br>";
    }

    if (mensajes != "") {
        document.getElementById("errores").innerHTML = mensajes;
        return false;   // no se envía el formulario
    }

    // Todo correcto: se guardan las cookies
    document.getElementById("errores").innerHTML = "";
    setCookie('nombre', nombre, 365);
    setCookie('ultimoregistro', Date(), 365);
    alert("¡Gracias " + nombre + "! Tu formulario fue validado correctamente.");
    return false;  
}