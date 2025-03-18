// Cargar las variables de entorno
require('dotenv').config();
const fetch = require('node-fetch'); // Asegúrate de instalar este paquete si estás usando Node.js

// Función para interactuar con la API
async function fetchDataFromAPI() {
  // Obtener la clave de la API desde el archivo .env
  const API_KEY = process.env.OPENROUTER_API_KEY;

  if (!API_KEY) {
    console.error('Error: No se encontró la clave API en las variables de entorno.');
    return;
  }

  try {
    const response = await fetch('https://api.example.com/data', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${API_KEY}`,
        'Content-Type': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`Error HTTP: Status ${response.status}`);
    }

    const data = await response.json();
    console.log('Datos recibidos:', data);
    return data;
  } catch (error) {
    console.error('Error al obtener datos de la API:', error.message);
  }
}

// Llamar a la función
fetchDataFromAPI();
