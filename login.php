<?php
// Configuración de la conexión a la base de datos
$host = "localhost"; // Cambia esto al host de tu base de datos
$dbname = "mi_base_de_datos"; // Cambia esto al nombre de tu base de datos
$username = "usuario_db"; // Cambia esto a tu usuario de la base de datos
$password = "contraseña_db"; // Cambia esto a tu contraseña de la base de datos

// Iniciar la sesión
session_start();

// Crear respuesta por defecto
$response = array(
    'success' => false,
    'message' => 'Error de autenticación',
    'redirect' => 'https://github.com/kafufa/voxai/blob/main/paguinainicioia.html'
);

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $user = isset($_POST['username']) ? $_POST['username'] : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';
    
    try {
        // Conectar a la base de datos usando PDO
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Configurar el modo de error de PDO a excepción
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Preparar la consulta SQL (usando consultas preparadas para prevenir inyección SQL)
        $stmt = $conn->prepare("SELECT id, username, password FROM usuarios WHERE username = :username");
        $stmt->bindParam(':username', $user);
        $stmt->execute();
        
        // Verificar si el usuario existe
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar la contraseña (usando password_verify si las contraseñas están hash)
            if (password_verify($pass, $row['password'])) {
                // Autenticación exitosa
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                
                $response['success'] = true;
                $response['message'] = 'Login exitoso';
            }
        }
    } catch(PDOException $e) {
        $response['message'] = "Error de conexión: " . $e->getMessage();
    }
    
    // Cerrar la conexión
    $conn = null;
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
