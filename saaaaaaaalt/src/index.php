<?php 
error_reporting(0);
ini_set('display_errors', 0);

session_start();

$admin_password = 'chaewon';
$random_string = 'an_additional_random_string_to_leengthen_the_hash_for_some_reason';
$flag = 'CSS{trunc4t3d_p4ssw0rds_4r3_n0t_4w3s0m3}';

if (isset($_GET['username']) && isset($_GET['password'])) {
  $username = $_GET['username'];
  $password = $_GET['password'];

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
          <form method="GET" id="login-container">
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