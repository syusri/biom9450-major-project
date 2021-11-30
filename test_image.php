<?php
    $conn = odbc_connect('z5254640', '', '',SQL_CUR_USE_ODBC);
    $sql = "SELECT Patient.Image FROM Patient WHERE PatientID=001";
    $rs = odbc_exec($conn,$sql);

    while ($row = odbc_fetch_array($rs)){
        

    } 
?>