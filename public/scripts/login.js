document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const errorBox = document.getElementById("loginError");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const payload = {
            username: form.username.value.trim(),
            password: form.password.value
        };

        try {
            const response = await fetch("/backend/api/login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.success) {
                errorBox.style.color = "green";
                errorBox.textContent = data.message;

                setTimeout(() => {
                    window.location.href = "/public/views/dashboard.php";
                }, 1000);
            } else {
                errorBox.style.color = "red";
                errorBox.textContent = data.error || "Błąd logowania";
            }

        } catch (err) {
            console.error("Błąd:", err);
            errorBox.style.color = "red";
            errorBox.textContent = "❌ Błąd połączenia z serwerem";
        }
    });
});
