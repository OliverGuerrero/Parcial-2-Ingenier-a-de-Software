<?php

    class BD{
        public static $instancia=null;
        public static function crearInstancia(){
            if( !isset(self::$instancia) ){
                $instancia = mysqli_connect('localhost', 'root', 'Kon4TobiAs*2', 'db_math_kidz');
                echo "conectado...";
            }
            return $instancia;
        }
    }

?>