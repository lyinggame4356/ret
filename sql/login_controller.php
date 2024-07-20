<?php
require_once("conection_database.php");

if (isset($_POST["sendLoginForm"])) {
    $userName = trim(filter_input(INPUT_POST, "userName"));
    $password = trim($_POST["password"]);

    if (empty($userName) || empty($password)) {
        echo '<h5 class="alert-danger">RELLENA TODOS LOS CAMPOS</h5>';
    } else {
        $query = "SELECT * FROM usuario WHERE usuario = ? AND contraseña = ?";
        $stmt = mysqli_prepare($conection, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $userName, $password);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $fila = mysqli_fetch_assoc($result);
                    $rol = $fila["rol"];

                    if ($rol == "Administrador") {
                        session_start();
                        $_SESSION['username'] = $userName;
                        header("Location: ../view/pages/admin_page.php");
                    } elseif ($rol == "Usuario") {
                        header("Location: ../view/pages/user.php");
                    } elseif ($rol == "Entrenador") {
                        header("Location: ../view/pages/trainer.php");
                    } elseif ($rol == "Cliente") {
                        header("Location: ../view/pages/nutritionist.php");
                    } else {
                        echo '<h5 class="alert-danger">USUARIO O CONTRASEÑA INCORRECTOS</h5>';
                    }
                } else {
                    echo '<h5 class="alert-danger">USUARIO O CONTRASEÑA INCORRECTOS</h5>';
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error al ejecutar la consulta";
            }
        } else {
            echo "Error en la preparación de la consulta";
        }
    }
}
