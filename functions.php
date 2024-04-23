<?php
require "delete_profiles.php";
function logout()
{
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
}
?>