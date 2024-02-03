<?php
require "./Clases/Conexion.php";

class Autenticacion extends Conexion{
    protected $email;
    protected $password;

    public function AutenticarUsuario(){
        if(isset($_POST['email'], $_POST['password'])){
            $this->correo = $_POST['email'];
            $this->password = $_POST['password'];

            $pdo = $this->conectar();

            $query = $pdo->prepare("SELECT * FROM admin WHERE correo = ? AND password = ?"); // Consulta al admin. 
            $query->execute(["$this->correo","$this->password"]);

            $usuario_admin = $query->fetch(PDO::FETCH_ASSOC);

            $query2 = $pdo->prepare("SELECT id, nombre, correo, password, id_rol FROM estudiantes WHERE correo = ? AND password = ?"); // Consulta al admin. 
            $query2->execute(["$this->correo","$this->password"]);

            $usuario_estudiante = $query2->fetch(PDO::FETCH_ASSOC);

            $query3 = $pdo->prepare("SELECT id, nombre, correo, password, id_rol FROM coaches WHERE correo = ? AND password = ?");
            $query3->execute(["$this->correo","$this->password"]);

            $usuario_profesor = $query3->fetch(PDO::FETCH_ASSOC);

            if(is_array($usuario_admin)){
                $_SESSION['nombre_admin'] = $usuario_admin['nombre'];
                $_SESSION['id_admin'] = $usuario_admin['id'];

                header("location: ./home_admin.php");
            } else if(is_array($usuario_estudiante)){
                $_SESSION['nombre_estudiante'] = $usuario_estudiante['nombre'];
                $_SESSION['id_estudiante'] = $usuario_estudiante['id'];

                header("location: ./home_estudiante.php");
            } else if(is_array($usuario_profesor)){
                $_SESSION['nombre_profesor'] = $usuario_profesor['nombre'];
                $_SESSION['id_profesor'] = $usuario_profesor['id'];

                header("location: ./home_profesor.php");

            } else {
                echo "<div class='alert alert-danger' role='alert'>
                Tus credenciales son incorrectas
            </div>";
            }
        }
    }
}

?>