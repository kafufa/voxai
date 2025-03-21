require('dotenv').config(); // Cargar las variables de entorno desde el archivo .env
const express = require('express'); // Framework para manejar las solicitudes HTTP
const fetch = require('node-fetch'); // Para realizar solicitudes a la API externa

const app = express();
const PORT = process.env.PORT || 3000; // Puerto del servidor

// Leer la clave API desde las variables de entorno
const API_KEY = process.env.OPENROUTER_API_KEY;

// Verificar si la clave API está configurada
if (!API_KEY) {
  console.error('Error: No se encontró la clave API en las variables de entorno.');
  process.exit(1); // Finalizar la ejecución si falta la clave API
}

// Endpoint para interactuar con la API externa
app.get('/api/data', async (req, res) => {
  try {
    const response = await fetch('https://api.deepseek.com/v1/endpoint', { // Cambia 'endpoint' según la documentación
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${API_KEY}`, // Autenticación con la clave API
        'Content-Type': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`Error HTTP: Status ${response.status}`);
    }

    const data = await response.json();
    res.json(data); // Enviar los datos como respuesta al cliente
  } catch (error) {
    console.error('Error al obtener datos de la API:', error.message);
    res.status(500).json({ error: 'Error al obtener datos de la API' });
  }
});

// Iniciar el servidor
app.listen(PORT, () => {
  console.log(`Servidor funcionando en http://localhost:${PORT}`);
});
