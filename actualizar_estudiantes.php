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
    <?php include "./modulos/header.php";  
    ?>
   
    <main id="main">
        <section class="container">
            <h1>Actualización de Datos</h1>
            <?php
               require "./Clases/Estudiantes.php";

               $estudiantes = new Estudiante();
               $datos = $estudiantes->ObtenerById();
               //print_r($bootcamps);
            ?>
            <form action="" method="POST">
                <?php foreach($datos as $estudiante){?>
                    <input type="hidden" name="id_estudiante" value="<?php echo $estudiante['id']; ?>">
                <label for="">Nombre: </label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $estudiante['nombre'];?>">
                <br>
                <label for="">Dirección: </label>
                <input type="text" class="form-control" name="direccion" value="<?php echo $estudiante['direccion'];?>">
                <br>
                <label for="">Teléfono: </label>
                <input type="number" class="form-control" name="telefono" value="<?php echo $estudiante['telefono'];?>">
                <br>
                <label for="">Correo: </label>
                <input type="text" class="form-control" name="correo" value="<?php echo $estudiante['correo'];?>">
                <br>
                <input type="submit" class="btn btn-dark mt-4" name="enviar" value="Actualizar Datos" required>
                <?php } ?>
            </form>
            <?php $estudiantes->Actualizar(); ?>
        </section>
    </main>
    <?php include "./modulos/footer.php";  ?>
 
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/typed.js/typed.umd.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>