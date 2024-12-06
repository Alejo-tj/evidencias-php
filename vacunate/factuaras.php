<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Base de Datos</title>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre">Ingrese el nombre del cliente:</label>
        <input type="text" id="nombre" name="nombre">
        <input type="submit" value="Consultar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = htmlspecialchars($_POST["nombre"]);

        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "vacunate";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexión exitosa a la base de datos <br>";

            // Consulta para obtener el nombre específico y los productos asociados
            $sql = "SELECT clientes.nombre, productos.nombre_producto 
                    FROM clientes 
                    JOIN productos ON clientes.id_cliente = productos.id_producto
                    WHERE clientes.nombre = :nombre";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();

            // Mostrar el resultado
            if ($stmt->rowCount() > 0) {
                echo "Resultados encontrados:<br>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "Nombre del cliente: " . $row['nombre'] . "<br>";
                    echo "Nombre del producto: " . $row['nombre_producto'] . "<br><br>";
                }
            } else {
                echo "No se encontraron resultados para el nombre especificado.";
            }
        } catch(PDOException $e) {
            echo "Error en la conexión o consulta: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
