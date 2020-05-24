<?php

session_start();
if(!isset($_SESSION["DNIEmpleado"])) 
{  
    
    header("Location: ../login.html");
}

