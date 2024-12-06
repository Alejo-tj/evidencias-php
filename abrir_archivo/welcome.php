<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php include "footer.php";?>
 <br> <br>
    nombre:<?php echo $_POST["nombre"];?> <br>
    apellido: <?php echo $_POST["apellido"];?> <br>
    numero: <?php echo $_POST["telefono"];?> 
    cedula: <?php echo $_POST["cedula"];?>

<br>
    



<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=alejo", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexion Exitosa, con PDO Orientada a Objetos, extencion de PHP </br> :";
} catch(PDOException $e) {
  echo "Conexion Fallida, con PDO Orientada a Objetos, extencion de PHP </br> " . $e->getMessage();
}


// Función para insertar datos en la base de datos
function insertarUsuario($conn, $nombre, $apellido, $telefono,$cedula) {
  try {
      $sql = "INSERT INTO usuario (nombre, apellido, telefono,cedula) VALUES (:nombre, :apellido, :telefono, :cedula)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellido', $apellido);
      $stmt->bindParam(':telefono', $telefono);
      $stmt->bindParam(':cedula', $cedula);

      if ($stmt->execute()) {
          echo "Registro exitoso.";
      } else {
          echo "Error al registrar los datos.";
      }
  } catch (PDOException $e) {
      echo "Error en la inserción de datos: " . $e->getMessage();
  }
}

// Bloque de recepción de datos del formulario
$nombre = $apellido = $telefono = $cedula = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['cedula']) ){
      // Asignar y limpiar variables
      $nombre = htmlspecialchars(trim($_POST['nombre']));
      $apellido = htmlspecialchars(trim($_POST['apellido']));
      $telefono = htmlspecialchars(trim($_POST['telefono']));
      $cedula = htmlspecialchars(trim($_POST['cedula']));

      // Llamada a la función de inserción
      insertarUsuario($conn, $nombre, $apellido, $telefono, $cedula);
  } else {
      echo "Error: faltan datos obligatorios. Asegúrate de completar todos los campos.";
  }
}
?>

</body>
</html> 