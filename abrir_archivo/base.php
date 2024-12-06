Codigo Para Crear Una Base de Datos, debes cambiar solo el nombre de la base de datos que se requiere crear, y los datos de conexion al motor de base de datos.


#<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE DATABASE perro_frito";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Database created successfully<br>";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>

Codigo para Crear Una Tabla, deben cambiar el nombre de la Base de datos y el de la tabla que se requiere crear.

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perro_frito";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to create table
  $sql = "CREATE TABLE tupla (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  apellido VARCHAR(30) NOT NULL,
  email VARCHAR(50),
  hora TIME NOT NULL
  )";

  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Table tupla created Exitosamente";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>
