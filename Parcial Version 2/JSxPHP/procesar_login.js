document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío del formulario por defecto
    
    // Obtener los valores de los campos de correo y contraseña
    var email = document.getElementById("usuario").value;
    var password = document.getElementById("contrasena").value;
    
    // Crear un objeto con los datos del formulario
    var data = {
        email: email,
        password: password
    };
    alert("PHP")
    // Realizar una petición AJAX al archivo PHP
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "procesar_login.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Aquí puedes procesar la respuesta del servidor si es necesario
            var jsonResponse = JSON.parse(xhr.responseText); //console.log("URL: " + jsonResponse.url);
            console.log(xhr.responseText);
            // Guardar la cadena JSON en localStorage
            localStorage.setItem("miObjeto", xhr.responseText);
            window.location.href = jsonResponse.url;
        }
    };
    xhr.send(JSON.stringify(data));
});

