<?php
// Iniciar sesión para manejar las sesiones de usuario
session_start();

// Usuarios y contraseñas seguras (simulación)
$users = [
    "Marouan" => "M@r0u@n!2024",
    "Ivan" => "1v@n_Seguro99",
    "Noa" => "N0a$ClaveXyz"
];

// Variable para controlar qué formulario mostrar
$showRegistrationForm = isset($_GET['register']);

// Variables para mensajes de error/éxito
$loginError = false;
$registrationError = false;
$registrationSuccess = false;
$errorMessage = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    
  
    if (isset($users[$username]) && $users[$username] === $password) {
        // Guardar información de sesión
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        
    
        header("Location: https://kafufa.github.io/voxai/ia.html");
        exit;
    } else {
        $loginError = true;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $newUsername = $_POST["new_username"] ?? "";
    $newPassword = $_POST["new_password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";
    
    // Validación básica
    if (empty($newUsername) || empty($newPassword)) {
        $registrationError = true;
        $errorMessage = "Todos los campos son obligatorios";
    } elseif ($newPassword !== $confirmPassword) {
        $registrationError = true;
        $errorMessage = "Las contraseñas no coinciden";
    } elseif (isset($users[$newUsername])) {
        $registrationError = true;
        $errorMessage = "El nombre de usuario ya existe";
    } else {
       
        $registrationSuccess = true;
        
       
        $showRegistrationForm = false;
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
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 50px;
        }
        input, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        .toggle-link {
            text-align: center;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php if (!$showRegistrationForm): ?>
   
    <div id="login-container" class="container">
        <h2>Iniciar Sesión</h2>
        <?php if ($registrationSuccess): ?>
            <p class="success-message">¡Registro exitoso! Ahora puedes iniciar sesión.</p>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" id="username" name="username" placeholder="Usuario">
            <input type="password" id="password" name="password" placeholder="Contraseña">
            <button type="submit" name="login" id="login-btn">Ingresar</button>
            <?php if ($loginError): ?>
                <p id="login-error" style="color: red;">Usuario o contraseña incorrectos</p>
            <?php endif; ?>
        </form>
        <div class="toggle-link">
            <a href="?register=true">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </div>
    <?php else: ?>

    <div id="register-container" class="container">
        <h2>Crear Cuenta</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?register=true">
            <input type="text" id="new_username" name="new_username" placeholder="Elige un usuario">
            <input type="password" id="new_password" name="new_password" placeholder="Contraseña">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar contraseña">
            <button type="submit" name="register" id="register-btn">Registrarse</button>
            <?php if ($registrationError): ?>
                <p id="register-error" style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>
        <div class="toggle-link">
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
    <?php endif; ?>

    <script>
    
    if (document.getElementById("start-btn")) {
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
    }
    </script>
</body>
</html>
