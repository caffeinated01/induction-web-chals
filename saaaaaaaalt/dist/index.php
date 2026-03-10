<?php 
error_reporting(0);
ini_set('display_errors', 0);

session_start();

$admin_password = '<REDACTED>';
$random_string = 'an_additional_random_string_to_leengthen_the_hash_for_some_reason';
$flag = '<REDACTED>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $hash = password_hash('admin' . $random_string . $admin_password, PASSWORD_BCRYPT);

    if ($username === 'admin' && password_verify($username . $random_string . $password, $hash)) {
        $_SESSION['authenticated'] = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>A Salty Website</title>
</head>
<body>
  <div class="container">
    <h2>A Salty Website</h2>
    <img src="./SALT.png" alt="Salt" class="image">
    <?php 
    if (isset($_SESSION['authenticated'])) {
    ?>
      <div class="success">Login Successful</div>
      <h1 style="font-size: larger;">Welcome, here is your special salt shaker:</h1><br>
      <?php print($flag) ?>
    <?php
    } else {
    ?>
        <div class="container login">
          <form method="POST" id="login-container">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required />
            <input
              type="password"
              name="password"
              placeholder="Password"
              required
            />
            <button type="submit">Login</button>
          </form>
        </div>
    <?php } ?>
  </div>
</body>
</html>