<?php
// Datos de conexión
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto de XAMPP
$dbname = "pedidos"; // Cambia esto al nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$tipo_pizza = isset($_POST['tipo_pizza']) ? $_POST['tipo_pizza'] : '';
$contacto = isset($_POST['contacto']) ? $_POST['contacto'] : '';
$envio = isset($_POST['envio']) ? $_POST['envio'] : '';

// Imprimir datos recibidos para depuración
echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
echo "Apellido: " . htmlspecialchars($apellido) . "<br>";
echo "Tipo de pizza: " . htmlspecialchars($tipo_pizza) . "<br>";
echo "Contacto: " . htmlspecialchars($contacto) . "<br>";
echo "Envío: " . htmlspecialchars($envio) . "<br>";

// Verificar que los datos no estén vacíos
if (empty($nombre) || empty($apellido) || empty($tipo_pizza) || empty($contacto) || empty($envio)) {
    die("Error: Todos los campos son obligatorios.");
}


// Preparar y ejecutar la consulta SQL
$stmt = $conn->prepare("INSERT INTO pedidos (nombre, apellido, tipo_pizza, contacto, envio) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $apellido, $tipo_pizza, $contacto, $envio);

if ($stmt->execute()) {
    echo "Pedido registrado exitosamente";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
