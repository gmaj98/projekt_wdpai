document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.querySelector("#usersTable");
    const errorBox = document.getElementById("adminError");

    async function loadUsers() {
        try {
            const res = await fetch("/backend/api/admin_users.php");
            const data = await res.json();

            tableBody.innerHTML = "";

            if (!res.ok || !data.success) {
                tableBody.innerHTML = `<tr><td colspan="6" style="color:red;">❌ ${data.error || "Błąd pobierania danych"}</td></tr>`;
                return;
            }

            data.users.forEach((u, i) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${i + 1}</td>
                    <td>${u.username}</td>
                    <td>${u.email}</td>
                    <td>${u.role}</td>
                    <td>${u.created_at}</td>
                    <td>
                        ${u.role !== "admin" ?
                        `<button class="btn-delete" data-id="${u.id}">🗑 Usuń</button>`
                        : "—"}
                    </td>
                `;
                tableBody.appendChild(row);
            });

            document.querySelectorAll(".btn-delete").forEach(btn => {
                btn.addEventListener("click", async () => {
                    const userId = btn.dataset.id;
                    if (!confirm("Na pewno chcesz usunąć tego użytkownika?")) return;

                    try {
                        const res = await fetch("/backend/api/admin_users.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ id: userId })
                        });

                        const result = await res.json();

                        if (result.success) {
                            alert(result.message);
                            loadUsers();
                        } else {
                            alert("❌ " + (result.error || "Błąd usuwania użytkownika"));
                        }
                    } catch (err) {
                        console.error("❌ Błąd:", err);
                        alert("❌ Błąd połączenia z serwerem");
                    }
                });
            });

        } catch (err) {
            console.error("❌ Błąd wczytywania użytkowników:", err);
            tableBody.innerHTML = `<tr><td colspan="6" style="color:red;">❌ Błąd połączenia z serwerem</td></tr>`;
        }
    }

    loadUsers();
});
