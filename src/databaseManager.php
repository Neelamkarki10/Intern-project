<?php

function establishConnectionToDB() {
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'mmc';
    
    return new mysqli($server, $username, $password, $db_name);
}

?>