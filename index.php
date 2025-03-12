<?php
// Iniciar sesión para manejar las sesiones de usuario
session_start();

// Usuarios y contraseñas seguras (simulación)
$users = [
    "Marouan" => "M@r0u@n!2024",
    "Ivan" => "1v@n_Seguro99",
    "Noa" => "N0a$ClaveXyz"
];

// Procesar el formulario cuando se envía
$loginError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    
    // Verificar credenciales
    if (isset($users[$username]) && $users[$username] === $password) {
        // Guardar información de sesión
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        
        // Redirigir a la página deseada
        header("Location: https://kafufa.github.io/voxai/ia.html");
        exit;
    } else {
        $loginError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoxAI - Asistente de Voz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Pantalla de Login -->
    <div id="login-container" class="container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" id="username" name="username" placeholder="Usuario">
            <input type="password" id="password" name="password" placeholder="Contraseña">
            <button type="submit" id="login-btn">Ingresar</button>
            <?php if ($loginError): ?>
                <p id="login-error" style="color: red;">Usuario o contraseña incorrectos</p>
            <?php endif; ?>
        </form>
    </div>

    <script>
    document.getElementById("start-btn").addEventListener("click", () => {
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = "es-ES";
        recognition.start();
        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            document.getElementById("response").innerText = "Procesando: " + transcript;
            fetch("https://hook.eu2.make.com/sw3ligopuhaxs11xorsf61ia5apje4hy", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    query: transcript
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("response").innerText = "Respuesta: " + data.response;
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById("response").innerText = "Hubo un error. Inténtalo de nuevo.";
            });
        };
    });
    </script>
</body>
</html>
