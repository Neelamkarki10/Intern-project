<?php

function authorize($role) {
    require_once 'sessionManager.php';
    initSessionWithTimer();

    if (!isset($_SESSION['user_name']) && ($_SESSION['user_role'] != $role)) {
        $_SESSION['redirect_target'] = $_SERVER['REQUEST_URI'];
        header('Location: '.baseurl().'../index.php');
        exit();
    }
}

function baseurl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol . $domainName . "/";
}

?>