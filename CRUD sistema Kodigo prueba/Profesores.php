<?php
require "./Clases/Conexion.php";

class Profesor extends Conexion{
    protected $id;
    protected $nombre;
    protected $direccion;
    protected $titulo;
    protected $correo;
    protected $password;
    protected $id_materia;

    public function ObtenerBootcamps(){
        $pdo = $this->conectar();
        $consulta = $pdo->query("SELECT * FROM bootcamps");
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function ObtenerMaterias(){
        $pdo = $this->conectar();
        $consulta = $pdo->query("SELECT * FROM materia");
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function RegistrarProfesores(){
        if(isset($_POST['nombre'], $_POST['direccion'], $_POST['titulo'], $_POST['correo'], $_POST['materia'], $_POST['bootcamp'])){
            $this->nombre = $_POST['nombre'];
            $this->direccion = $_POST['direccion'];
            $this->titulo = $_POST['titulo'];
            $this->correo = $_POST['correo'];
            $this->password = 'Kodigo';
            $this->id_materia = $_POST['materia'];

            $estado = 1; // El estado 1 hace referencia al estado activo.
            $rol = 2; // El rol 2 hace referencia al coach o profesor. 

            $pdo = $this->conectar(); // Método para conectar con la base de datos. 

            $query = $pdo->prepare("INSERT INTO coaches(nombre,direccion,titulo,correo,password,id_materia,id_estado,id_rol) VALUES (?,?,?,?,?,?,?,?)"); // Se prepara la consulta a la base de datos.

            $result = $query->execute(["$this->nombre","$this->direccion","$this->titulo","$this->correo","$this->password","$this->id_materia","$estado","$rol"]);

            if($result){
                $query1 = $pdo->query("SELECT id FROM coaches ORDER BY id DESC LIMIT 1");
                
                $query1->execute();

                $profesor = $query1->fetch(PDO::FETCH_ASSOC);
                $id_profesor = $profesor['id']; 

                $arreglo_bootcamps = $_POST['bootcamp'];

                for($i = 0; $i < count($arreglo_bootcamps); $i++){
                    $query2 = $pdo->prepare("INSERT INTO detalle_bootcamp_coach(id_coach,id_bootcamp) VALUES (?,?)");
                    $query2->execute([$id_profesor, $arreglo_bootcamps[$i]]);
                }

                echo "<script>
                    window.location = './profesores_activos.php'
                </script>";
            }
        }
    }

    public function ObtenerProfesores(){
        $pdo = $this->conectar();
        $query = $pdo->query("SELECT coaches.id, coaches.nombre, coaches.titulo, coaches.correo, materia.materia, estado.estado FROM coaches INNER JOIN materia ON coaches.id_materia = materia.id INNER JOIN estado ON coaches.id_estado = estado.id WHERE estado.id != 5");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function ObtenerProfesorID(){
        if(isset($_POST['id_profesor'])){
            $this->id = $_POST['id_profesor'];

            $pdo = $this->conectar();
            $query = $pdo->query("SELECT id, nombre, titulo, correo, materia FROM coaches WHERE id = $this->id");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function ActualizarProfesor(){
        if(isset($_POST['id_profesor'], $_POST['nombre'], $_POST['titulo'], $_POST['correo'])){
            $this->id = $_POST['id_profesor'];
            $this->nombre = $_POST['nombre'];
            $this->titulo = $_POST['titulo'];
            $this->correo = $_POST['correo'];

            $pdo = $this->conectar();
            $query = $pdo->prepare("UPDATE coaches SET nombre = ?, titulo = ?, correo = ? WHERE id = ?");
            $result = $query->execute(["$this->nombre","$this->titulo","$this->correo","$this->id"]);
            
            if($result){
                echo "<script>
                    window.location = './profesores_activos.php'
                </script>";
            } else {
                echo "Error al actualizar los datos del profesor";
            }
        }
    }

    public function ActualizarMateria(){
        if(isset($_POST['id_profesor'], $_POST['materia'])){
            $this->id = $_POST['id_profesor'];
            $this->id_materia = $_POST['materia'];

            $pdo = $this->conectar();
            $query = $pdo->prepare("UPDATE coaches SET id_materia = ? WHERE id = ?");
            $result = $query->execute([$this->id_materia,$this->id]);

            if($result){
                echo "<script>
                    window.location = './profesores_activos.php'
                </script>";
            } else {
                echo "Error al actualizar la materia";
            }
        }
    }

    public function EstadoActivoInactivo(){
        $pdo = $this->conectar();
        $query = $pdo->query("SELECT * FROM estado WHERE id = 1 OR id = 5");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function ActualizarEstado(){
        if(isset($_POST['id_profesor'], $_POST['estado'])){
            $this->id = $_POST['id_profesor'];
            $estado = $_POST['estado'];

            $pdo = $this->conectar();
            $query = $pdo->prepare("UPDATE coaches SET id_estado = ? WHERE id = ?");
            $result = $query->execute([$this->id,$estado]);

            if($result){
                echo "<script>
                    window.location = './profesores_activos.php'
                </script>";
            } else {
                echo 'Error al cambiar el estado';
            }
        }
    }
}
?>