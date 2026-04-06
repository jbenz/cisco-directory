<?php

/////////////////////////////////////////////////////////////////////////////////////////
/*
    MySQL Authorization Information
    Establish DB Connection
    Entered: 04/06/2026
*/
$installed = 'false'; //to be able to reinstall, change this to false
$db = mysqli_connect('localhost', 'directory', 'password', 'cisco-directory');
if (!$db) die('DB connect failed: ' . mysqli_connect_error());

/////////////////////////////////////////////////////////////////////////////////////////
?>