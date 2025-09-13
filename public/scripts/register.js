document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    const msg = document.getElementById("registerMsg");

    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const username = form.username.value.trim();
        const email = form.email.value.trim();
        const password = form.password.value.trim();
        const password2 = form.password2.value.trim();

        if (password !== password2) {
            msg.textContent = "❌ Hasła muszą być takie same!";
            msg.style.color = "red";
            return;
        }

        try {
            const res = await fetch("/backend/api/register.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ username, email, password })
            });

            const raw = await res.text();
            let data = null;
            try { data = JSON.parse(raw); } catch {}

            console.log("➡️ /register.php status:", res.status);
            console.log("➡️ raw:", raw);

            if (!res.ok || !data?.success) {
                msg.textContent = (data && data.error) ? ("❌ " + data.error) : "❌ Rejestracja nieudana.";
                msg.style.color = "red";
                return;
            }

            msg.textContent = data.message || "✅ Konto zostało utworzone";
            msg.style.color = "green";

            
            form.reset();
        } catch (err) {
         
            msg.textContent = "❌ Błąd połączenia z serwerem";
            msg.style.color = "red";
            console.error(err);
        }
    });
});
