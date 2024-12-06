nombre de producto <?php echo $_POST["nombre_producto"];?> <br>
lote de producto <?php echo $_POST["lote_producto"];?> <br>
valor <?php echo $_POST["valor"];?>




<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=vacunate", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexion Exitosa, con PDO Orientada a Objetos, extencion de PHP </br> :";
} catch(PDOException $e) {
  echo "Conexion Fallida, con PDO Orientada a Objetos, extencion de PHP </br> " . $e->getMessage();
}



// Función para insertar datos en la base de datos
function insertarUsuario($conn, $nombre_producto, $lote_producto, $valor) {
    try {
        $sql = "INSERT INTO productos (nombre_producto, lote_producto, valor ) VALUES (:nombre_producto, :lote_producto, :valor )";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre_producto', $nombre_producto);
        $stmt->bindParam(':lote_producto', $lote_producto);
        $stmt->bindparam(':valor', $valor);
        
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
  $nombre_producto = $lote_producto = $valor  = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre_producto']) && isset($_POST['lote_producto'])  && isset($_POST['valor']) ) {
        // Asignar y limpiar variables
        $nombre_producto = htmlspecialchars(trim($_POST['nombre_producto']));
        $lote_producto = htmlspecialchars(trim($_POST['lote_producto']));
        $valor = htmlspecialchars(trim($_POST['valor']));
        // Llamada a la función de inserción
        insertarUsuario($conn, $nombre_producto, $lote_producto, $valor);
    } else {
        echo "Error: faltan datos obligatorios. Asegúrate de completar todos los campos.";
    }
  }
  ?>