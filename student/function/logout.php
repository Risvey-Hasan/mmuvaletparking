<?php
session_start();

unset($_SESSION['User']);

session_destroy();

header("location:../../index.php");