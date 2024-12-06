<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    nombre: <?php echo $_POST["nombre"];?> <br>
    apellido: <?php echo $_POST["apellido"];?> <br>
    E-mail: <?php echo $_POST["email"];?> <br>
    hora: <?php echo $_POST["hora"];?>
    <br>

    <br>
 <?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=perro_frito", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexion Exitosa, con PDO Orientada a Objetos, extencion de PHP </br> :";
} catch(PDOException $e) {
  echo "Conexion Fallida, con PDO Orientada a Objetos, extencion de PHP </br> " . $e->getMessage();
}


// Función para insertar datos en la base de datos
function insertarUsuario($conn, $nombre, $apellido, $email, $hora) {
  try {
      $sql = "INSERT INTO tupla ( nombre, apellido, email, hora) VALUES (:nombre, :apellido, :email, :hora)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellido', $apellido);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':hora', $hora);

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
 $nombre = $apellido = $email = $hora = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ( isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['hora']) ){
      // Asignar y limpiar variables
      $nombre = htmlspecialchars(trim($_POST['nombre']));
      $apellido = htmlspecialchars(trim($_POST['apellido']));
      $email = htmlspecialchars(trim($_POST['email']));
      $hora = htmlspecialchars(trim($_POST['hora']));

      // Llamada a la función de inserción
      insertarUsuario($conn, $nombre, $apellido, $email, $hora);
  } else {
      echo "Error: faltan datos obligatorios. Asegúrate de completar todos los campos.";
  }
}
?>

</body>
</html>