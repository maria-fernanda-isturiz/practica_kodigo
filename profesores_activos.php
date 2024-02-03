<?php
session_start(); // Método para mantener la sesión iniciada. Se coloca SIEMPRE al inicio de cualquier vista HTML cuando se trabaje formularios de inicio de sesión con PHP
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SISTEMA ACADEMIA KODIGO</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
 
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
 
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
 
<body>
    <?php
        include "./modulos/header.php"; 
        require "./Clases/Profesores.php";
        $profesor = new Profesor();
        $materias = $profesor->ObtenerMaterias();
        $coaches = $profesor->ObtenerProfesores();
        $estados = $profesor->EstadoActivoInactivo();
    ?>
    <main id="main">
        <section class="container">
            <h1>Gestión de profesores activos</h1>
            <a href="./registrar_profesores.php" class="btn btn-primary mb-3">Registrar</a>
            <table class="table">
                <thead>
                    <th>Profesor</th>
                    <th>Título</th>
                    <th>Correo</th>
                    <th>Materia</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php foreach($coaches as $coach){ ?>
                        <tr>
                            <td><?php echo $coach['nombre'];?></td>
                            <td><?php echo $coach['titulo'];?></td>
                            <td><?php echo $coach['correo'];?></td>
                            <td><?php echo $coach['materia'];?></td>
                            <td><?php echo $coach['estado'];?></td>
                            <td>
                                <form action="./actualizar_profesores.php" method="POST">
                                    <input type="hidden" name="id_profesor" value="<?php echo $coach['id']; ?>">
                                    <input type="submit" class="btn btn-info" value="Editar">
                                </form>
                            </td>
                            <td>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalEstado<?php echo $coach['id'];?>">Estado</button>
                            </td>
                            <td>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalMateria<?php echo $coach['id'];?>">Materia</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="ModalEstado<?php echo $coach['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cambio de Estado</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="id_profesor" value="<?php echo $coach['id'];?>">
                            <h5><?php echo $coach['nombre'];?></h5>
                            <p><strong>Estado: </strong>Activo</p>
                            <label for="" class="form-label">Cambio de Estado</label>
                            <select name="estado" id="" class="form-control">
                                <?php foreach($estados as $estado){?>
                                    <option value="<?php echo $estado['id'];?>"> <?php echo $estado['estado'];?></option>
                                <?php } ?>
                            </select>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <input type="submit" class="btn btn-danger" value="Cambiar Estado">
                            </div>
                            </form>
                            <?php $profesor->ActualizarEstado(); ?>
                            </div>
                            </div>
                        </div>

                        <div class="modal fade" id="ModalMateria<?php echo $coach['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar Materia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="POST">
                        <div class="modal-body">
                        <input type="hidden" name="id_profesor" value="<?php echo $coach['id'];?>">
                        <h5><?php echo $coach['nombre'];?></h5>
                        <p><strong>Materia Actual: <?php echo $coach['materia'];?></strong></p>
                        <label for="" class="form-label">Cambiar Materia</label>
                        <select name="materia" class="form-control" id="">
                            <?php
                                foreach($materias as $materia){
                            ?>
                                <option value="<?php echo $materia["id"]; ?>"><?php echo $materia["materia"]; ?></option>
                            <?php } ?></select>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-danger" value="Cambiar Materia">
                        </div>
                        </form>
                        <?php $profesor->ActualizarMateria();?>
                        </div>
                        </div>
                        </div>
                    <?php }?>
                </tbody>
            </table>
        </section>
    </main>
    <?php include "./modulos/footer.php";  ?>
 
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/typed.js/typed.umd.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>