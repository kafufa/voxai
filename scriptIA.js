ocument.getElementById("start-btn").addEventListener("click", () => {
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = "es-ES";
    recognition.start();

    document.getElementById("response").innerText = "Escuchando...";
    document.getElementById("start-btn").style.display = "none";
    document.getElementById("stop-btn").style.display = "block";

    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        document.getElementById("response").innerText = "Procesando: " + transcript;
        sendMessage(transcript);
    };

    document.getElementById("stop-btn").addEventListener("click", () => {
        recognition.stop();
        document.getElementById("response").innerText = "Escucha detenida.";
        document.getElementById("start-btn").style.display = "block";
        document.getElementById("stop-btn").style.display = "none";
    });

    recognition.onerror = function(event) {
        document.getElementById("response").innerText = "Error en el reconocimiento de voz.";
        document.getElementById("start-btn").style.display = "block";
        document.getElementById("stop-btn").style.display = "none";
    };
});

document.getElementById("send-btn").addEventListener("click", () => {
    const userInput = document.getElementById("text-input").value;
    if (userInput.trim() !== "") {
        document.getElementById("response").innerText = "Procesando: " + userInput;
        sendMessage(userInput);
    }
});

function sendMessage(message) {
    fetch("http://127.0.0.1:5000/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("response").innerText = "Respuesta: " + data.response;
        speak(data.response);
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("response").innerText = "Hubo un error. Inténtalo de nuevo.";
    });
}

function speak(text) {
    const speech = new SpeechSynthesisUtterance(text);
    speech.lang = "es-ES";
    speech.rate = 1.1;
    speech.pitch = 1;
    window.speechSynthesis.speak(speech);
}
