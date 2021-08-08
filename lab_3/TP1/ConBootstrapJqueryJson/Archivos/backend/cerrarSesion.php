<?php
    session_start();
        if(isset($_SESSION['DNIEmpleado']))
        {
            $_SESSION = array();
        }
    header("location: ./../login.php");