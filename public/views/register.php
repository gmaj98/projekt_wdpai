<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>

  <link href="/public/styles/main.css" rel="stylesheet">
  <link href="/public/styles/header.css" rel="stylesheet">
  <link href="/public/styles/login.css" rel="stylesheet">


  <script defer src="/public/scripts/register.js"></script>

  <title>REGISTER</title>
</head>
<body id="login-page" class="flex-row-center-center">
  <?php include __DIR__ . '/header.php'; ?>

  <div class="flex-column-center-center">
    <h2>📝 Rejestracja</h2>


    <form id="registerForm" class="flex-column-center-center" method="post" action="/backend/api/register.php" novalidate>
      <div class="form-control">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="username" placeholder="Nazwa użytkownika" required>
      </div>

      <div class="form-control">
        <i class="fa-solid fa-envelope"></i>
        <input type="email" name="email" placeholder="Email" required>
      </div>

      <div class="form-control">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="Hasło (min. 6)" minlength="6" required>
      </div>

      <div class="form-control">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password2" placeholder="Powtórz hasło" minlength="6" required>
      </div>

      <button type="submit">
        <i class="fa-solid fa-user-plus"></i> Zarejestruj się
      </button>
    </form>

    <p id="registerMsg" style="margin-top:10px;"></p>
  </div>
</body>
</html>
