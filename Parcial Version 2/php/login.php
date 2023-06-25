<?php 
echo "login.php";
session_start();
if(!isset($_POST["submit"])){
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $user = iniciar_sesion($email, $pass);
    echo $user;
    if ($user == 1){
        header("Location:http://localhost/mathkidz/ProjectOfUniversity/admin/dashboard.php");
        exit;
    }
  }

  function iniciar_sesion($email, $pass) {
    try{
        include('conexionBD.php');
        $conexionBD = BD::crearInstancia();
        if($conexionBD != null){
            echo "TODO CORRECTO";
        }

        echo $conexionBD->host_info . "\n";

        $datosJSON = file_get_contents('php://input');
        $datos = json_decode($datosJSON, true);

        $resultado = $conexionBD->query("SELECT ID_LOGIN, USER_NAME, EMAIL, PASS, ROL FROM `db_math_kidz`.`login` WHERE EMAIL='".$email."' AND PASS='".$pass."';");

        echo "Orden del conjunto de resultados...\n";

        if (mysqli_num_rows($resultado) > 0) {
            // Recorrer los registros
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $idLogin = $fila['ID_LOGIN'];
                $userName = $fila['USER_NAME'];
                $email = $fila['EMAIL'];
                $pass = $fila['PASS'];
                $rol = $fila['ROL'];
        
                // Hacer algo con los datos obtenidos
                // Por ejemplo, imprimirlos o asignarlos a variables
                echo "ID_LOGIN: " . $idLogin . "<br>";
                echo "USER_NAME: " . $userName . "<br>";
                echo "EMAIL: " . $email . "<br>";
                echo "PASS: " . $pass . "<br>";
                echo "ROL: " . $rol . "<br>";
            }
        } else {
            echo "No se encontraron resultados.";
        }
    }catch(Exception $e){// lanza una excepcion en caso de error al conectar a la base de datos
        echo "base de datos no encontrada";
    }
    return $rol;
  }
?>