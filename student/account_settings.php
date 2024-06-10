<?php
$pageTitle = "Account Settings"; 
require_once ("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
?>
<div class="dash-content">
    <div class="overview">
        <div class="container">
        <form id="registrationForm" method="post" action="helpers/account_settings.php" onsubmit="return validateRegiterform()">
        <div class="form-group">
            <h2>Account Settings</h2>
        </div>
           <div class="form-group">
               <?php
                    if(isset($_SESSION["msg"])){
                        echo $_SESSION["msg"];
                    }
                    unset($_SESSION["msg"]);
                ?>
           </div>
            <div class="form-group">
                <label for="password">Old Password:</label>
                <input type="password" id="password" name="OldPassword" required>
            </div>
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="NewPassword" name="NewPassword" required>
            </div>
            <button type="submit">Update Password</button>
        </form>
        </div>
    </div>
</body>
    </div>
<?php require_once("include/footer.php");?>