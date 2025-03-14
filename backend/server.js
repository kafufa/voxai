const express = require("express");
const mysql = require("mysql2");
const bcrypt = require("bcrypt");
const cors = require("cors");

const app = express();
app.use(express.json());
app.use(cors());

// Configuración de la base de datos MySQL
const db = mysql.createConnection({
    host: "localhost",
    user: "root", // Cambia esto según tu configuración
    password: "Super3", // Si tienes una contraseña, ponla aquí
    database: "voxai_db"
});

// Conectar a la base de datos
db.connect(err => {
    if (err) {
        console.error("Error conectando a la base de datos:", err);
    } else {
        console.log("Conectado a la base de datos MySQL");
    }
});

// Ruta para login
app.post("/login", (req, res) => {
    const { username, password } = req.body;
   
    const sql = "SELECT * FROM users WHERE username = ?";
    db.query(sql, [username], (err, results) => {
        if (err) {
            return res.status(500).json({ error: "Error en el servidor" });
        }

        if (results.length === 0) {
            return res.status(401).json({ error: "Usuario no encontrado" });
        }

        const user = results[0];
       
        bcrypt.compare(password, user.password_hash, (err, isMatch) => {
            if (isMatch) {
                res.json({ message: "Login exitoso" });
            } else {
                res.status(401).json({ error: "Contraseña incorrecta" });
            }
        });
    });
});

app.listen(3000, () => {
    console.log("Servidor corriendo en http://localhost:3000");
});
