<?php
// Ingresamos a la base de datos

class Conexion{
    /* Tipos de conexión a bases de datos en PHP
    1. mysqli 
    2. new Mysqli()
    3. PDO
    */

    public function conectar(){
        try{
            /* Cosas que pide este bloque try/catch: 
    
            1. Gestor de base de datos
            2. Servidor
            2. Nombre de la Base de datos
            4. Usuario
            5. Contraseña
             */
            $conexion = "mysql:host=localhost;dbname=sistema_kodigo_fsj19;charset=utf8"; // En esta variable estamos diciéndole al programa la información esencial para que sepa a cuál gestor y base de datos específica debe conectarse. 
            $opciones = [
                PDO:: ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION, // Maneja los errores de acuerdo al protocolo preestablecido de PDO
                PDO:: ATTR_EMULATE_PREPARES => false // Le indicamos que seremos nosotros quienes prepararemos nuestras consultas a la base de datos, a nuestro modo. 
            ];
    
            // Creamos la instancia PDO: Crear el objeto. 
    
            $pdo = new PDO($conexion, "root", "", $opciones); // Debemos asignarle al objeto $pdo la conexión, el usuario, la contraseña, y las opciones. El usuario “root” es el que más privilegios de acceso tiene. 
            return $pdo;
        }
        catch(PDOException $e){ // Aquí es en donde se realizan las capturas de errores. 
            echo "Error de conexión " . $e->getMessage(); // Este es el mensaje de error que debería recibir. 
            exit; 
        };
    }

    
}

?>