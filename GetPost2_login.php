<?php 

    $conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);

    $username = $_POST["practitioner_ID"];
    $password_login = $_POST["password"];

    echo "Welcome:".$username.", your password is:". $password_login; 
?>