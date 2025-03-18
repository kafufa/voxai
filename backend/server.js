// Sample JavaScript code to interact with an API
async function fetchDataFromAPI() {
  // Replace this with your actual API key, but don't share it publicly
  const API_KEY = "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";
  
  try {
    const response = await fetch('https://api.example.com/data', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${API_KEY}`,
        'Content-Type': 'application/json'
      }
    });
    
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    
    const data = await response.json();
    console.log('Data received:', data);
    return data;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
}

// Call the function
fetchDataFromAPI();
