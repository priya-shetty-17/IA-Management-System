<?php
    // Start the session
    session_start();

    session_destroy();
    header('Location: /IA-Management-System/index.html?message=logged_out');
    exit;
?>
