<?php
session_start();
include "config.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']); 
    $password = trim($_POST['password']);

    // --- check in users table ---
    $sql = "SELECT * FROM users WHERE (email='$username' OR name='$username') AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['name'];
        $_SESSION['role'] = 'user';
        header("Location: user_dashboard.php");
        exit();
    }

    // --- check in admins table ---
    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    }

    // if nothing matches
    $error = "Invalid username or password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CDA Login</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: url('Faisal Masjid, Islamabad.jpg') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .container {
        background: rgba(255, 255, 255, 0.95); /* slightly transparent */
        padding: 30px;
        width: 380px;
        border-radius: 12px;
        box-shadow: 0px 6px 15px rgba(0,0,0,0.1);
        text-align: center;
        position: relative;
    }
    .logo {
        position: absolute;
        top: 15px;
        left: 15px;
        width: 60px;
        height: auto;
    }
    h2 {
        color: #67C090;
        margin-top: 0;
        margin-bottom: 25px;
    }
    input {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }
    input:focus {
        outline: none;
        border: 1px solid #67C090;
    }
    button {
        width: 100%;
        background: #67C090;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
    }
    button:hover {
        background: #56a87a;
    }
    p {
        margin-top: 15px;
        font-size: 14px;
    }
    p a {
        color: #67C090;
        text-decoration: none;
        font-weight: bold;
    }
    .error {
        color: red;
        font-size: 13px;
        margin-bottom: 10px;
    }
</style>

</head>
<body>
  <div class="container">
    <img src="cda.webp" alt="CDA Logo" class="logo">
    <h2>Welcome to CDA</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" autocomplete="off">
      <input type="text" name="username" placeholder="Email or Name" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>

    <p>New user? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
