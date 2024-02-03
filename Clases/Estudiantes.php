<?php

require "./Clases/Conexion.php";

class Estudiante extends Conexion{
    // Asignamos los atributos de la tabla “Estudiantes”

    protected $id;
    protected $nombre;
    protected $direccion;
    protected $telefono;
    protected $carnet;
    protected $correo;
    protected $password;
    protected $id_bootcamp;

    // Método para obtener la información de los bootcamps:
    public function getBootcamps(){
        // Llamamos al método heredado que contiene la información de la base de datos. 
        $pdo = $this->conectar();

        // Consulta SQL para obtener la información específica del bootcamp
        $consulta = $pdo->query("SELECT * FROM bootcamps"); // Aquí es donde pedimos como tal la información de los bootcamps

        $consulta->execute(); // Aquí me envía un arreglo de los bootcamps que hay en la base de datos. 

        // Asignamos en PHP que la información de la consulta es un arreglo a iterar. 
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC); // Aquí me lo va a devolver en un arreglo de objetos. 

        return $resultado;
    }

    // Método para obtener la información de las materias los bootcamps:
        public function getMaterias(){
            // Llamamos al método heredado que contiene la información de la base de datos. 
            $pdo = $this->conectar();
    
            // Consulta SQL para obtener la información específica del bootcamp
            $consulta = $pdo->query("SELECT * FROM materia"); // Aquí es donde pedimos como tal la información de las materias los bootcamps
    
            $consulta->execute(); // Aquí me envía un arreglo de los bootcamps que hay en la base de datos. 
    
            // Asignamos en PHP que la información de la consulta es un arreglo a iterar. 
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC); // Aquí me lo va a devolver en un arreglo de objetos. 
    
            return $resultado;
        }

        // Método para guardar estudiante y sus materias
        public function Guardar(){
             // Usamos el método isset()

             if(isset($_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['carnet'], $_POST['correo'], $_POST['bootcamp'], $_POST['materia'])){

                $this->nombre = $_POST['nombre'];
                $this->direccion = $_POST['direccion'];
                $this->telefono = $_POST['telefono'];
                $this->carnet = $_POST['carnet'];
                $this->correo = $_POST['correo'];
                $this->password = 'Kodigo2023'; // Contraseña asignada por defecto. 
                $this->id_bootcamp = $_POST['bootcamp'];

                $estado = 1; // El estado 1 hace referencia al estatus “activo”
                $rol = 3; // El rol hace referencia al estudiante. 

                $pdo = $this->conectar(); // Se conecta con la base de datos. 

                // Proceso para insertar al estudiante: 
                $query1 = $pdo->prepare("INSERT INTO estudiantes(nombre,direccion,telefono,carnet,correo,password,id_bootcamp,id_estado,id_rol) VALUES (?,?,?,?,?,?,?,?,?)"); // En el VALUES los signos de interrogación hacen referencia a los campos vacíos que voy a llenar de información al insertar datos en la tabla.

                // Enviamos los valores del formulario a la consulta del INSERT en un arreglo y ejecutamos con el método execute();
                $resultado = $query1->execute(["$this->nombre","$this->direccion","$this->telefono","$this->carnet","$this->correo","$this->password","$this->id_bootcamp","$estado","$rol"]);

                // Revisamos mediante una condición si la consulta fue un éxito.

                if($resultado){ // Esta variable solamente ejecuta, y sólo devuelve un valor booleano de “true” o “false” si la consulta fue un éxito o hubo errores.
                    // Si todo fue un éxito, entonces generamos la segunda consulta.

                    $query2 = $pdo->query("SELECT id FROM estudiantes ORDER BY id DESC LIMIT 1"); // Esta es la segunda consulta. Aquí pido el último “id” de todos los que hay en la tabla, el número puede ser cualquiera, dependiendo de cuántos estudiantes registrados haya. 

                    // Ahora hay que ejcutar la consulta. 
                    $query2->execute(); // Objeto (id = valor);

                    // Asignamos el resultado de la consulta a un arreglo. 
                    $alumno = $query2->fetch(PDO::FETCH_ASSOC); 
                    $id_estudiante = $alumno['id']; // En esta variable guardamos el campo “id” del arreglo “alumno”.


                    // Ahora iteramos el arreglo de las materias para guardar en la tabla detalles. 
                    $arreglo_materias = $_POST['materia'];

                    for($i = 0; $i < count($arreglo_materias); $i++){
                        // Registramos en la tabla detalle_estudiante_materia.
                        $query3 = $pdo->prepare("INSERT INTO detalle_estudiante_materia(id_estudiante,id_materia) VALUES (?,?)");

                        $query3->execute([$id_estudiante, $arreglo_materias[$i]]);
                    }
                    echo "guardado";

                    // Redireccionando a la vista de la tabla de estudiantes:
                    // header('location = ./practica_kodigo/estudiantes_activos.php'); // Método para redireccionar de una página a otra. No está muy optimizado que se diga, por lo que no es muy recomendable.
                    echo "<script>
                        window.location = './estudiantes_activos.php'
                    </script>";
                }
             }
        }

        // Método para obtener estudiantes activos, asíncronos o en reubicación:
        public function ObtenerEstudiantes(){
            $pdo = $this->conectar();

            $query = $pdo->query("SELECT estudiantes.id, estudiantes.nombre, estudiantes.carnet, estudiantes.correo, bootcamps.bootcamp, estado.estado FROM estudiantes INNER JOIN bootcamps ON estudiantes.id_bootcamp = bootcamps.id INNER JOIN estado ON estudiantes.id_estado = estado.id WHERE estado.id != 4");
            
            $query->execute();

            $resultado = $query->fetchAll(PDO::FETCH_ASSOC); // Obtenemos arreglo de objetos. 
            return $resultado; 
        }

        // Método para obtener estudiante por id:
        public function ObtenerById(){
            if(isset($_POST['id_estudiante'])){
                $this->id = $_POST['id_estudiante'];

                $pdo = $this->conectar();
                $query = $pdo->query("SELECT id, nombre, direccion, telefono, correo FROM estudiantes WHERE id = $this->id");

                $query->execute();
                $resultado = $query->fetchAll(PDO::FETCH_ASSOC); // Retornar arreglo de objetos.
                return $resultado; 
            }
        }

        //Método para actualizar estudiantes por su id:

        public function Actualizar(){
            if(isset($_POST['id_estudiante'], $_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['correo'])){
                $this->nombre = $_POST['nombre'];
                $this->direccion = $_POST['direccion'];
                $this->telefono = $_POST['telefono'];
                $this->correo = $_POST['correo'];
                $this->id = $_POST['id_estudiante'];

                $pdo = $this->conectar();
                $query = $pdo->prepare("UPDATE estudiantes SET nombre = ?, direccion = ?, telefono = ?, correo = ? WHERE id = ?");
                $resultado = $query->execute(["$this->nombre","$this->direccion","$this->telefono","$this->correo","$this->id"]);

                if($resultado){
                    echo "<script>
                        window.location = './estudiantes_activos.php'
                    </script>";
                } else {
                    echo "Error al actualizar estudiante";
                }
            }
        }

        // Método para seleccionar el estado en los modales.
        public function EstadoAsincronoDesercion(){
            $pdo = $this->conectar();

            $query = $pdo->query("SELECT * FROM estado WHERE id = 2 OR id = 4 OR id = 1"); // Hacemos la consulta SQL.

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC); // Devolvemos un arreglo de objetos.
            return $resultado;
        }

        // Método para actualizar el estado del estudiante
        public function ActualizarEstado(){
            if(isset($_POST['id_estudiante'], $_POST['estado'])){
                $this->id = $_POST['id_estudiante'];
                $estado = $_POST['estado'];

                $pdo = $this->conectar();

                $query = $pdo->prepare("UPDATE estudiantes SET id_estado = ? WHERE id = ?");

                $resultado = $query->execute([$estado,$this->id]); // Esta consulta puede ser un éxito o un fracaso, y de ser así, hay que condicionar. 

                // Condicionamos el resultado, para ver si la consulta fue exitosa o no. Si fue exitosa, entonces nos devuelve a la vista estudiantes_activos.php y de no ser así, nos indica un error.
                if($resultado){
                    echo "<script>
                        window.location = './estudiantes_activos.php'
                    </script>";
                } else{
                    echo 'Error al cambiar el estado';
                }
            }
        }

        // Método para cambiar estudiantes de bootcamps.
        public function ActualizarBootcamp(){
            if(isset($_POST['id_estudiante'], $_POST['bootcamp'])){
                $this->id = $_POST['id_estudiante'];
                $estado = 3; // Representa en la base de datos la reubicación.
                $this->id_bootcamp = $_POST['bootcamp'];

                $pdo = $this->conectar();

                $query = $pdo->prepare("UPDATE estudiantes SET id_estado = ?, id_bootcamp = ? WHERE id = ?");

                $resultado = $query->execute([$estado,$this->id_bootcamp,$this->id]); // Esta consulta puede ser un éxito o un fracaso, y de ser así, hay que condicionar. 

                // Condicionamos el resultado, para ver si la consulta fue exitosa o no. Si fue exitosa, entonces nos devuelve a la vista estudiantes_activos.php y de no ser así, nos indica un error.
                if($resultado){
                    echo "<script>
                        window.location = './estudiantes_activos.php'
                    </script>";
                } else{
                    echo 'Error al reubicar estudiante';
                }
            }
        }

        public function PerfilEstudiante(){
            $id = $_SESSION['id_estudiante'];

            $pdo = $this->conectar();

            $query = $pdo->query("SELECT estudiantes.nombre, estudiantes.carnet, estudiantes.direccion, estudiantes.telefono, estudiantes.correo, bootcamps.bootcamp FROM estudiantes INNER JOIN bootcamps ON estudiantes.id_bootcamp = bootcamps.id WHERE estudiantes.id = $id");;
            $query->execute();
            
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC); //[]
            return $resultado;
        }
}
?>