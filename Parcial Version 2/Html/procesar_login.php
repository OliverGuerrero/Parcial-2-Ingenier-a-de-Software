<?php
class Estado {
    public $status;
}

class Usuario {
    public $id_user;
    public $nombre;
    public $apellido;
    public $id_login;
    public $imagen;
    public $rol;
    public $status;
    public $url;
}

class Admin {
    public $id_admin;
    public $nombre;
    public $cargo;
    public $num_empleado;
    public $id_login;
    public $id_rol;
    public $status;
    public $url;
}

function logeo_admin($id, $conexionBD){
    $user = new Admin();
    $consulta = $conexionBD->prepare("SELECT * FROM db_math_kidz.administrador WHERE ID_LOGIN=?");
    $consulta->bind_param("s", $id);
    $consulta->execute();
    $resultado = $consulta->get_result();
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $user->id_admin = $fila['ID_ADMINISTRADOR'];
        $user->nombre = $fila['NOMBRE'];
        $user->cargo = $fila['CARGO'];
        $user->num_empleado = $fila['NUM_EMPLEADO'];
        $user->id_login = $fila['ID_LOGIN'];
        $user->status = "200";
        $user->url = 'http://localhost/mathkidz/Web2/Html/Administrador.html';
    } else {
        $user->status = "400";
    }
    return $user;
}

function logeo_usuario($id, $conexionBD){
    $user = new Usuario();
    $consulta = $conexionBD->prepare("SELECT ID_USER, NOMBRE, APELLIDO, ID_LOGIN, ID_IMAGEN FROM db_math_kidz.usuario WHERE ID_USER=?");
    $consulta->bind_param("s", $id);
    $consulta->execute();
    $resultado = $consulta->get_result();
    if ($resultado->num_rows > 0){
        $fila = $resultado->fetch_assoc();
        $user->id_user = $fila['ID_USER'];
        $user->nombre = $fila['NOMBRE'];
        $user->apellido = $fila['APELLIDO'];
        $user->id_login = $fila['ID_LOGIN'];
        $user->imagen = $fila['ID_IMAGEN'];
        $user->status = "200";
    }
}

function iniciar_sesion($email, $pass) {
    
    try {
        include('../php/conexionBD.php');
        $conexionBD = BD::crearInstancia();

        if ($conexionBD->connect_errno) {
            $usuario = new Estado();
            $usuario->status = "500";
            return $usuario;
        }
        
        // Utilizar sentencias preparadas para evitar inyección de SQL
        $consulta = $conexionBD->prepare("SELECT ID_LOGIN, ROL FROM `db_math_kidz`.`login` WHERE EMAIL=? AND PASS=?");
        $consulta->bind_param("ss", $email, $pass);
        $consulta->execute();
        
        $resultado = $consulta->get_result();
        
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $id = $fila['ID_LOGIN'];
            $rol = $fila['ROL'];
            $status = "200";
            if($rol == 1 ){
                #Administrador
                $usuario = logeo_admin($id, $conexionBD);
            }else if ($rol == 2) {
                #Para el profesor
                $usuario = logeo_usuario($id, $conexionBD);
                $usuario->rol = $rol;
                $usuario->url = "";
            } else if($rol == 3) {
                #El estudiante
                $usuario = logeo_usuario($id, $conexionBD);
                $usuario->rol = $rol;
                $usuario->url = "";
            }
        } else {
            $status = "400";
        }
        


    } catch(Exception $e) {
        $status = "500";
    }
    

    return $usuario;
}

// Obtener los datos del formulario
$data = json_decode(file_get_contents('php://input'), true);

$email = $data["email"];
$password = $data["password"];

$usuario = iniciar_sesion($email, $password);

// Convertir el objeto en JSON
$json = json_encode($usuario);

// Enviar el JSON al cliente (por ejemplo, en la respuesta HTTP)
header('Content-Type: application/json');
echo $json;

?>