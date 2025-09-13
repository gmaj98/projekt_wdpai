document.addEventListener("DOMContentLoaded", async () => {
    const table = document.getElementById("rankingTable");

    try {
        const res = await fetch("/backend/api/ranking.php");
        const data = await res.json();

        if (!res.ok) {
            table.innerHTML = `<tr><td colspan="5">❌ ${data.error || "Błąd połączenia"}</td></tr>`;
            return;
        }

        if (data.length === 0) {
            table.innerHTML = `<tr><td colspan="5">Brak danych w rankingu</td></tr>`;
            return;
        }

        table.innerHTML = "";
        data.forEach((row, i) => {
            table.innerHTML += `
              <tr>
                <td>${i + 1}</td>
                <td>${row.username}</td>
                <td>${row.points}</td>
                <td>${row.distance_km} km</td>
                <td>${row.max_speed_kmh} km/h</td>
              </tr>
            `;
        });
    } catch (err) {
        console.error(err);
        table.innerHTML = `<tr><td colspan="5">❌ Błąd połączenia z serwerem</td></tr>`;
    }
});
