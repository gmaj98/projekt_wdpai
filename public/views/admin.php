<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: /public/views/login.php");
    exit;
}

$currentUser = $_SESSION["username"] ?? "Nieznany użytkownik";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Panel Admina - Ski Slopes</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/header.css">
  <link rel="stylesheet" href="/public/styles/admin.css">
  <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>
</head>
<body>
  <?php include __DIR__ . "/header.php"; ?>

  <main>
    <h2 class="text-2xl font-bold mb-4">👑 Panel Administratora</h2>
    <p>Zalogowany jako: <strong><?php echo htmlspecialchars($currentUser); ?></strong></p>
    <div id="adminError" class="text-red-600 mt-2"></div>

    <table class="admin-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Użytkownik</th>
          <th>Email</th>
          <th>Rola</th>
          <th>Data utworzenia</th>
          <th>Akcje</th>
        </tr>
      </thead>
      <tbody id="usersTable">

      </tbody>
    </table>
  </main>

  <script>
    async function loadUsers() {
      try {
        const res = await fetch("/backend/api/admin_users.php");
        const data = await res.json();

        const table = document.getElementById("usersTable");
        table.innerHTML = "";

        if (!res.ok || !data.success) {
          document.getElementById("adminError").textContent =
            "❌ " + (data.error || "Błąd pobierania danych");
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
          table.appendChild(row);
        });


        document.querySelectorAll(".btn-delete").forEach(btn => {
          btn.addEventListener("click", async (e) => {
            const userId = e.target.closest("button").dataset.id;
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
        document.getElementById("usersTable").innerHTML =
          `<tr><td colspan="6" style="color:red;">❌ Błąd połączenia z serwerem</td></tr>`;
      }
    }


    document.addEventListener("DOMContentLoaded", loadUsers);
  </script>
</body>
</html>
