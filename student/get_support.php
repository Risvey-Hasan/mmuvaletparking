<?php 
$pageTitle = "Get Support";
require_once ("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
?>
<div class="dash-content">
    <div class="overview">
        <div class="container">
            <form id="registrationForm" method="post" action="helpers/get_support.php" onsubmit="return validateRegiterform()">
                <div class="form-group">
                    <h2>Get Support</h2>
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
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php require_once("include/footer.php"); ?>
