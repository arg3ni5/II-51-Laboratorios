<?php
include 'db.php';

// CREATE
if (isset($_POST['accion']) && $_POST['accion'] === 'insertar') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $sql = "INSERT INTO usuarios (nombre, correo) VALUES ('$nombre', '$correo')";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}

// READ (se usaría desde otro archivo como index.php)

// UPDATE
if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $sql = "UPDATE usuarios SET nombre='$nombre', correo='$correo' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}

// DELETE
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM usuarios WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
?>
