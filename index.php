<?php

session_start();


$users = [
    "Marouan" => "M@r0u@n!2024",
    "Ivan" => "1v@n_Seguro99",
    "Noa" => "N0a$ClaveXyz"
];


$loginError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    
    
    if (isset($users[$username]) && $users[$username] === $password) {
        
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        
      
        header("Location: https://kafufa.github.io/voxai/ia.html");
        exit;
    } else {
        $loginError = true;
    }
}
?>

