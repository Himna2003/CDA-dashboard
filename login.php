<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CDA Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-container {
      background-color: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
      width: 350px;
      text-align: center;
    }
    .login-container img {
      width: 100px;
      margin-bottom: 20px;
    }
    input[type="text"], input[type="password"] {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      background-color: darkgreen;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: green;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <img src="CDALOGO.png" alt="CDA Logo">
    <h2>Login to Dashboard</h2>
    <form action="login.php" method="POST">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>

    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST['username'];
      $password = $_POST['password'];

      // 🔒 Replace with database check if needed
      $valid_user = "admin";
      $valid_pass = "12345";

      if ($username === $valid_user && $password === $valid_pass) {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();
      } else {
        echo "<p style='color:red;'>Invalid username or password</p>";
      }
    }
    ?>
  </div>
</body>
</html>
