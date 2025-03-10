document.getElementById("login-btn").addEventListener("click", async () => {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const response = await fetch("http://localhost:3000/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
    });

    const data = await response.json();

    if (response.ok) {
        document.getElementById("login-container").style.display = "none";
        document.getElementById("assistant-container").style.display = "block";
    } else {
        document.getElementById("login-error").style.display = "block";
        document.getElementById("login-error").innerText = data.error;
    }
});
