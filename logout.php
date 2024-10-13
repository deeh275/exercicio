<?php
session_start(); 

if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['token']);
    
    session_destroy();
}

header('Location: list_contacts.php');
exit();
?>
