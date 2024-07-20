<?php
// Incluye el archivo de conexión a la base de datos de manera segura
require_once("conection_database.php");

if (isset($_POST["sendForm"])) {

    $name = trim(filter_input(INPUT_POST, "name_hidden"));
    $lastName = trim(filter_input(INPUT_POST, "lastName_hidden"));
    $age = filter_input(INPUT_POST, "age_hidden", FILTER_VALIDATE_INT);
    $gener = trim(filter_input(INPUT_POST, "gener_hidden",));
    $weight = filter_input(INPUT_POST, "weight_hidden", FILTER_VALIDATE_INT);
    $height = filter_input(INPUT_POST, "height_hidden", FILTER_VALIDATE_INT);
    $experience = trim(filter_input(INPUT_POST, "experience_hidden"));
    $username = trim(filter_input(INPUT_POST, "username"));
    $password = trim($_POST["password"]);
    $role = "Usuario";
    //$passwordCipher = password_hash($password, PASSWORD_DEFAULT);

    // Verifica que todos los campos estén llenos
    if (
        empty($name) || empty($lastName) || empty($age) || empty($gener) ||
        empty($weight) || empty($height) || empty($experience) || empty($username) || empty($password)
    ) {
        echo '<h5 class="alert-danger">RELLENA TODOS LOS CAMPOS</h5>';
    } else {
        // Utiliza consultas preparadas para evitar la inyección de SQL
        $query = "INSERT INTO usuario(nombre, apellido, edad, genero, peso, estatura, experiencia, usuario, contraseña, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conection, $query);

        if ($stmt) {
            // Enlaza los parámetros y ejecuta la consulta
            mysqli_stmt_bind_param($stmt, "ssisiiisss", $name, $lastName, $age, $gener, $weight, $height, $experience, $username, $password, $role);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../index.php");
            } else {
                echo "Error al ejecutar la consulta";
            }

            // Cierra la consulta preparada
            mysqli_stmt_close($stmt);
        } else {
            echo "Error en la preparación de la consulta";
        }
    }
}
