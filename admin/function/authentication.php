<?php
session_start();
if(!($_SESSION['Admin'])){
	header("location:../student/login.php");
}