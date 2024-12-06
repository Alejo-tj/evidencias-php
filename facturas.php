<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacunate</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            list-style: none;
            font-family: sans-serif;
            box-sizing: border-box;
        }
        a {
            color: black;
            text-decoration: none;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        #chat {
            position: fixed;
            width: 250px;
            height: 40px;
            bottom: 0;
            right: 20px;
            background: rgb(43, 0, 255);
            z-index: 1;
            color: white;
            text-align: center;
            line-height: 40px;
            font-family: 'Kaushan Script', cursive;
            font-size: 20px;
            border-radius: 20px 20px 0 0;
            cursor: pointer;
        }
        header {
            position: relative;
            margin: 20px auto;
            width: 100%;
            max-width: 1000px;
            height: 120px;
            border-radius: 20px;
            background-color: #04505a;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        #logo {
            font-family: 'Kaushan Script', cursive;
            font-size: 24px;
            text-align: center;
        }
        .redes {
            width: 61px;
            height: 50px;
            background: #ccc;
            border-radius: 100%;
            line-height: 42px;
            text-align: center;
            color: white;
            margin-left: 10px;
        }
        #icono1 {
            background-color: blue;
        }
        #icono2 {
            background: green;
        }
        #icono3 {
            background: red;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 160px);
        }
        .alejo {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .alejo label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .alejo input[type="text"], .alejo input[type="number"], .alejo input[type="date"], .alejo select {
            width: 90%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .alejo input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .alejo input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
   
    <div id="chat">chat</div>
    <!--inicio de encabezado-->
    <header>
        <div id="logo">VACUNATE SAS.</div>
        <div class="redes" id="icono1">
            <a href="registro.html">registro</a>
        </div>
        <div class="redes" id="icono2">
            <a href="vacunas.html">vacunas</a>
        </div>
        
        <div class="redes" id="icono3">
            <a href="facturas.html">facturas</a>
        </div>
    </header>
    <br>
    <!--final de encabezado-->
    <div class="container">
    <?php
    $nombreCliente = $nombreProducto = $cantidad = $valorTotal = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
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
            $sql = "SELECT clientes.nombre, productos.nombre_producto, productos.valor
                    FROM clientes 
                    JOIN productos ON clientes.id_cliente = productos.id_producto
                    WHERE clientes.nombre = :nombre";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();

            // Almacenar el resultado
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $nombreCliente = $row['nombre'];
                $nombreProducto = $row['nombre_producto'];
                
                // Calcular el valor total basado en la cantidad y el valor del producto
                $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;
                $valorProducto = $row['valor'];
                $valorTotal = $cantidad * $valorProducto;

                // Insertar los datos en la tabla facturas
                if (isset($_POST['enviar'])) {
                    $sqlInsert = "INSERT INTO facturas (nombre, nombre_producto, cantidad, valor_total) VALUES (:nombre, :nombre_producto, :cantidad, :valor_total)";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->bindParam(':nombre', $row['nombre']);
                    $stmtInsert->bindParam(':nombre_producto', $nombreProducto);
                    $stmtInsert->bindParam(':cantidad', $cantidad);
                    $stmtInsert->bindParam(':valor_total', $valorTotal);
                    $stmtInsert->execute();
                    echo "Factura agregada exitosamente.";
                }
            } else {
                echo "No se encontraron resultados para el nombre especificado.";
            }
        } catch(PDOException $e) {
            echo "Error en la conexión o consulta: " . $e->getMessage();
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="alejo">
        <div>
            
            <input type="submit" value="buscar">
        </div>
        <div>
        
            <label>nombre</label>
            <input type="text" name="nombre" value="<?php echo $nombreCliente; ?>"> 
        </div>
        <div>
            <label>nombre de producto</label> <br>
            <input type="text" name="nombre_producto" value="<?php echo $nombreProducto; ?>"> 
        </div>
        <div>
            <label>cantidad</label>
            <input type="number" name="cantidad" value="<?php echo $cantidad; ?>">
        </div>
        <div>
            <label>valor total</label>
            <input type="number" name="valor_total" value="<?php echo $valorTotal; ?>">
        </div>
        <input type="submit" name="enviar" value="agregar">
    </form>

    </div>
</body>
</html>
