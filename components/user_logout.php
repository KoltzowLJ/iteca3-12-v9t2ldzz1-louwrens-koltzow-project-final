<!--
    Name:       Louwrens Költzow
    Student     Number: V9T2LDZZ1
    Campus:     Pretoria
    Module:     ITECA3-B12: Project Final
 -->
    
<!-- User Logout Actions -->
<?php

include 'connect.php';

session_start();
session_unset();
session_destroy();

header('location:/index.php');

?>