
document.addEventListener("DOMContentLoaded", async () => {
    try {
        const res = await fetch("/backend/api/activity.php");
        const data = await res.json();
        console.log("📊 API response:", data);

        if (data.success && data.stats) {
            const stats = data.stats;
            document.getElementById("statUserId").textContent = stats.user_id;
            document.getElementById("statDistance").textContent = stats.distance + " km";
            document.getElementById("statSpeed").textContent = stats.speed + " km/h";
            document.getElementById("statPoints").textContent = stats.points;
        }
    } catch (err) {
        console.error("❌ Błąd połączenia:", err);
    }
});

document.getElementById("activityForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const distance = parseFloat(document.getElementById("inputDistance").value);
    const speed = parseFloat(document.getElementById("inputSpeed").value);
    const msgBox = document.getElementById("activityMsg");

    try {
        const res = await fetch("/backend/api/add_activity.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ distance, speed })
        });

        const data = await res.json();
        console.log("➡️ add_activity response:", data);

        if (data.success) {
            msgBox.textContent = "✅ Aktywność dodana!";
            msgBox.style.color = "green";
            setTimeout(() => location.reload(), 1000);
        } else {
            msgBox.textContent = "❌ " + (data.error || "Błąd");
            msgBox.style.color = "red";
        }
    } catch (err) {
        console.error(err);
        msgBox.textContent = "❌ Błąd połączenia";
        msgBox.style.color = "red";
    }
});
