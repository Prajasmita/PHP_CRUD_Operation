<?php

// Create connection
$conn = new mysqli("localhost","root","root","assignment4");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: ".$conn->connect_error);
}
?>