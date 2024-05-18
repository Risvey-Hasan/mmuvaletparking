<?php
session_start();
if(!($_SESSION['Admin'])){
	header("location:../artist/login.php");
}