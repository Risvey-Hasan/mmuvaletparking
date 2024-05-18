<?php
session_start();

unset($_SESSION['Admin']);

session_destroy();
header("location: ../../artist/login.php");