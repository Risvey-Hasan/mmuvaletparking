<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="assets/css/dashboardstyle.css">
    <link rel="stylesheet" href="assets/css/formstyle.css">
    <link rel="stylesheet" href="assets/css/tablestyle.css">
    <link rel="stylesheet" href="assets/css/alertstyle.css">
    <link rel="stylesheet" href="assets/css/chatroom.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title><?php echo isset($pageTitle) ? $pageTitle : " Student Dashboard"; ?></title>
</head>