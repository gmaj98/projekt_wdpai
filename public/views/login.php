<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>

    <link href="/public/styles/main.css" rel="stylesheet">
    <link href="/public/styles/header.css" rel="stylesheet">
    <link href="/public/styles/login.css" rel="stylesheet">
    <script defer src="/public/scripts/login.js"></script>

    <title>LOGIN</title>
</head>

<?php include __DIR__ . '/header.php'; ?>
<body id="login-page" class="flex-row-center-center">
    
    <div class="flex-column-center-center">
        <form id="loginForm" class="flex-column-center-center">
            <div class="form-control">
                <i class="fa-solid fa-envelope"></i>
                <input type="text" name="username" placeholder="Nazwa użytkownika lub email" required>
            </div>
            <div class="form-control">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Hasło" required>
            </div>
            <button type="submit">
                <i class="fa-solid fa-right-to-bracket"></i> LOG IN
            </button>
        </form>

        <p id="loginError" class="error" style="color:red; margin-top:10px;"></p>
    </div>

</body>
</html>
