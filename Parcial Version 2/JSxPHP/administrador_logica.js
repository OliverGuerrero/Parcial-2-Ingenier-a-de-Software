document.addEventListener("DOMContentLoaded", function() {
    // Obtener la cadena JSON del localStorage
    var objetoJSON = localStorage.getItem("miObjeto");
  
    // Convertir la cadena JSON a un objeto
    var miObjeto = JSON.parse(objetoJSON);
  
    // Acceder a las propiedades del objeto
    console.log("ID: " + miObjeto.id_admin);
    console.log("Nombre: " + miObjeto.nombre);
    console.log("Cargo: " + miObjeto.cargo);
    console.log("Empleado: " + miObjeto.num_empleado);
    console.log("ID_LOGIN: " + miObjeto.id_login);
    console.log("ROL: " + miObjeto.id_rol);
    localStorage.removeItem("miObjeto");
  });