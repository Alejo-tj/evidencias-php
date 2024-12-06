<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=vacunate", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexion Exitosa";
} catch(PDOException $e) {
  echo "Conexion Fallida: " . $e->getMessage();
}

function insertarUsuario($conn, $nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $fecha_nacimiento) {
    try {
        $sql = "INSERT INTO Clientes (nombre, apellido, tipo_documento, numero_documento, telefono, fecha_nacimiento) 
                VALUES (:nombre, :apellido, :tipo_documento, :numero_documento, :telefono, :fecha_nacimiento)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':tipo_documento', $tipo_documento);
        $stmt->bindParam(':numero_documento', $numero_documento);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error al registrar los datos.";
        }
    } catch (PDOException $e) {
        echo "Error en la inserción de datos: " . $e->getMessage();
    }
}

function actualizarUsuario($conn, $nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $fecha_nacimiento) {
    try {
        $sql = "UPDATE Clientes SET apellido = :apellido, tipo_documento = :tipo_documento, numero_documento = :numero_documento, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento WHERE numero_documento = :numero_documento";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':tipo_documento', $tipo_documento);
        $stmt->bindParam(':numero_documento', $numero_documento);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

        if ($stmt->execute()) {
            echo "Usuario actualizado exitosamente.";
        } else {
            echo "Error al actualizar usuario.";
        }
    } catch (PDOException $e) {
        echo "Error al actualizar usuario: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $tipo_documento = htmlspecialchars(trim($_POST['tipo_documento']));
    $numero_documento = htmlspecialchars(trim($_POST['numero_documento']));
    $telefono = htmlspecialchars(trim($_POST['telefono']));
    $fecha_nacimiento = htmlspecialchars(trim($_POST['fecha_nacimiento']));

    if (isset($_POST['enviar'])) {
        insertarUsuario($conn, $nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $fecha_nacimiento);
    } elseif (isset($_POST['accion'])) {
        actualizarUsuario($conn, $nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $fecha_nacimiento);
    }
}
?>
