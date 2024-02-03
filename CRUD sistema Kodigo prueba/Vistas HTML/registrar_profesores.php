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
    <?php include "./modulos/header.php"; ?>
    <main id="main">
        <section class="container">
        <h1>Registro de Profesores</h1>
        <?php
            require "./Clases/Profesores.php";
            $profesor = new Profesor();
            $bootcamps = $profesor->ObtenerBootcamps();
            $materias = $profesor->ObtenerMaterias();
        ?>
            <form action="" method="POST">
                <label for="">Nombre: </label>
                <input type="text" class="form-control" name="nombre" required>
                <br>
                <label for="">Dirección: </label>
                <input type="text" class="form-control" name="direccion" required>
                <br>
                <label for="">Título: </label>
                <input type="text" class="form-control" name="titulo" required>
                <br>
                <label for="">Correo: </label>
                <input type="text" class="form-control" name="correo" required>
                <br>
                <label for="">Seleccione Materia: </label><br>
                <select name="materia" class="form-control" id="">
                    <?php
                        foreach($materias as $materia){
                    ?>
                    <option value="<?php echo $materia['id'];?>"><?php echo $materia['materia'];?></option>
                <?php } ?></select>
                <br>
                <label for="">Seleccione Bootcamp: </label>
                <?php
                    foreach($bootcamps as $bootcamp){
                ?>
                <input type="checkbox" name="bootcamp[]" value="<?php echo $bootcamp['id'];?>"><?php echo $bootcamp['bootcamp']?>
                <?php } ?>
                <br><br>
                <input type="submit" class="btn btn-dark mt-4" name="enviar" value="Guardar Datos" required>
            </form>
            <?php
            $profesor->RegistrarProfesores();
            ?>
        </section>
    </main>
    <?php include "./modulos/footer.php";  ?>
 
 <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="assets/vendor/typed.js/typed.umd.js"></script>
 <script src="assets/js/main.js"></script>
 </body>
 </html>
</body>