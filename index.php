<?php
require_once 'src/sessionManager.php';
initSessionWithTimer();
checkIfLoggedIn();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['csrf_token']) || ($_POST['csrf_token'] != $_SESSION['csrf_token'])) {
      die('CSRF token validation failed');
    }
    if (!isset($_SESSION['user_name'])) {
      require_once 'src/databaseManager.php';
      $conn = establishConnectionToDB();
      if(!$conn) {
          die('Connection to database failed!');
      }
  
      $username = $_POST['username'];
      $password = $_POST['password'];
  
      $stmt = $conn->prepare("SELECT `name`, `role`, `hashed_secret` FROM `users` WHERE `uuid` = ?");
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['hashed_secret'])) {
          $_SESSION['user_name'] = $row['name'];
          $_SESSION['user_role'] = $row['role'];
          
          session_regenerate_id(true);
          checkForRedirection();
  
          switch ($row['role']) {
            case 'admin':
              header('Location: .template/admin.html');
              exit();
            case 'teacher':
              header('Location: .template/teacher.html');
              exit();
            case 'student':
              header('Location: .template/student.html');
              exit();
          }
        }
        else {
          $error = "Invalid password";
        }
      } else {
        $error = "Invalid username";
      }
    }
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal | Mechi Multiple Campus</title>
    <link rel="stylesheet" href="./res/css/theme.css" />
    <link rel="stylesheet" href="./res/css/index.css" />
    <link rel="icon" type="image/x-icon" href="./res/img/favicon.png" />
  </head>
  <body>
    <main>
      <section>
        <img src="./res/img/TU-Logo.svg.png" alt="TU Logo" />
        <h1>Mechi Multiple Campus</h1>
      </section>
      <section id="login">
        <form action="" method="POST">
        <?php
            echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
          ?>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="username"
            autofocus
            required
          />
          <input
            type="password"
            id="password"
            name="password"
            placeholder="password"
            required
          />
          <button type="submit">Login</button>
        </form>
      </section>
    </main>
  </body>
</html>
