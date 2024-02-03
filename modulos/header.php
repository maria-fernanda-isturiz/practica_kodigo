<?php
function CerrarSesion(){ // Método para cerrar sesión.
    if(isset($_POST['cerrar_sesion'])){
        session_destroy(); // Se destruyen las sesiones. 
        header("location: ./index.php"); // Se redirecciona al usuario al index. 
    }
}
?>
<i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

<header id="header">
    <div class="d-flex flex-column">

        <div class="profile">
        <img src="assets/img/profile-logo.png" alt="" class="img-fluid rounded-circle">
        <h1 class="text-light"><a href="#">Usuario</a><?php echo $_SESSION['nombre_admin'];?></h1>
        </div>

        <nav id="navbar" class="nav-menu navbar">
        <ul>
            <li>
                <a href="home_admin.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a>
            </li>
            <li>
                <a href="estudiantes_activos.php" class="nav-link scrollto"><i class="bx bxs-user-detail"></i> <span>Gestion Estudiantes</span></a>
            </li>
            <li>
                <a href="profesores_activos.php" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Gestion Profesores</span></a>
            </li>
            <li>
                <form action="" method="POST">
                    <input type="submit" class="btn btn-danger px-2" name="cerrar_sesion" value="Cerrar Sesion">
                </form>
                <?php
                CerrarSesion(); // Se invoca a la función. 
                ?>
            </li>
        </ul>
        </nav>
    </div>
</header>