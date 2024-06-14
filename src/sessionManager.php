<?php 
function initSessionWithTimer() {
    session_start();

    define('SESSION_TIMEOUT', 1800);
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }

    $_SESSION['last_activity'] = time();
}

function checkIfLoggedIn() {
    if (isset($_SESSION['user_name'])) {
        switch ($_SESSION['user_role']) {
          case 'admin':
            header('Location: .template/admin.html');
            exit();
          case 'teacher':
            header('Location: .template/teacher.html');
            exit();
          case 'student':
            header('Location: .template/student.html');
            exit();
          default:
            echo "ERROR 403: Fake sessions are forbidden!";
            exit();
        }
      }
}

function checkForRedirection() {
    if (isset($_SESSION['redirect_target'])) {
        $redirect_url = $_SESSION['redirect_target'];
        unset($_SESSION['redirect_target']);
        header("Location: $redirect_url");
        exit();
      }
}
?>