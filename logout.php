<?php
    session_start();
    session_destroy();

    header("Location: ./login.php");

    echo "<p align=\"center\"> Hello World </p>";
?>