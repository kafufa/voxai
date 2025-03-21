require('dotenv').config();
const fetch = require('node-fetch'); 

async function fetchDataFromAPI() {
  // Obtén la clave API desde el archivo .env
  const API_KEY = process.env.OPENROUTER_API_KEY;

  if (!API_KEY) {
    console.error('Error: No se encontró la clave API en las variables de entorno.');
    return;
  }

  try {
    // Asegúrate de usar el endpoint correcto proporcionado por Deep Seek
    const response = await fetch('https://api.deepseek.com/v1/endpoint', { // Cambia 'endpoint' según sea necesario
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${API_KEY}`, // Incluye la clave API en el encabezado
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

// Llamada a la función
fetchDataFromAPI();
