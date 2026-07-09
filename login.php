<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'admin' && $password == 'admincantik') {
        $_SESSION['login'] = true;
        $_SESSION['nama_admin'] = 'Administrator'; 
        
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin Spa</title>
    <style>
        body { background-color:#fffafb; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8pxrgba(0,0,0,0.1); border-top: 5px solid#f06292; width: 100%; max-width: 350px; text-align: center; }
        h2 { color:#d81b60; margin-bottom: 20px; }
        input { width: 90%; padding: 10px; margin-bottom: 15px; border: 1px solid#f48fb1; border-radius: 5px; box-sizing: border-box;}
        input:focus { outline: none; border-color:#d81b60; }
        button { background-color:#f06292; color: white; padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer; font-weight: bold; width: 100%; }
        button:hover { background-color:#e91e63; }
        .error { color: red; font-size: 14px; margin-bottom: 15px; background:#ffebee; padding: 10px; border-radius: 5px;}
    </style>
</head>
<body>

   <div class="login-box">
        <h2> Login Admin</h2>
        
        <?php if(isset($error)) { echo "<div class='error'>$error</div>"; } ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit">Masuk</button>
        </form>
        </div>

</body>
</html>