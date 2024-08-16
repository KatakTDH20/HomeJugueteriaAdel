<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de conexión a MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "u365611342_jugueteriaadel";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recibir datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Validar datos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // Preparar y ejecutar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $mensaje);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Formulario enviado exitosamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al enviar el formulario.']);
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
} else {
    // Si no es una solicitud POST, devolver un error
    echo json_encode(['status' => 'error', 'message' => 'Solicitud inválida.']);
}
?>
