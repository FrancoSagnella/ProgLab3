<?php
    session_start();
    if(!isset($_SESSION['DNIEmpleado']))
        header("location: ./login.html");
?>