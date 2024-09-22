<?php
    session_start();
    $_SESSION['id'] = null;
    header("Location: ../../index.php");
    exit();
?>